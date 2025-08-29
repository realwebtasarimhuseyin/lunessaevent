<?php

namespace App\Bases;

use App\Models\Slider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class SliderBase
{
    public static function veriIsleme()
    {
        // Varsayılan dilin alınması
        $varsayilanDil = App::getLocale();

        // Slider ve ilgili tabloların join edilmesi, varsayılan dile göre veri alınması
        return Slider::join('slider_dil as sd', 'slider.id', '=', 'sd.slider_id')
            ->leftJoin('admin as a', 'slider.admin_id', '=', 'a.id')
            ->select(
                'slider.*',
                'sd.baslik',
                DB::raw("CONCAT(a.isim, ' ', a.soyisim) as ekleyen_kullanici")
            )
            ->where('sd.dil', $varsayilanDil);
    }

    public static function ekle(array $veri)
    {
        // Yeni bir slider kaydı oluşturulması
        return Slider::create($veri);
    }

    public static function duzenle(Slider $slider, array $veri)
    {
        // Mevcut slider verisinin güncellenmesi
        $slider->update($veri);
        return $slider;
    }

    public static function sil(Slider $slider)
    {
        // Slider kaydının silinmesi
        return $slider->delete();
    }
}
