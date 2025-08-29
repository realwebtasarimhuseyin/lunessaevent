<?php

namespace App\Services;

use App\Models\UrunVaryant;
use App\Bases\UrunVaryantBase;
use App\Models\UrunVaryantDil;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class UrunVaryantServis
{
    public static function veriAlma($arama = 0)
    {
        $builder = UrunVaryantBase::veriIsleme();

        /* if ($arama !== "") {
            $builder->whereAny(['gd.baslik', 'gd.icerik'], 'like', "%$arama%");
        } */

        return $builder;
    }

    public static function tekliVeri($urunVaryantId)
    {
        $builder = UrunVaryantBase::veriIsleme();
        $builder->where("urun_varyant.id", $urunVaryantId)->first();
    }

    public static function ekle($veri, $request)
    {
        try {
            return DB::transaction(function () use ($veri, $request) {
                $desteklenenDil = Config::get('app.supported_locales');
                $urunVaryant = UrunVaryantBase::ekle($veri);

                foreach ($desteklenenDil as $dil) {
                    UrunVaryantDil::create([
                        'urun_varyant_id' => $urunVaryant->id,
                        'isim' => $request->input("isim_$dil"),
                        'dil' => $dil,
                    ]);
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception('Urun Kategori kayıt edilemedi : ' . $th->getMessage());
        }
    }

    public static function duzenle(UrunVaryant $urunVaryant, $veri, $request)
    {
        try {
            return DB::transaction(function () use ($urunVaryant, $veri, $request) {
                UrunVaryantDil::where('urun_varyant_id', $urunVaryant->id)->delete();
                $desteklenenDil = Config::get('app.supported_locales');

                foreach ($desteklenenDil as $dil) {
                    UrunVaryantDil::create([
                        'urun_varyant_id' => $urunVaryant->id,
                        'isim' => $request->input("isim_$dil"),
                        'dil' => $dil,
                    ]);
                }

                $guncelUrunVaryant = UrunVaryantBase::duzenle($urunVaryant, $veri);
                return $guncelUrunVaryant;
            });
        } catch (\Throwable $th) {
            throw new \Exception('UrunVaryant düzenlenemedi : ' . $th->getMessage());
        }
    }

    public static function siralamaDuzenle($varyantlar)
    {
        try {
            return DB::transaction(function () use ($varyantlar) {

                foreach ($varyantlar as $varyant) {
                    $varyantDetay = UrunVaryant::firstWhere('id', $varyant["id"]);

                    $varyantDetay->sira_no = $varyant["sira"];
                    $varyantDetay->save();
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }



    public static function sil(UrunVaryant $urunVaryant)
    {
        try {
            return DB::transaction(function () use ($urunVaryant) {
                UrunVaryantBase::sil($urunVaryant);
            });
        } catch (\Throwable $th) {
            throw new \Exception('UrunVaryant silinemedi : ' . $th->getMessage());
        }
    }
}
