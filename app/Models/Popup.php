<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Popup extends Model
{
    use HasFactory;

    /**
     * Bu modelin bağlı olduğu veritabanı tablosunun adı.
     *
     * @var string
     */
    protected $table = 'popup';

    /**
     * Tabloyla ilişkili birincil anahtar (primary key) sütununun adı.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Modelin zaman damgaları (created_at, updated_at) otomatik olarak yönetilip
     * yönetilmeyeceğini belirler.
     * true olarak ayarlanmışsa, Laravel bu alanları otomatik olarak oluşturur.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Toplu atama (mass assignment) ile doldurulabilecek model özelliklerinin
     * bir listesini belirtir.
     *
     * @var array
     */
    protected $fillable = [
        'admin_id',
        'sira_no',
        'resim_url',
        'baslangic_tarih',
        'bitis_tarih',
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
     * Popup a ait dil kayıtları ilişkisi.
     */
    public function popupDiller()
    {
        return $this->hasMany(PopupDil::class, 'popup_id', 'id');
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
