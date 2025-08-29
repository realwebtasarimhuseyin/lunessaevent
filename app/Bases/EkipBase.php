<?php

namespace App\Bases;

use App\Models\Ekip;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class EkipBase
{
    public static function veriIsleme()
    {
        return Ekip::leftJoin('admin as a', 'ekip.admin_id', '=', 'a.id')
            ->select('ekip.*', DB::raw("CONCAT(a.isim, ' ', a.soyisim) as ekliyen_kullanici"))
        ;
    }

    public static function ekle($veri)
    {
        $ekip = Ekip::create($veri);
        return $ekip;
    }


    public static function duzenle(Ekip $ekip, $veri)
    {
        $guncelEkip = $ekip->update($veri);
        return $guncelEkip;
    }

    public static function sil(Ekip $ekip)
    {
        return $ekip->delete();
    }
}