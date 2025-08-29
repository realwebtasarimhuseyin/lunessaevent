<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrunDil extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'urun_dil';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Modelin zaman damgaları (timestamps) kullanıp kullanmayacağı.
     *
     * @var bool
     */
    public $timestamps = true;


    protected $fillable = [
        'urun_id',
        'baslik',
        'icerik',
        'meta_baslik',
        'meta_icerik',
        'meta_anahtar',
        'slug',
        'dil'
    ];

    /**
     * Get the Urun instance associated with this UrunDil.
     */
    public function urun()
    {
        return $this->belongsTo(Urun::class, 'urun_id', 'id');
    }
}
