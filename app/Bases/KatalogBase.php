<?php

namespace App\Bases;

use App\Models\Katalog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class KatalogBase
{
    public static function veriIsleme()
    {
        $varsayilanDil = Config::get('app.locale');
        return Katalog::join('katalog_dil as kd', 'katalog.id', '=', 'kd.katalog_id')
            ->leftJoin('admin as a', 'katalog.admin_id', '=', 'a.id')
            ->select('katalog.*', 'kd.baslik', 'kd.slug')
            ->where('kd.dil', $varsayilanDil)
        ;
    }

    public static function ekle($veri)
    {
        $katalog = Katalog::create($veri);
        return $katalog;
    }


    public static function duzenle(Katalog $katalog, $veri)
    {
        $guncelKatalog = $katalog->update($veri);
        return $guncelKatalog;
    }

    public static function sil(Katalog $katalog)
    {
        return $katalog->delete();
    }
}
