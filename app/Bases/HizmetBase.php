<?php

namespace App\Bases;

use App\Models\Hizmet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class HizmetBase
{
    public static function veriIsleme()
    {
        $varsayilanDil = App::getLocale();


        return Hizmet::join('hizmet_dil as hd', 'hizmet.id', '=', 'hd.hizmet_id')
            ->leftJoin('admin as a', 'hizmet.admin_id', '=', 'a.id')
            ->select('hizmet.*', 'hd.baslik', 'hd.icerik', DB::raw("CONCAT(a.isim, ' ', a.soyisim) as ekliyen_kullanici"))
            ->where('hd.dil', $varsayilanDil);
    }

    public static function ekle($veri)
    {
        $hizmet = Hizmet::create($veri);
        return $hizmet;
    }


    public static function duzenle(Hizmet $hizmet, $veri)
    {
        $guncelHizmet = $hizmet->update($veri);
        return $guncelHizmet;
    }

    public static function sil(Hizmet $hizmet)
    {
        return $hizmet->delete();
    }
}
