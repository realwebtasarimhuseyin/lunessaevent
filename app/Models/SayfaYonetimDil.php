<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SayfaYonetimDil extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sayfa_yonetim_dil';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;


    protected $fillable = [
        'sayfa_yonetim_id',
        'icerik',
        'baslik',
        'meta_baslik',
        'meta_icerik',
        'meta_anahtar',
        'dil'
    ];

    /**
     * Get the SayfaYonetim instance associated with this SayfaYonetimDil.
     */
    public function sayfaYonetim()
    {
        return $this->belongsTo(SayfaYonetim::class, 'sayfa_yonetim_id', 'id');
    }
}
