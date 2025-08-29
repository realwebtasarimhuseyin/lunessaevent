<?php

namespace App\Bases;

use App\Models\Bulten;

class BultenBase
{
    public static function veriIsleme()
    {
        return Bulten::select('bulten_mail.*')
        ;
    }

    public static function ekle($veri)
    {
        $bulten = Bulten::create($veri);
        return $bulten;
    }


    public static function duzenle(Bulten $bulten, $veri)
    {
        $guncelBulten = $bulten->update($veri);
        return $guncelBulten;
    }

    public static function sil(Bulten $bulten)
    {
        return $bulten->delete();
    }
}
