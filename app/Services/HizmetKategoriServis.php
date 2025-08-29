<?php

namespace App\Services;

use App\Models\HizmetKategori;
use App\Bases\HizmetKategoriBase;
use App\Models\HizmetKategoriDil;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HizmetKategoriServis
{
    public static function veriAlma($pasifHizmetKategori = 0)
    {
        $builder = HizmetKategoriBase::veriIsleme();

        if ($pasifHizmetKategori > 0) {
            $builder->where("hizmet_kategori.id", "!=", $pasifHizmetKategori);
        }

        return $builder;
    }

    public static function ekle($veri, $request)
    {
        try {
            return DB::transaction(function () use ($veri, $request) {

                $desteklenenDil = Config::get('app.supported_locales');
                self::resimKaydet($request, "tr", $veri);
                $hizmetKategori = HizmetKategoriBase::ekle($veri);
                self::hizmetKategoriDilBilgileriniEkle($request, $hizmetKategori, $desteklenenDil);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Hizmet Kategori kayıt edilemedi : ' . $th->getMessage());
        }
    }

    public static function duzenle(HizmetKategori $hizmetKategori, $veri, $request)
    {
        try {
            return DB::transaction(function () use ($hizmetKategori, $veri, $request) {

                HizmetKategoriDil::where('hizmet_kategori_id', $hizmetKategori->id)->delete();

                $desteklenenDil = Config::get('app.supported_locales');

                self::resimKaydet($request, 'tr', $veri, $hizmetKategori);
                self::hizmetKategoriDilBilgileriniEkle($request, $hizmetKategori, $desteklenenDil);

                $guncelHizmetKategori = HizmetKategoriBase::duzenle($hizmetKategori, $veri);
                return $guncelHizmetKategori;
            });
        } catch (\Throwable $th) {
            throw new \Exception('HizmetKategori düzenlenemedi : ' . $th->getMessage());
        }
    }

    private static function resimKaydet($request, $varsayilanDil, &$veri, $kategori = null)
    {
        $resimServis = new HizmetKategoriResimServis();

        if ($request->hasFile('kategoriResim')) {
            $resim = $request->file("kategoriResim");
            if ($resim instanceof \Illuminate\Http\UploadedFile) {
                $veri["resim_url"] = $resimServis->resmiKaydet($resim, HizmetKategori::slugUret($request->input("isim_$varsayilanDil")));
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


    private static function hizmetKategoriDilBilgileriniEkle($request, $hizmetKategori, $desteklenenDil)
    {
        foreach ($desteklenenDil as $dil) {
            $slug = HizmetKategori::slugUret($request->input("isim_$dil"));

            HizmetKategoriDil::create([
                'hizmet_kategori_id' => $hizmetKategori->id,
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
                    $kategoriDetay = HizmetKategori::firstWhere('id', $kategori["id"]);

                    $kategoriDetay->sira_no = $kategori["sira"];
                    $kategoriDetay->save();
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
    public static function sil(HizmetKategori $hizmetKategori)
    {
        try {
            return DB::transaction(function () use ($hizmetKategori) {
                if (!empty($hizmetKategori) && !empty($hizmetKategori->resim_url)) {
                    if (Storage::exists($hizmetKategori->resim_url)) {
                        Storage::delete($hizmetKategori->resim_url);
                    }
                }

                HizmetKategoriBase::sil($hizmetKategori);
            });
        } catch (\Throwable $th) {
            throw new \Exception('HizmetKategori silinemedi : ' . $th->getMessage());
        }
    }
}
