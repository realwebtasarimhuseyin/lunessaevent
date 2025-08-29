<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {

        // Tanımlanan tüm izinler
        $permissions = [
            'slider-tumunugor',
            'slider-gor',
            'slider-ekle',
            'slider-duzenle',
            'slider-sil',
            'blog-tumunugor',
            'blog-gor',
            'blog-ekle',
            'blog-duzenle',
            'blog-sil',
            'urun-kategori-tumunugor',
            'urun-kategori-gor',
            'urun-kategori-ekle',
            'urun-kategori-duzenle',
            'urun-kategori-sil',
            'urun-alt-kategori-tumunugor',
            'urun-alt-kategori-gor',
            'urun-alt-kategori-ekle',
            'urun-alt-kategori-duzenle',
            'urun-alt-kategori-sil',
            'urun-varyant-tumunugor',
            'urun-varyant-gor',
            'urun-varyant-ekle',
            'urun-varyant-duzenle',
            'urun-varyant-sil',
            'urun-varyant-ozellik-tumunugor',
            'urun-varyant-ozellik-gor',
            'urun-varyant-ozellik-ekle',
            'urun-varyant-ozellik-duzenle',
            'urun-varyant-ozellik-sil',
            'urun-tumunugor',
            'urun-gor',
            'urun-ekle',
            'urun-duzenle',
            'urun-sil',
            'urun-kdv-tumunugor',
            'urun-kdv-gor',
            'urun-kdv-ekle',
            'urun-kdv-duzenle',
            'urun-kdv-sil',
            'kupon-tumunugor',
            'kupon-gor',
            'kupon-ekle',
            'kupon-duzenle',
            'kupon-sil',
            'popup-tumunugor',
            'popup-gor',
            'popup-ekle',
            'popup-duzenle',
            'popup-sil',
            'sss-tumunugor',
            'sss-gor',
            'sss-ekle',
            'sss-duzenle',
            'sss-sil',
            'kullanici-tumunugor',
            'kullanici-gor',
            'kullanici-ekle',
            'kullanici-duzenle',
            'kullanici-sil',
            'admin-tumunugor',
            'admin-gor',
            'admin-ekle',
            'admin-duzenle',
            'admin-sil',
            'ayar-gor',
            'ayar-duzenle',
            'bulten-gor',
        ];
        

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'admin',
            ]);
        }

        /* 
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);

        $adminRole->syncPermissions($permissions);
 */
    }
}
