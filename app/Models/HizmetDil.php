<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HizmetDil extends Model
{
    use HasFactory;

  
    protected $table = 'hizmet_dil';

   
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'hizmet_id',
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
    public function hizmet()
    {
        return $this->belongsTo(Hizmet::class, 'hizmet_id', 'id');
    }
}
