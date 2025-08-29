<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Surec extends Model
{
    
      use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'surec';

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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'admin_id',
        'sira_no',
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



    public function surecDiller()
    {
        return $this->hasMany(SurecDil::class, 'surec_id', 'id');
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
