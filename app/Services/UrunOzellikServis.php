<?php

namespace App\Services;

use App\Models\UrunOzellik;
use App\Bases\UrunOzellikBase;
use App\Models\UrunOzellikDil;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class UrunOzellikServis
{
    public static function veriAlma($arama = 0)
    {
        $builder = UrunOzellikBase::veriIsleme();
        return $builder;
    }

    public static function ekle($veri, $request)
    {
        try {
            return DB::transaction(function () use ($veri, $request) {
                $desteklenenDil = Config::get('app.supported_locales');
                $urunOzellik = UrunOzellikBase::ekle($veri);

                foreach ($desteklenenDil as $dil) {
                    UrunOzellikDil::create([
                        'urun_ozellik_id' => $urunOzellik->id,
                        'isim' => $request->input("isim_$dil"),
                        'dil' => $dil,
                    ]);
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception('Urun Ozellik kayıt edilemedi : ' . $th->getMessage());
        }
    }

    public static function duzenle(UrunOzellik $urunOzellik, $veri, $request)
    {
        try {
            return DB::transaction(function () use ($urunOzellik, $veri, $request) {
                UrunOzellikDil::where('urun_ozellik_id', $urunOzellik->id)->delete();
                $desteklenenDil = Config::get('app.supported_locales');

                foreach ($desteklenenDil as $dil) {
                    UrunOzellikDil::create([
                        'urun_ozellik_id' => $urunOzellik->id,
                        'isim' => $request->input("isim_$dil"),
                        'dil' => $dil,
                    ]);
                }

                $guncelUrunOzellik = UrunOzellikBase::duzenle($urunOzellik, $veri);
                return $guncelUrunOzellik;
            });
        } catch (\Throwable $th) {
            throw new \Exception('Urun Ozellik düzenlenemedi : ' . $th->getMessage());
        }
    }

    public static function siralamaDuzenle($ozellikler)
    {
        try {
            return DB::transaction(function () use ($ozellikler) {

                foreach ($ozellikler as $ozellik) {
                    $ozellikDetay = UrunOzellik::firstWhere('id', $ozellik["id"]);

                    $ozellikDetay->sira_no = $ozellik["sira"];
                    $ozellikDetay->save();
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public static function sil(UrunOzellik $urunOzellik)
    {
        try {
            return DB::transaction(function () use ($urunOzellik) {
                UrunOzellikBase::sil($urunOzellik);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Urun Ozellik silinemedi : ' . $th->getMessage());
        }
    }
}
