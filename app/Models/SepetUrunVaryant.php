<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class SepetUrunVaryant extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sepet_urun_varyant';

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
        'sepet_id',
        'urun_id',
        'urun_varyant_id',
        'urun_varyant_ozellik_id'
    ];

    /**
     * Get the Admin that owns the Blog.
     */
    public function kullanici()
    {
        return $this->belongsTo(Kullanici::class, 'kullanici_id', 'id');
    }

    public function sepet()
    {
        return $this->belongsTo(Sepet::class, 'sepet_id', 'id');
    }

    public function urun()
    {
        return $this->belongsTo(Urun::class, 'urun_id', 'id');
    }

    public function varyant()
    {
        return $this->belongsTo(UrunVaryant::class, 'urun_varyant_id', 'id');
    }

    public function varyantOzellik()
    {
        return $this->belongsTo(UrunVaryantOzellik::class, 'urun_varyant_ozellik_id', 'id');
    }
}
