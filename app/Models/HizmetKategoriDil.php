<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HizmetKategoriDil extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hizmet_kategori_dil';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'hizmet_kategori_id',
        'isim',
        'slug',
        'dil',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the Blog instance associated with this BlogDil.
     */
    public function hizmetKategori()
    {
        return $this->belongsTo(HizmetKategori::class, 'hizmet_kategori_id', 'id');
    }
}
