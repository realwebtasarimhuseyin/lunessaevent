<?php

namespace App\Services;

use App\Models\Yorum;
use App\Bases\YorumBase;
use App\Models\YorumDil;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class YorumServis
{
    public static function veriAlma($arama = 0)
    {
        $builder = YorumBase::veriIsleme();

        return $builder;
    }

    public static function ekle($veri, $request)
    {
        try {
            return DB::transaction(function () use ($veri, $request) {
                $desteklenenDil = Config::get('app.supported_locales');

                $veri["resim_url"] = "-";
                $yorum = YorumBase::ekle($veri);

                foreach ($desteklenenDil as $dil) {
                    YorumDil::create([
                        'yorum_id' => $yorum->id,
                        'icerik' => $request->input("icerik_$dil"),
                        'dil' => $dil,
                    ]);
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception('Yorum kayıt edilemedi : ' . $th->getMessage());
        }
    }

    public static function duzenle(Yorum $yorum, $veri, $request)
    {
        try {
            return DB::transaction(function () use ($yorum, $veri, $request) {

                YorumDil::where('yorum_id', $yorum->id)->delete();

                $desteklenenDil = Config::get('app.supported_locales');

                $veri["resim_url"] = "-";
                
                foreach ($desteklenenDil as $dil) {
                    YorumDil::create([
                        'yorum_id' => $yorum->id,
                        'icerik' => $request->input("icerik_$dil"),
                        'dil' => $dil,
                    ]);
                }

                $guncelYorum = YorumBase::duzenle($yorum, $veri);
                return $guncelYorum;
            });
        } catch (\Throwable $th) {
            throw new \Exception('Yorum düzenlenemedi : ' . $th->getMessage());
        }
    }

    public static function sil(Yorum $yorum)
    {
        try {
            return DB::transaction(function () use ($yorum) {
                YorumBase::sil($yorum);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Yorum silinemedi : ' . $th->getMessage());
        }
    }
}
