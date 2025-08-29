<?php

namespace App\Bases;

use App\Models\Kupon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class KuponBase
{
    public static function veriIsleme()
    {
        return Kupon::leftJoin('admin as a', 'kupon.admin_id', '=', 'a.id')
            ->select('kupon.*', DB::raw("CONCAT(a.isim, ' ', a.soyisim) as ekliyen_kullanici"))
        ;
    }

    public static function ekle($veri)
    {
        $kupon = Kupon::create($veri);
        return $kupon;
    }


    public static function duzenle(Kupon $kupon, $veri)
    {
        $guncelKupon = $kupon->update($veri);
        return $guncelKupon;
    }

    public static function sil(Kupon $kupon)
    {
        return $kupon->delete();
    }
}
