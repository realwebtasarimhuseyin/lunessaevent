<?php

namespace App\Bases;

use App\Models\DovizYonetim;

class DovizYonetimBase
{
    public static function veriIsleme()
    {
        return DovizYonetim::select('doviz_yonetim.*');
    }

    public static function duzenle(DovizYonetim $dovizYonetim, $veri)
    {
        $guncelDoviz = $dovizYonetim->update($veri);
        return $guncelDoviz;
    }
}
