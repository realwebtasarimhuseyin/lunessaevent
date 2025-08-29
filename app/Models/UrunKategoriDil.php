<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrunKategoriDil extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'urun_kategori_dil';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = [
        'urun_kategori_id',
        'isim',
        'slug',
        'dil'
    ];

    /**
     * Get the Blog instance associated with this BlogDil.
     */
    public function urunKategori()
    {
        return $this->belongsTo(UrunKategori::class, 'urun_kategori_id', 'id');
    }
}
