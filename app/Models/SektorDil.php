<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SektorDil extends Model
{
    use HasFactory;


    protected $table = 'sektor_dil';


    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'sektor_id',
        'baslik',
        'kisa_icerik',
        'icerik',
        'meta_baslik',
        'meta_icerik',
        'meta_anahtar',
        'slug',
        'dil'
    ];

    /**
     * Get the Blog instance associated with this BlogDil.
     */
    public function sektor()
    {
        return $this->belongsTo(Sektor::class, 'sektor_id', 'id');
    }
}
