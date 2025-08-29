<?php

namespace App\Bases;

use App\Models\Kullanici;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class KullaniciBase
{
    public static function veriIsleme()
    {
        return Kullanici::select('kullanici.*')
        ;
    }

    public static function ekle($veri)
    {
        $kullanici = Kullanici::create($veri);
        return $kullanici;
    }

    public static function duzenle(Kullanici $kullanici, $veri)
    {
        $guncelKullanici = $kullanici->update($veri);
        return $guncelKullanici;
    }

    public static function sil(Kullanici $kullanici)
    {
        return $kullanici->delete();
    }
}
