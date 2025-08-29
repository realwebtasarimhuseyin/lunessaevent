<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Urun extends Model
{
    use HasFactory;

    /**
     * Modelin ilişkili olduğu tablo.
     *
     * @var string
     */
    protected $table = 'urun';

    /**
     * Tablonun birincil anahtar sütunu.
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

    /**
     * Toplu atamaya izin verilen sütunlar.
     *
     * @var array
     */
    protected $fillable = [
        'admin_id',
        'sira_no',
        'urun_kategori_id',
        'urun_alt_kategori_id',
        'stok_adet',
        'stok_kod',
        'kdv_durum',
        'birim_fiyat',
        'iscilik_fiyat',
        'kdv_id',
        'marka_id',
        'indirim_yuzde',
        'indirim_tutar',
        'durum',
        'ozel_alan_1',
        'ozel_alan_2',

    ];

    /**
     * Veritabanı sütunlarının tip dönüşümleri.
     *
     * @var array
     */
    protected $casts = [
        'kdv_durum' => 'boolean',
        'indirim_yuzde' => 'decimal:2',
        'indirim_tutar' => 'decimal:2',
        'birim_fiyat' => 'decimal:2',
        'stok_adet' => 'integer',
        'durum' => 'boolean',
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
     * Ürünün sahibi olan Admin ilişkisi.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    /**
     * Ürüne ait dil kayıtları ilişkisi.
     */
    public function urunDiller()
    {
        return $this->hasMany(UrunDil::class, 'urun_id', 'id');
    }

    /**
     * Slug ile ürünü getirir.
     *
     * @param string $slug
     * @return self|null
     */
    public static function slugBul(string $slug)
    {
        return self::whereHas('urunDiller', function ($query) use ($slug) {
            $query->where('slug', $slug)->where('dil', app()->getLocale());
        })->where('durum', true)->first();
    }

    /**
     * Başlıktan benzersiz bir slug oluşturur.
     *
     * @param string $baslik
     * @return string
     */
    public static function slugUret(string $baslik)
    {
        $slug = Str::slug($baslik);
        $orijinalSlug = $slug;
        $sayac = 1;

        while (
            self::whereHas('urunDiller', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })->exists()
        ) {
            $slug = $orijinalSlug . '-' . $sayac;
            $sayac++;
        }

        return $slug;
    }

    /**
     * Ürüne ait resim kayıtları ilişkisi.
     */
    public function urunResimler()
    {
        return $this->hasMany(UrunResim::class, 'urun_id', 'id');
    }

    /**
     * Ürün için seçilen varyantlar ilişkisi.
     */
    public function secilenVaryatlar()
    {
        return $this->hasMany(UrunVaryantSecim::class, 'urun_id', 'id');
    }

    /**
     * Ürünün ait olduğu kategori ilişkisi.
     */
    public function urunKategori()
    {
        return $this->belongsTo(UrunKategori::class, 'urun_kategori_id', 'id');
    }

    /**
     * Ürünün ait olduğu alt kategori ilişkisi.
     */
    public function urunAltKategori()
    {
        return $this->belongsTo(UrunAltKategori::class, 'urun_alt_kategori_id', 'id');
    }


    public function urunKdv()
    {
        return $this->belongsTo(UrunKdv::class, 'kdv_id', 'id');
    }

    public function marka()
    {
        return $this->belongsTo(Marka::class, 'marka_id', 'id');
    }

    public function favorideMi()
    {
        if (Auth::guard('web')->check()) {
            $kullaniciId = Auth::id();
            return $this->favoriler()->where('kullanici_id', $kullaniciId)->exists();
        }
        return false;
    }

    /**
     * Ürüne ait favori ilişkisi.
     */
    public function favoriler()
    {
        return $this->hasMany(Favori::class, 'urun_id', 'id');
    }


    /**
     * Siparişlerdeki ürün kayıtları ilişkisi.
     */
    public function siparisUrunler()
    {
        return $this->hasMany(SiparisUrun::class, 'urun_id', 'id');
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
