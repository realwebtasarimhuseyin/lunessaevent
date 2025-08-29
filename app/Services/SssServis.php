<?php

namespace App\Services;

use App\Models\Sss;
use App\Bases\SssBase;
use App\Models\SssDil;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class SssServis
{
    public static function veriAlma($arama = 0)
    {
        $builder = SssBase::veriIsleme();

        return $builder;
    }

    public static function ekle($veri, $request)
    {
        try {
            return DB::transaction(function () use ($veri, $request) {
                $desteklenenDil = Config::get('app.supported_locales');

                $sss = SssBase::ekle($veri);

                foreach ($desteklenenDil as $dil) {
                    SssDil::create([
                        'sss_id' => $sss->id,
                        'baslik' => $request->input("baslik_$dil"),
                        'icerik' => $request->input("icerik_$dil"),
                        'dil' => $dil,
                    ]);
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception('Sss kayıt edilemedi : ' . $th->getMessage());
        }
    }

    public static function duzenle(Sss $sss, $veri, $request)
    {
        try {
            return DB::transaction(function () use ($sss, $veri, $request) {
                $desteklenenDil = Config::get('app.supported_locales');
                SssDil::where('sss_id', $sss->id)->delete();
                foreach ($desteklenenDil as $dil) {
                    SssDil::create([
                        'sss_id' => $sss->id,
                        'baslik' => $request->input("baslik_$dil"),
                        'icerik' => $request->input("icerik_$dil"),
                        'dil' => $dil,
                    ]);
                }

                SssBase::duzenle($sss, $veri);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Sss düzenlenemedi : ' . $th->getMessage());
        }
    }

    public static function siralamaDuzenle($sssler)
    {
        try {
            return DB::transaction(function () use ($sssler) {

                foreach ($sssler as $sss) {
                    $sssDetay = Sss::firstWhere('id', $sss["id"]);

                    $sssDetay->sira_no = $sss["sira"];
                    $sssDetay->save();
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public static function sil(Sss $sss)
    {
        try {
            return DB::transaction(function () use ($sss) {
                SssBase::sil($sss);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Sss silinemedi : ' . $th->getMessage());
        }
    }
}
