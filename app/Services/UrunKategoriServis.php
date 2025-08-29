<?php

namespace App\Services;

use App\Models\UrunKategori;
use App\Bases\UrunKategoriBase;
use App\Models\UrunKategoriDil;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UrunKategoriServis
{
    public static function veriAlma($pasifUrunKategori = 0)
    {
        $builder = UrunKategoriBase::veriIsleme();

        if ($pasifUrunKategori > 0) {
            $builder->where("urun_kategori.id", "!=", $pasifUrunKategori);
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

                $urunKategori = UrunKategoriBase::ekle($veri);

                self::urunKategoriDilBilgileriniEkle($request, $urunKategori, $desteklenenDil);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Urun Kategori kayıt edilemedi : ' . $th->getMessage());
        }
    }

    public static function duzenle(UrunKategori $urunKategori, $veri, $request)
    {
        try {
            return DB::transaction(function () use ($urunKategori, $veri, $request) {
                $varsayilanDil = Config::get('app.locale');
                $desteklenenDil = Config::get('app.supported_locales');

                UrunKategoriDil::where('urun_kategori_id', $urunKategori->id)->delete();

                self::resimKaydet($request, $varsayilanDil, $veri, $urunKategori);
                self::urunKategoriDilBilgileriniEkle($request, $urunKategori, $desteklenenDil);

                $guncelUrunKategori = UrunKategoriBase::duzenle($urunKategori, $veri);
                return $guncelUrunKategori;
            });
        } catch (\Throwable $th) {
            throw new \Exception('UrunKategori düzenlenemedi : ' . $th->getMessage());
        }
    }


    private static function urunKategoriDilBilgileriniEkle($request, $urunKategori, $desteklenenDil)
    {
        foreach ($desteklenenDil as $dil) {
            $slug = UrunKategori::slugUret($request->input("isim_$dil"));

            UrunKategoriDil::create([
                'urun_kategori_id' => $urunKategori->id,
                'isim' => $request->input("isim_$dil"),
                'slug' => $slug,
                'dil' => $dil,
            ]);
        }
    }

    private static function resimKaydet($request, $varsayilanDil, &$veri, $kategori = null)
    {
        $resimServis = new UrunKategoriResimServis();

        if ($request->hasFile('kategoriResim')) {
            $resim = $request->file("kategoriResim");
            if ($resim instanceof \Illuminate\Http\UploadedFile) {
                $veri["resim_url"] = $resimServis->resmiKaydet($resim, UrunKategori::slugUret($request->input("isim_$varsayilanDil")));
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
                    $kategoriDetay = UrunKategori::firstWhere('id', $kategori["id"]);

                    $kategoriDetay->sira_no = $kategori["sira"];
                    $kategoriDetay->save();
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
    public static function sil(UrunKategori $urunKategori)
    {
        try {
            return DB::transaction(function () use ($urunKategori) {
                if (!empty($urunKategori) && !empty($urunKategori->resim_url)) {
                    if (Storage::exists($urunKategori->resim_url)) {
                        Storage::deleteDirectory($urunKategori->resim_url);
                    }
                }

                UrunKategoriBase::sil($urunKategori);
            });
        } catch (\Throwable $th) {
            throw new \Exception('UrunKategori silinemedi : ' . $th->getMessage());
        }
    }
}
