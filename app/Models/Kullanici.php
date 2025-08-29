<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Kullanici extends Authenticatable
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kullanici';

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
        'isim_soyisim',
        'eposta',
        'telefon',
        'sifre',
        'remember_token'
    ];


    public function getAuthPassword()
    {
        return $this->sifre;
    }

    public function favori()
    {
        return $this->hasMany(Favori::class, 'kullanici_id', 'id');
    }

    public function sepet()
    {
        return $this->hasMany(Sepet::class, 'kullanici_id', 'id');
    }

    public function indirimler()
    {
        return $this->hasMany(KullaniciIndirim::class, 'kullanici_id', 'id');
    }
}
