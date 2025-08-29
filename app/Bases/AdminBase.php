<?php

namespace App\Bases;

use App\Models\Admin;


class AdminBase
{
    public static function veriIsleme()
    {
        return Admin::select('admin.*')
        ;
    }

    public static function ekle($veri)
    {
        $admin = Admin::create($veri);
        return $admin;
    }


    public static function duzenle(Admin $admin, $veri)
    {

        $guncelAdmin = $admin->update($veri);
        return $guncelAdmin;
    }

    public static function sil(Admin $admin)
    {
        return $admin->delete();
    }
}
