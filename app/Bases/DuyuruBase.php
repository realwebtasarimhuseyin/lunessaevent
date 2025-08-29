<?php

namespace App\Bases;

use App\Models\Duyuru;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class DuyuruBase
{
    public static function veriIsleme()
    {
        $varsayilanDil = App::getLocale();


        return Duyuru::join('duyuru_dil as dd', 'duyuru.id', '=', 'dd.duyuru_id')
            ->select('duyuru.*', 'dd.icerik')
            ->where('dd.dil', $varsayilanDil);
    }

    public static function ekle($veri)
    {
        $duyuru = Duyuru::create($veri);
        return $duyuru;
    }


    public static function duzenle(Duyuru $duyuru, $veri)
    {
        $guncelDuyuru = $duyuru->update($veri);
        return $guncelDuyuru;
    }

    public static function sil(Duyuru $duyuru)
    {
        return $duyuru->delete();
    }
}
