<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjeKategoriDil extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'proje_kategori_dil';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'proje_kategori_id',
        'isim',
        'slug',
        'dil',
        'kisa_icerik',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the Blog instance associated with this BlogDil.
     */
    public function projeKategori()
    {
        return $this->belongsTo(ProjeKategori::class, 'proje_kategori_id', 'id');
    }
}
