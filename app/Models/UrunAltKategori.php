<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UrunAltKategori extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'urun_alt_kategori';

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

    protected $fillable = [
        'admin_id',
        'urun_kategori_id',
        'sira_no',
        'durum'
    ];

    /**
     * Get the Admin that owns the UrunAltKategori.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    /**
     * Get the related UrunAltKategoriDil records.
     */
    public function urunAltKategoriDiller()
    {
        return $this->hasMany(UrunAltKategoriDil::class, 'urun_alt_kategori_id', 'id');
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
            self::whereHas('urunAltKategoriDiller', function ($query) use ($slug) {
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
