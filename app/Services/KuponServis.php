<?php

namespace App\Services;

use App\Models\Kupon;
use App\Bases\KuponBase;
use App\Models\KuponDil;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class KuponServis
{
    public static function veriAlma($arama = 0)
    {
        $builder = KuponBase::veriIsleme();

        return $builder;
    }

    public static function kontrol($kuponKod)
    {

        return $kupon = Kupon::where("kod", $kuponKod)->where("durum", true)
            ->where('baslangic_tarih', '<=', now())
            ->where('bitis_tarih', '>=', now())
            ->where('adet', '>', '0')
            ->first();
    }

    public static function stokAzalt($kuponKod)
    {
        $kupon = Kupon::where('kod', $kuponKod)->first();

        if ($kupon && $kupon->adet > 0) {
            $kupon->adet -= 1;
            $kupon->save();
        }
    }


    public static function ekle($veri)
    {
        try {
            return DB::transaction(function () use ($veri) {
                KuponBase::ekle($veri);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Kupon kayıt edilemedi : ' . $th->getMessage());
        }
    }

    public static function duzenle(Kupon $kupon, $veri)
    {
        try {
            return DB::transaction(function () use ($kupon, $veri) {
                KuponBase::duzenle($kupon, $veri);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Kupon düzenlenemedi : ' . $th->getMessage());
        }
    }

    public static function sil(Kupon $kupon)
    {
        try {
            return DB::transaction(function () use ($kupon) {
                KuponBase::sil($kupon);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Kupon silinemedi : ' . $th->getMessage());
        }
    }
}
