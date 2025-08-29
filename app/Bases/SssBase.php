<?php

namespace App\Bases;

use App\Models\Sss;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class SssBase
{
    public static function veriIsleme()
    {
        $varsayilanDil = Config::get('app.locale');
        return Sss::join('sss_dil as sssd', 'sss.id', '=', 'sssd.sss_id')
            ->select(
                'sss.*',
                'sssd.baslik',
                'sssd.icerik',
            )
            ->where('sssd.dil', $varsayilanDil);
    }

    public static function ekle($veri)
    {
        try {
            $sss = Sss::create($veri);
            return $sss;
        } catch (\Exception $e) {
            throw new \Exception("S.s.s eklenemedi: " . $e->getMessage());
        }
    }

    public static function duzenle(Sss $sss, $veri)
    {
        try {
            $sss->update($veri);
            return $sss->refresh();
        } catch (\Exception $e) {
            throw new \Exception("S.s.s güncellenemedi: " . $e->getMessage());
        }
    }

    public static function sil(Sss $sss)
    {
        try {
            return $sss->delete();
        } catch (\Exception $e) {
            throw new \Exception("S.s.s silinemedi: " . $e->getMessage());
        }
    }
}
