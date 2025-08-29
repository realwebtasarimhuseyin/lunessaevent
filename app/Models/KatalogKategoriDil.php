<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KatalogKategoriDil extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'katalog_kategori_dil';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = [
        'katalog_kategori_id',
        'isim',
        'slug',
        'dil'
    ];

    /**
     * Get the Blog instance associated with this BlogDil.
     */
    public function katalogKategori()
    {
        return $this->belongsTo(KatalogKategori::class, 'katalog_kategori_id', 'id');
    }
}
