<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

/**
 * Blog Modeli
 *
 * Bu model, blog içeriklerinin veritabanı ile etkileşimini sağlar.
 */
class Blog extends Model
{
    use HasFactory;

    /**
     * Veritabanında ilişkilendirilen tablo adı.
     *
     * @var string
     */
    protected $table = 'blog';

    /**
     * Tablo için kullanılan birincil anahtar sütunu.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Tabloda otomatik olarak `created_at` ve `updated_at` sütunlarını kullanıp kullanmadığını belirtir.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Kütle atama (mass assignment) sırasında doldurulabilir sütunlar.
     *
     * @var array
     */
    protected $fillable = [
        'admin_id',
        'sira_no',
        'resim_url',
        'durum',
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
     * Blogu oluşturan admin ile ilişkiyi tanımlar.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    /**
     * Blogun dillerle olan ilişkisini tanımlar.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blogDiller()
    {
        return $this->hasMany(BlogDil::class, 'blog_id', 'id');
    }

    /**
     * Verilen slug'a göre blog kaydını döndürür.
     *
     * @param string $slug
     * @return \App\Models\Blog|null
     */
    public static function slugBul($slug)
    {
        return self::whereHas('blogDiller', function ($query) use ($slug) {
            $query->where('slug', $slug)
                ->where('dil', app()->getLocale()); // Geçerli dil filtrelemesi
        })->where('durum', true)->first(); // Sadece aktif bloglar
    }

    /**
     * Verilen başlıktan benzersiz bir slug üretir.
     *
     * @param string $title
     * @return string
     */
    public static function slugUret($title)
    {
        $slug = Str::slug($title); // Başlık temelinde bir slug oluştur
        $originalSlug = $slug;
        $count = 1;

        // Slug'ın benzersiz olup olmadığını kontrol et
        while (BlogDil::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count; // Benzersiz değilse sonuna sayı ekle
            $count++;
        }

        return $slug; // Benzersiz slug döndür
    }

    protected static function booted()
    {
        static::deleting(function ($blog) {
            // Silinen ürünün sıra numarasını al
            $deletedSiraNo = $blog->sira_no;

            // Sıra numaralarını yeniden düzenle
            static::where('sira_no', '>', $deletedSiraNo)
                ->decrement('sira_no');
        });
    }
}
