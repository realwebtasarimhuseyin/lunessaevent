<?php

namespace App\Services;

use App\Models\DovizYonetim;
use App\Bases\DovizYonetimBase;
use Illuminate\Support\Facades\DB;

class DovizYonetimServis
{

    public static function veriAlma()
    {
        $builder = DovizYonetimBase::veriIsleme();
        return $builder;
    }

    public static function duzenle(DovizYonetim $dovizYonetim, $veri)
    {
        try {
            return DB::transaction(function () use ($dovizYonetim, $veri) {

                DovizYonetimBase::duzenle($dovizYonetim, $veri);

            });
        } catch (\Throwable $th) {
            throw new \Exception('Doviz Yonetim düzenlenemedi : ' . $th->getMessage());
        }
    }
}
