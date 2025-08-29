<?php

namespace App\Bases;

use App\Models\Sektor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class SektorBase
{
    public static function veriIsleme()
    {
        $varsayilanDil = App::getLocale();


        return Sektor::join('sektor_dil as sd', 'sektor.id', '=', 'sd.sektor_id')
            ->leftJoin('admin as a', 'sektor.admin_id', '=', 'a.id')
            ->select('sektor.*', 'sd.baslik', 'sd.icerik', DB::raw("CONCAT(a.isim, ' ', a.soyisim) as ekliyen_kullanici"))
            ->where('sd.dil', $varsayilanDil);
    }

    public static function ekle($veri)
    {
        $sektor = Sektor::create($veri);
        return $sektor;
    }


    public static function duzenle(Sektor $sektor, $veri)
    {
        $guncelSektor = $sektor->update($veri);
        return $guncelSektor;
    }

    public static function sil(Sektor $sektor)
    {
        return $sektor->delete();
    }
}
