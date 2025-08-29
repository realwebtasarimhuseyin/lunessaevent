<?php

namespace App\Bases;

use App\Models\Yorum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class YorumBase
{
    public static function veriIsleme()
    {
        $varsayilanDil = App::getLocale();

        return Yorum::join('yorum_dil as yd', 'yorum.id', '=', 'yd.yorum_id')->select('yorum.*')
            ->where('yd.dil', $varsayilanDil);
    }

    public static function ekle($veri)
    {
        $yorum = Yorum::create($veri);
        return $yorum;
    }


    public static function duzenle(Yorum $yorum, $veri)
    {
        $guncelYorum = $yorum->update($veri);
        return $guncelYorum;
    }

    public static function sil(Yorum $yorum)
    {
        return $yorum->delete();
    }
}
