<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sepet extends Model
{
    use HasFactory;

    /**
     * Bu modelin ilişkili olduğu veritabanı tablosunu belirtir.
     *
     * @var string
     */
    protected $table = 'sepet';

    /**
     * Bu tablonun birincil anahtar (primary key) sütununu belirtir.
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

    /**
     * Toplu veri atanabilir (mass assignable) alanları tanımlar.
     *
     * @var array
     */
    protected $fillable = [
        'kullanici_id',
        'urun_id',
        'adet',
    ];

    /**
     * Sepetin sahibi olan kullanıcıyı döndürür.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kullanici()
    {
        return $this->belongsTo(Kullanici::class, 'kullanici_id', 'id');
    }

    /**
     * Sepetteki ürünün detaylarını döndürür.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function urun()
    {
        return $this->belongsTo(Urun::class, 'urun_id', 'id');
    }

    public function sepetUrunVaryant() {
        return $this->hasMany(SepetUrunVaryant::class,'sepet_id','id');
    }
}
