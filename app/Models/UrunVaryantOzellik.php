<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrunVaryantOzellik extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'urun_varyant_ozellik';

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
        'sira_no',
        'urun_varyant_id',
        'durum'
    ];

    /**
     * Get the Admin that owns the Blog.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function urunVaryant()
    {
        return $this->belongsTo(UrunVaryant::class, 'urun_varyant_id', 'id');
    }

    public function urunVaryantOzellikDiller()
    {
        return $this->hasMany(UrunVaryantOzellikDil::class, 'urun_varyant_ozellik_id', 'id');
    }

    public function urunVaryantSecim()
    {
        return $this->hasMany(UrunVaryantSecim::class, 'varyant_ozellik_id', 'id');
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
