<?php

namespace App\Bases;

use App\Models\Sepet;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class SepetBase
{
    public static function veriIsleme()
    {
        return Sepet::select(
            'sepet.*',
        );
    }

    public static function ekle(array $veri)
    {
        // Yeni bir sepet kaydı oluşturulması
        return Sepet::create($veri);
    }

    public static function duzenle(Sepet $sepet, array $veri)
    {
        // Mevcut sepet verisinin güncellenmesi
        $sepet->update($veri);
        return $sepet;
    }

    public static function sil(Sepet $sepet)
    {
        // Sepet kaydının silinmesi
        return $sepet->delete();
    }
}
