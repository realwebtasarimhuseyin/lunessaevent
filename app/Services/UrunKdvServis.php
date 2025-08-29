<?php

namespace App\Services;

use App\Models\UrunKdv;
use App\Bases\UrunKdvBase;
use App\Models\UrunKdvDil;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class UrunKdvServis
{
    public static function veriAlma($arama = 0)
    {
        $builder = UrunKdvBase::veriIsleme();

        /* if ($arama !== "") {
            $builder->whereAny(['gd.baslik', 'gd.icerik'], 'like', "%$arama%");
        } */

        return $builder;
    }

    public static function ekle($veri)
    {
        try {
            return DB::transaction(function () use ($veri) {
                UrunKdvBase::ekle($veri);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Urun Kdv kayıt edilemedi : ' . $th->getMessage());
        }
    }

    public static function duzenle(UrunKdv $urunKdv, $veri)
    {
        try {
            return DB::transaction(function () use ($urunKdv, $veri) {

                $guncelUrunKdv = UrunKdvBase::duzenle($urunKdv, $veri);
                return $guncelUrunKdv;
            });
        } catch (\Throwable $th) {
            throw new \Exception('Urun Kdv düzenlenemedi : ' . $th->getMessage());
        }
    }

    public static function sil(UrunKdv $urunKdv)
    {
        try {
            return DB::transaction(function () use ($urunKdv) {
                UrunKdvBase::sil($urunKdv);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Urun Kdv silinemedi : ' . $th->getMessage());
        }
    }
}
