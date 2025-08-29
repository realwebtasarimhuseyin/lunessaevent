<?php

namespace App\Bases;

use App\Models\Ayar;


class AyarBase
{


    public static function duzenle(Ayar $ayar, $veri)
    {
        $guncelAyar = $ayar->update($veri);
        return $guncelAyar;
    }


}
