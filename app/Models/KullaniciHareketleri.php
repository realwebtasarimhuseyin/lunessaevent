<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KullaniciHareketleri extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kullanici_hareketleri';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Bu modelde `created_at` ve `updated_at` timestamp alanlarının kullanılıp kullanılmayacağını belirtir.
     *
     * @var bool
     */
    public $timestamps = true;

    protected $fillable = [
        'kullanici_id',
        'ip_adresi',
        'url',
        'tarayici_isim',
        'tarayici_surum',
        'platform_isim',
        'platform_surum',
        'cihaz_tip',
        'bot_bilgi',
        'il_id'
    ];

    public function il()
    {
        return $this->belongsTo(Il::class, 'il_id', 'id');
    }
}
