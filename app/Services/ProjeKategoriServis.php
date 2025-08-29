<?php

namespace App\Services;

use App\Models\ProjeKategori;
use App\Bases\ProjeKategoriBase;
use App\Models\ProjeKategoriDil;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjeKategoriServis
{
    public static function veriAlma($pasifProjeKategori = 0)
    {
        $builder = ProjeKategoriBase::veriIsleme();

        if ($pasifProjeKategori > 0) {
            $builder->where("proje_kategori.id", "!=", $pasifProjeKategori);
        }

        return $builder;
    }

    public static function ekle($veri, $request)
    {
        try {
            return DB::transaction(function () use ($veri, $request) {

                $desteklenenDil = Config::get('app.supported_locales');
                self::resimKaydet($request, "tr", $veri);
                $projeKategori = ProjeKategoriBase::ekle($veri);
                self::projeKategoriDilBilgileriniEkle($request, $projeKategori, $desteklenenDil);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Proje Kategori kayıt edilemedi : ' . $th->getMessage());
        }
    }

    public static function duzenle(ProjeKategori $projeKategori, $veri, $request)
    {
        try {
            return DB::transaction(function () use ($projeKategori, $veri, $request) {
                ProjeKategoriDil::where('proje_kategori_id', $projeKategori->id)->delete();

                $desteklenenDil = Config::get('app.supported_locales');

                self::resimKaydet($request, 'tr', $veri, $projeKategori);
                self::projeKategoriDilBilgileriniEkle($request, $projeKategori, $desteklenenDil);

                $guncelProjeKategori = ProjeKategoriBase::duzenle($projeKategori, $veri);
                return $guncelProjeKategori;
            });
        } catch (\Throwable $th) {
            throw new \Exception('ProjeKategori düzenlenemedi : ' . $th->getMessage());
        }
    }

    private static function resimKaydet($request, $varsayilanDil, &$veri, $kategori = null)
    {
        $resimServis = new ProjeKategoriResimServis();

        if ($request->hasFile('kategoriResim')) {
            $resim = $request->file("kategoriResim");
            if ($resim instanceof \Illuminate\Http\UploadedFile) {
                $veri["resim_url"] = $resimServis->resmiKaydet($resim, ProjeKategori::slugUret($request->input("isim_$varsayilanDil")));
            }
        } else {
            if (!empty($kategori) && !empty($kategori->resim_url)) {
                if (Storage::exists($kategori->resim_url)) {
                    Storage::delete($kategori->resim_url);
                    $veri["resim_url"] = null;
                }
            }
        }
    }


    private static function projeKategoriDilBilgileriniEkle($request, $projeKategori, $desteklenenDil)
    {
        foreach ($desteklenenDil as $dil) {
            $slug = ProjeKategori::slugUret($request->input("isim_$dil"));

            ProjeKategoriDil::create([
                'proje_kategori_id' => $projeKategori->id,
                'isim' => $request->input("isim_$dil"),
                'slug' => $slug,
                'dil' => $dil,
            ]);
        }
    }

    public static function siralamaDuzenle($kategoriler)
    {
        try {
            return DB::transaction(function () use ($kategoriler) {

                foreach ($kategoriler as $kategori) {
                    $kategoriDetay = ProjeKategori::firstWhere('id', $kategori["id"]);

                    $kategoriDetay->sira_no = $kategori["sira"];
                    $kategoriDetay->save();
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public static function sil(ProjeKategori $projeKategori)
    {
        try {
            return DB::transaction(function () use ($projeKategori) {
                if (!empty($projeKategori) && !empty($projeKategori->resim_url)) {
                    if (Storage::exists($projeKategori->resim_url)) {
                        Storage::deleteDirectory($projeKategori->resim_url);
                    }
                }

                ProjeKategoriBase::sil($projeKategori);
            });
        } catch (\Throwable $th) {
            throw new \Exception('ProjeKategori silinemedi : ' . $th->getMessage());
        }
    }
}
