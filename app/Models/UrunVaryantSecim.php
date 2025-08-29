<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class UrunVaryantSecim extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'urun_varyant_secim';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    
    /**
     * Bu modelde timestamp kullanılıp kullanılmadığını belirtir.
     *
     * @var bool
     */
    public $timestamps = true;

    protected $casts = [
        'urun_varyantlar' => 'array', // JSON'u otomatik array'e çevir
    ];

    protected $fillable = [
        'urun_id',
        'urun_varyantlar',
        'birim_fiyat',
        'stok_adet',
        'stok_kod',
    ];

    public function varyantOzellikler()
    {
        return $this->hasMany(UrunVaryantOzellik::class, 'id', 'urun_varyantlar');
    }
}
