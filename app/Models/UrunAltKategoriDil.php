<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrunAltKategoriDil extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'urun_alt_kategori_dil';

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

    protected $fillable = [
        'urun_alt_kategori_id',
        'isim',
        'slug',
        'dil',
    ];

    /**
     * Get the Blog instance associated with this BlogDil.
     */
    public function urunAltKategori()
    {
        return $this->belongsTo(UrunAltKategori::class, 'urun_alt_kategori_id', 'id');
    }
}
