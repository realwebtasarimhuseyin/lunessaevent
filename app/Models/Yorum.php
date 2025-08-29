<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Yorum extends Model
{
    use HasFactory;

    /**
     * Bu modelin ilişkili olduğu tablo.
     *
     * @var string
     */
    protected $table = 'yorum';

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
        'admin_id',
        'sira_no',
        'resim_url',
        'kisi_isim',
        'kisi_unvan',
        'durum'
    ];

    /**
     * Yalnızca aktif olan yorumları döndüren scope metodu.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeAktif(Builder $query)
    {
        return $query->where('durum', true);  // 'durum' alanı true olan yorumları getirir
    }

    /**
     * Bu yorumun ait olduğu admini getirir.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        // Her yorum bir admin ile ilişkilidir
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    /**
     * Yorum ile ilişkili olan YorumDil kayıtlarını getirir.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function YorumDiller()
    {
        // Bir yoruma birden fazla dil kaydı olabilir
        return $this->hasMany(YorumDil::class, 'yorum_id', 'id');
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
