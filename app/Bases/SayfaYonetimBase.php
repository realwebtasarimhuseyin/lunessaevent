<?php

namespace App\Bases;

use App\Models\SayfaYonetim;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class SayfaYonetimBase
{
    public static function veriIsleme()
    {
        return SayfaYonetim::select('sayfa_yonetim.*' );
    }

    public static function duzenle(SayfaYonetim $sayfaYonetim, $veri)
    {
        $guncelSayfaYonetim = $sayfaYonetim->update($veri);
        return $guncelSayfaYonetim;
    }
}
