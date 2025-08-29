<?php

namespace App\Services;

use App\Models\KatalogKategori;
use App\Bases\KatalogKategoriBase;
use App\Models\KatalogKategoriDil;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KatalogKategoriServis
{
    public static function veriAlma($pasifKatalogKategori = 0)
    {
        $builder = KatalogKategoriBase::veriIsleme();

        if ($pasifKatalogKategori > 0) {
            $builder->where("katalog_kategori.id", "!=", $pasifKatalogKategori);
        }

        return $builder;
    }

    public static function ekle($veri, $request)
    {
        try {
            return DB::transaction(function () use ($veri, $request) {
                $varsayilanDil = Config::get('app.locale');
                $desteklenenDil = Config::get('app.supported_locales');

                self::resimKaydet($request, $varsayilanDil, $veri);

                $katalogKategori = KatalogKategoriBase::ekle($veri);

                self::katalogKategoriDilBilgileriniEkle($request, $katalogKategori, $desteklenenDil);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Katalog Kategori kayıt edilemedi : ' . $th->getMessage());
        }
    }

    public static function duzenle(KatalogKategori $katalogKategori, $veri, $request)
    {
        try {
            return DB::transaction(function () use ($katalogKategori, $veri, $request) {
                $varsayilanDil = Config::get('app.locale');
                $desteklenenDil = Config::get('app.supported_locales');

                KatalogKategoriDil::where('katalog_kategori_id', $katalogKategori->id)->delete();

                self::resimKaydet($request, $varsayilanDil, $veri, $katalogKategori);
                self::katalogKategoriDilBilgileriniEkle($request, $katalogKategori, $desteklenenDil);

                $guncelKatalogKategori = KatalogKategoriBase::duzenle($katalogKategori, $veri);
                return $guncelKatalogKategori;
            });
        } catch (\Throwable $th) {
            throw new \Exception('Katalog Kategori düzenlenemedi : ' . $th->getMessage());
        }
    }


    private static function katalogKategoriDilBilgileriniEkle($request, $katalogKategori, $desteklenenDil)
    {
        foreach ($desteklenenDil as $dil) {
            $slug = KatalogKategori::slugUret($request->input("isim_$dil"));

            KatalogKategoriDil::create([
                'katalog_kategori_id' => $katalogKategori->id,
                'isim' => $request->input("isim_$dil"),
                'slug' => $slug,
                'dil' => $dil,
            ]);
        }
    }

    private static function resimKaydet($request, $varsayilanDil, &$veri, $kategori = null)
    {
        $resimServis = new KatalogKategoriResimServis();

        if ($request->hasFile('kategoriResim')) {
            $resim = $request->file("kategoriResim");
            if ($resim instanceof \Illuminate\Http\UploadedFile) {
                $veri["resim_url"] = $resimServis->resmiKaydet($resim, KatalogKategori::slugUret($request->input("isim_$varsayilanDil")));
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

    public static function siralamaDuzenle($kategoriler)
    {
        try {
            return DB::transaction(function () use ($kategoriler) {

                foreach ($kategoriler as $kategori) {
                    $kategoriDetay = KatalogKategori::firstWhere('id', $kategori["id"]);

                    $kategoriDetay->sira_no = $kategori["sira"];
                    $kategoriDetay->save();
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
    public static function sil(KatalogKategori $katalogKategori)
    {
        try {
            return DB::transaction(function () use ($katalogKategori) {

                if (!empty($katalogKategori) && !empty($katalogKategori->resim_url)) {
                    if (Storage::exists($katalogKategori->resim_url)) {
                        Storage::delete($katalogKategori->resim_url);
                    }
                }

                KatalogKategoriBase::sil($katalogKategori);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Katalog Kategori silinemedi : ' . $th->getLine());
        }
    }
}
