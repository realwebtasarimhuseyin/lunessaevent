<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favori extends Model
{
    use HasFactory;

    /**
     * Bu modelin ilişkili olduğu veritabanı tablosunu belirtir.
     *
     * @var string
     */
    protected $table = 'favori';

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
     * Veritabanında toplu atanabilir (mass assignable) alanları tanımlar.
     * Yani, bu alanlar üzerinde toplu veri girişi yapılabilir.
     *
     * @var array
     */
    protected $fillable = [
        'kullanici_id',
        'urun_id',
    ];

    /**
     * Favori modeli ile ürün modeli arasında ilişki tanımlar.
     * Bu ilişki, favorinin bir ürüne ait olduğunu ifade eder.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function urun()
    {
        return $this->belongsTo(Urun::class, 'urun_id', 'id');
    }
}
