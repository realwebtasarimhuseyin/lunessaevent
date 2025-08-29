<?php

namespace App\Services;

use App\Models\Duyuru;
use App\Bases\DuyuruBase;
use App\Models\DuyuruDil;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DuyuruServis
{
    public static function veriAlma($arama = 0)
    {
        $builder = DuyuruBase::veriIsleme();

        return $builder;
    }

    public static function tekliVeri($duyuruId)
    {
        $builder = DuyuruBase::veriIsleme();
        $builder->where("b.id", $duyuruId)->first();
    }

    public static function ekle($veri, $request)
    {
        try {
            return DB::transaction(function () use ($veri, $request) {
                $desteklenenDil = Config::get('app.supported_locales');

                $duyuru = DuyuruBase::ekle($veri);

                foreach ($desteklenenDil as $dil) {
                    DuyuruDil::create([
                        'duyuru_id' => $duyuru->id,
                        'icerik' => $request->input("icerik_$dil"),
                        'dil' => $dil,
                    ]);
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception('Duyuru kayıt edilemedi : ' . $th->getMessage());
        }
    }

    public static function duzenle(Duyuru $duyuru, $veri,$request)
    {
        try {
            return DB::transaction(function () use ($duyuru, $veri,$request) {

                DuyuruDil::where('duyuru_id', $duyuru->id)->delete();

                $desteklenenDil = Config::get('app.supported_locales');


                foreach ($desteklenenDil as $dil) {
                    DuyuruDil::create([
                        'duyuru_id' => $duyuru->id,
                        'icerik' => $request->input("icerik_$dil"),
                        'dil' => $dil,
                    ]);
                }

                $guncelDuyuru = DuyuruBase::duzenle($duyuru, $veri);
                return $guncelDuyuru;
            });
        } catch (\Throwable $th) {
            throw new \Exception('Duyuru düzenlenemedi : ' . $th->getMessage());
        }
    }

    public static function siralamaDuzenle($duyurular)
    {
        try {
            return DB::transaction(function () use ($duyurular) {

                foreach ($duyurular as $duyuru) {
                    $duyuruDetay = Duyuru::firstWhere('id', $duyuru["id"]);

                    $duyuruDetay->sira_no = $duyuru["sira"];
                    $duyuruDetay->save();
                }
                
            });
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public static function sil(Duyuru $duyuru)
    {
        try {
            return DB::transaction(function () use ($duyuru) {
                DuyuruBase::sil($duyuru);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Duyuru silinemedi : ' . $th->getMessage());
        }
    }
}
