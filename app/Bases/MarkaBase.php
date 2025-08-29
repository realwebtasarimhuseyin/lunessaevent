<?php

namespace App\Bases;

use App\Models\Marka;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class MarkaBase
{
    public static function veriIsleme()
    {
        $varsayilanDil = App::getLocale();

        return Marka::leftJoin('admin as a', 'marka.admin_id', '=', 'a.id')
            ->select('marka.*', DB::raw("CONCAT(a.isim, ' ', a.soyisim) as ekliyen_kullanici"));
    }

    public static function ekle($veri)
    {
        $marka = Marka::create($veri);
        return $marka;
    }


    public static function duzenle(Marka $marka, $veri)
    {
        $guncelMarka = $marka->update($veri);
        return $guncelMarka;
    }

    public static function sil(Marka $marka)
    {
        return $marka->delete();
    }
}
