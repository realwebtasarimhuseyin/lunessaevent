<?php

namespace App\Services;

use App\Models\UrunVaryantOzellik;
use App\Bases\UrunVaryantOzellikBase;
use App\Models\UrunVaryantOzellikDil;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class UrunVaryantOzellikServis
{
    public static function veriAlma($arama = 0)
    {
        $builder = UrunVaryantOzellikBase::veriIsleme();

        /* if ($arama !== "") {
            $builder->whereAny(['gd.baslik', 'gd.icerik'], 'like', "%$arama%");
        } */

        return $builder;
    }

    public static function tekliVeri($urunVaryantOzellikId)
    {
        $builder = UrunVaryantOzellikBase::veriIsleme();
        $builder->where("urun_varyant_ozellik.id", $urunVaryantOzellikId)->first();
    }

    public static function ekle($veri, $request)
    {
        try {
            return DB::transaction(function () use ($veri, $request) {
                $desteklenenDil = Config::get('app.supported_locales');

                $urunVaryantOzellik = UrunVaryantOzellikBase::ekle($veri);

                foreach ($desteklenenDil as $dil) {
                    UrunVaryantOzellikDil::create([
                        'urun_varyant_ozellik_id' => $urunVaryantOzellik->id,
                        'isim' => $request->input("isim_$dil"),
                        'dil' => $dil,
                    ]);
                }

            });
        } catch (\Throwable $th) {
            throw new \Exception('Urun Kategori kayıt edilemedi : ' . $th->getMessage());
        }
    }

    public static function duzenle(UrunVaryantOzellik $urunVaryantOzellik, $veri,$request)
    {
        try {
            return DB::transaction(function () use ($urunVaryantOzellik, $veri,$request) {

                UrunVaryantOzellikDil::where('urun_varyant_ozellik_id', $urunVaryantOzellik->id)->delete();
                $desteklenenDil = Config::get('app.supported_locales');

                foreach ($desteklenenDil as $dil) {
                    UrunVaryantOzellikDil::create([
                        'urun_varyant_ozellik_id' => $urunVaryantOzellik->id,
                        'isim' => $request->input("isim_$dil"),
                        'dil' => $dil,
                    ]);
                }

                $guncelUrunVaryantOzellik = UrunVaryantOzellikBase::duzenle($urunVaryantOzellik, $veri);
                return $guncelUrunVaryantOzellik;

            });
        } catch (\Throwable $th) {
            throw new \Exception('Urun Varyant Ozellik düzenlenemedi : ' . $th->getMessage());
        }
    }



    public static function siralamaDuzenle($varyantOzellikler)
    {
        try {
            return DB::transaction(function () use ($varyantOzellikler) {

                foreach ($varyantOzellikler as $varyantOzellik) {
                    $varyantOzellikDetay = UrunVaryantOzellik::firstWhere('id', $varyantOzellik["id"]);

                    $varyantOzellikDetay->sira_no = $varyantOzellik["sira"];
                    $varyantOzellikDetay->save();
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }



    public static function sil(UrunVaryantOzellik $urunVaryantOzellik)
    {
        try {
            return DB::transaction(function () use ($urunVaryantOzellik) {
                UrunVaryantOzellikBase::sil($urunVaryantOzellik);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Urun Varyant Ozellik silinemedi : ' . $th->getMessage());
        }
    }
}
