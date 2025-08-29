<?php

namespace App\Bases;

use App\Models\UrunKdv;

class UrunKdvBase
{
    public static function veriIsleme()
    {
        return UrunKdv::select('urun_kdv.*');
    }

    public static function ekle($veri)
    {
        $urunKdv = UrunKdv::create($veri);
        return $urunKdv;
    }

    public static function duzenle(UrunKdv $urunKdv, $veri)
    {
        $guncelUrunKdv = $urunKdv->update($veri);
        return $guncelUrunKdv;
    }

    public static function sil(UrunKdv $urunKdv)
    {
        return $urunKdv->delete();
    }
}
