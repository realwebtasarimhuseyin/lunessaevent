<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Slider extends Model
{
    use HasFactory;

    /**
     * Bu modelin ilişkilendirildiği veritabanı tablosunu belirtir.
     *
     * @var string
     */
    protected $table = 'slider';

    /**
     * Bu tablonun birincil anahtarını belirtir.
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
     * Toplu atama yapılabilecek alanları belirtir.
     *
     * @var array
     */
    protected $fillable = [
        'admin_id',
        'resim_url',
        'video_url',
        'durum'
    ];

    /**
     * Durumu aktif olan bloglar için bir sorgu kapsamı (scope).
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeAktif(Builder $query)
    {
        return $query->where('durum', true);
    }

    /**
     * Slider'ın ilişkili olduğu Admin'i alır.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    /**
     * Slider ile ilişkili olan SliderDil kayıtlarını alır.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sliderDiller()
    {
        return $this->hasMany(SliderDil::class, 'slider_id', 'id');
    }

    /**
     * Verilen uzantıya göre, mevcut olmayan bir klasör adı oluşturur ve döndürür.
     * Klasör adı, var olan bir klasör ismiyle çakışmamalıdır. Çakışma durumunda isim artan bir numara ile değiştirilir.
     *
     * @param string $uzanti  Klasör adı uzantısı (örneğin, 'images/slider')
     * @return string  Klasör adı
     */
    public static function klasorOlusturArtanNumaraIle($uzanti)
    {
        $sayac = 1;
        $yol = $uzanti;

        while (File::exists($yol)) {
            $yol = $uzanti . '_' . $sayac;
            $sayac++;
        }

        return $yol;
    }

    protected static function booted()
    {
        static::deleting(function ($nesne) {
            // Silinen ürünün sıra numarasını al
            $deletedSiraNo = $nesne->sira_no;

            // Sıra numaralarını yeniden düzenle
            static::where('sira_no', '>', $deletedSiraNo)
                ->decrement('sira_no');
        });
    }
}
