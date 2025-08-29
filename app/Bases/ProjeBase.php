<?php

namespace App\Bases;

use App\Models\Proje;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class ProjeBase
{
    public static function veriIsleme()
    {
        $varsayilanDil = App::getLocale();


        return Proje::join('proje_dil as pd', 'proje.id', '=', 'pd.proje_id')
            ->leftJoin('admin as a', 'proje.admin_id', '=', 'a.id')
            ->select('proje.*', 'pd.baslik', 'pd.icerik', DB::raw("CONCAT(a.isim, ' ', a.soyisim) as ekliyen_kullanici"))
            ->where('pd.dil', $varsayilanDil);
    }

    public static function ekle($veri)
    {
        $proje = Proje::create($veri);
        return $proje;
    }


    public static function duzenle(Proje $proje, $veri)
    {
        $guncelProje = $proje->update($veri);
        return $guncelProje;
    }

    public static function sil(Proje $proje)
    {
        return $proje->delete();
    }
}