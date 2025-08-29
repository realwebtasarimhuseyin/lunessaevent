<?php

namespace App\Services;

use App\Models\Admin;
use App\Bases\AdminBase;
use Illuminate\Support\Facades\DB;

class AdminServis
{
    public static function veriAlma($arama = 0)
    {
        $builder = AdminBase::veriIsleme();

        if ($arama !== "") {
            $builder->whereAny(['k.kod'], 'like', "%$arama%");
        }

        return $builder;
    }

    public static function tekliVeri($adminId)
    {
        $builder = AdminBase::veriIsleme();
        $builder->where("k.id", $adminId)->first();
    }

    public static function ekle($veri)
    {
        try {
            return DB::transaction(function () use ($veri) {

                if ($veri["yetki"] == "010") {
                    $veri["super_admin"] = true;
                }

                $admin = AdminBase::ekle($veri);

                if ($veri["yetki"] !== "010") {
                    $admin->assignRole($veri["yetki"]);
                }
                
            });
        } catch (\Throwable $th) {
            throw new \Exception('Admin kayıt edilemedi : ' . $th->getMessage());
        }
    }

    public static function duzenle(Admin $admin, $veri)
    {
        try {
            return DB::transaction(function () use ($admin, $veri) {

                if ($veri["yetki"] == '010') {
                    $veri["super_admin"] = true;
                    $admin->syncRoles([]);
                } else {
                    $veri["super_admin"] = false;
                    $admin->assignRole($veri["yetki"]);
                }

                AdminBase::duzenle($admin, $veri);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Admin düzenlenemedi : ' . $th->getMessage());
        }
    }

    public static function sil(Admin $admin)
    {
        try {
            return DB::transaction(function () use ($admin) {
                AdminBase::sil($admin);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Admin silinemedi : ' . $th->getMessage());
        }
    }
}
