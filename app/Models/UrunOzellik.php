<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrunOzellik extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'urun_ozellik';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;


    protected $fillable = [
        'admin_id',
        'sira_no',
        'durum'
    ];

    /**
     * Get the Admin that owns the Blog.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    /**
     * Get the related BlogDil records.
     */
    public function urunOzellikDiller()
    {
        return $this->hasMany(UrunOzellikDil::class, 'urun_ozellik_id', 'id');
    }

    public function urunOzellikSecim()
    {
        return $this->hasMany(UrunOzellikSecim::class, 'ozellik_id', 'id');
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
