<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UrunKategori extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'urun_kategori';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Bu modelde timestamp kullanılıp kullanılmadığını belirtir.
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
        'admin_id',
        'sira_no',
        'resim_url',
        'menu_durum',
        'anasayfa_durum',
        'indirim_durum',
        'durum'
    ];

    /**
     * Aktif kategorileri filtreler.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeAktif(Builder $query)
    {
        return $query->where('durum', true);
    }

    /**
     * İndirim aktif olan kategorileri filtreler.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeIndirimAktif(Builder $query)
    {
        return $query->aktif()->where('indirim_durum', true);
    }


    /**
     * Menüde aktif olan kategorileri filtreler.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeMenuAktif(Builder $query)
    {
        return $query->aktif()->where('menu_durum', true);
    }


    public function scopeAnaSayfaAktif(Builder $query)
    {
        return $query->aktif()->where('anasayfa_durum', true);
    }

    /**
     * Kategoriyi oluşturan admini getirir.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    /**
     * Kategoriyle ilişkili dil bilgilerini getirir.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function urunKategoriDiller()
    {
        return $this->hasMany(UrunKategoriDil::class, 'urun_kategori_id', 'id');
    }


    public function urunAltKategoriler()
    {
        return $this->hasMany(UrunAltKategori::class, 'urun_kategori_id', 'id');
    }

    public function urunler()
    {
        return $this->hasMany(Urun::class, 'urun_kategori_id', 'id');
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
            self::whereHas('urunKategoriDiller', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })->exists()
        ) {
            $slug = $orijinalSlug . '-' . $sayac;
            $sayac++;
        }

        return $slug;
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
