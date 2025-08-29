<?php

namespace App\Bases;

use App\Models\Popup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class PopupBase
{
    public static function veriIsleme()
    {
        $varsayilanDil = Config::get('app.locale');
        return Popup::join('popup_dil as pd', 'popup.id', '=', 'pd.popup_id')
        ->select('popup.*', 'pd.baslik as baslik')
        ->where('dil', $varsayilanDil);
    }

    public static function ekle($veri)
    {
        $popup = Popup::create($veri);
        return $popup;
    }


    public static function duzenle(Popup $popup, $veri)
    {
        $guncelPopup = $popup->update($veri);
        return $guncelPopup;
    }

    public static function sil(Popup $popup)
    {
        return $popup->delete();
    }
}
