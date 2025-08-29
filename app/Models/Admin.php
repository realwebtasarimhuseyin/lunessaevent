<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, HasRoles;

    protected $table = 'admin';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Tabloda otomatik olarak `created_at` ve `updated_at` sütunlarını kullanıp kullanmadığını belirtir.
     *
     * @var bool
     */
    public $timestamps = true;


    protected $fillable = [
        'isim',
        'soyisim',
        'eposta',
        'sifre',
        'super_admin',
        'durum',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->sifre;
    }

    /**
     * Kullanıcının süper admin olup olmadığını kontrol eder.
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->super_admin == true;
    }
}
