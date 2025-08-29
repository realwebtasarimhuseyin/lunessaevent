<?php

namespace App\Services;

use App\Models\Bulten;
use App\Bases\BultenBase;
use Illuminate\Support\Facades\DB;

class BultenServis
{
    public static function veriAlma()
    {
        $builder = BultenBase::veriIsleme();
        return $builder;
    }

    public static function ekle($veri)
    {
        try {
            return DB::transaction(function () use ($veri) {

                BultenBase::ekle($veri);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Bulten kayıt edilemedi : ' . $th->getMessage());
        }
    }

    public static function sil(Bulten $iletisimForm)
    {
        try {
            return DB::transaction(function () use ($iletisimForm) {
                BultenBase::sil($iletisimForm);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Bulten silinemedi : ' . $th->getMessage());
        }
    }
}
