<?php

namespace App\Bases;

use App\Models\IletisimForm;

class IletisimFormBase
{
    public static function veriIsleme()
    {
        return IletisimForm::select('iletisim_form.*')
        ;
    }

    public static function ekle($veri)
    {
        $iletisimForm = IletisimForm::create($veri);
        return $iletisimForm;
    }


    public static function duzenle(IletisimForm $iletisimForm, $veri)
    {
        $guncelIletisimForm = $iletisimForm->update($veri);
        return $guncelIletisimForm;
    }

    public static function sil(IletisimForm $iletisimForm)
    {
        return $iletisimForm->delete();
    }
}
