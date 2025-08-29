<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Doviz modeli
 * Veritabanındaki `doviz` tablosuyla ilişkilendirilmiştir.
 */
class DovizYonetim extends Model
{
    use HasFactory;

    /**
     * Modelin ilişkilendirildiği tablo.
     *
     * @var string
     */
    protected $table = 'doviz_yonetim';

    /**
     * Tabloya ait birincil anahtar sütunu.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Modelin otomatik olarak oluşturulan `created_at` ve `updated_at`
     * zaman damgası sütunlarına sahip olup olmadığını belirtir.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Toplu olarak doldurulabilir (mass assignable) alanlar.
     * Bu alanlara toplu veri atanmasına izin verilir.
     *
     * @var array
     */
    protected $fillable = [
        'doviz_slug',
        'kaynak',
        'yuzde',
        'birim',
    ];

    /**
     * Get the DovizYonetim instance by its slug.
     *
     * @param string $slug
     * @return \App\Models\DovizYonetim|null
     */
    public static function getByDovizSlug($dovizSlug)
    {
        return self::where('doviz_slug', $dovizSlug)->first();
    }
}
