<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrunResim extends Model
{
    use HasFactory;

    /**
     * Bu modelin ilişkili olduğu tablo.
     *
     * @var string
     */
    protected $table = 'urun_resim';

    /**
     * Tablo ile ilişkili birincil anahtar.
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
     * Toplu olarak atanabilir alanlar.
     *
     * @var array
     */
    protected $fillable = [
        'urun_id',
        'resim_url',
        'tip'
    ];

    /**
     * Bu resmin ait olduğu ürünü getirir.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function urun()
    {
        // Her resim, bir ürüne aittir (urun_id foreign key alanı ile).
        return $this->belongsTo(Urun::class, 'urun_id', 'id');
    }
}
