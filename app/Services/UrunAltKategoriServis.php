<?php

namespace App\Services;

use App\Models\UrunAltKategori;
use App\Bases\UrunAltKategoriBase;
use App\Models\UrunAltKategoriDil;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class UrunAltKategoriServis
{
    public static function veriAlma($arama = "", $urunKategori = 0)
    {
        $builder = UrunAltKategoriBase::veriIsleme();

        if ($urunKategori > 0) {
            $builder->where("urun_kategori_id", $urunKategori);
        }

        return $builder;
    }

    public static function tekliVeri($urunAltKategoriId)
    {
        $builder = UrunAltKategoriBase::veriIsleme();
        $builder->where("urun_alt_kategori.id", $urunAltKategoriId)->first();
    }

    public static function ekle($veri, $request)
    {
        try {
            return DB::transaction(function () use ($veri, $request) {
                $desteklenenDil = Config::get('app.supported_locales');
                $urunAltKategori = UrunAltKategoriBase::ekle($veri);

                self::urunAltKategoriDilBilgileriniEkle($request, $urunAltKategori, $desteklenenDil);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Urun Kategori kayıt edilemedi : ' . $th->getMessage());
        }
    }

    public static function duzenle(UrunAltKategori $urunAltKategori, $veri, $request)
    {
        try {
            return DB::transaction(function () use ($urunAltKategori, $veri, $request) {
                UrunAltKategoriDil::where('urun_alt_kategori_id', $urunAltKategori->id)->delete();
                $desteklenenDil = Config::get('app.supported_locales');

                self::urunAltKategoriDilBilgileriniEkle($request, $urunAltKategori, $desteklenenDil);

                $guncelUrunKategori = UrunAltKategoriBase::duzenle($urunAltKategori, $veri);
                return $guncelUrunKategori;
            });
        } catch (\Throwable $th) {
            throw new \Exception('Urun Alt Kategori düzenlenemedi : ' . $th->getMessage());
        }
    }


    private static function urunAltKategoriDilBilgileriniEkle($request, $urunAltKategori, $desteklenenDil)
    {
        foreach ($desteklenenDil as $dil) {
            $slug = UrunAltKategori::slugUret($request->input("isim_$dil"));

            UrunAltKategoriDil::create([
                'urun_alt_kategori_id' => $urunAltKategori->id,
                'isim' => $request->input("isim_$dil"),
                'slug' => $slug,
                'dil' => $dil,
            ]);
        }
    }


    public static function siralamaDuzenle($altKategoriler)
    {
        try {
            return DB::transaction(function () use ($altKategoriler) {

                foreach ($altKategoriler as $altKategori) {
                    $altKategoriDetay = UrunAltKategori::firstWhere('id', $altKategori["id"]);

                    $altKategoriDetay->sira_no = $altKategori["sira"];
                    $altKategoriDetay->save();
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public static function sil(UrunAltKategori $urunAltKategori)
    {
        try {
            return DB::transaction(function () use ($urunAltKategori) {
                UrunAltKategoriBase::sil($urunAltKategori);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Urun Alt Kategori silinemedi : ' . $th->getMessage());
        }
    }
}
