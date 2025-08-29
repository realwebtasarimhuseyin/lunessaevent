<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrunVaryantDil extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'urun_varyant_dil';

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
        'urun_varyant_id',
        'isim',
        'dil'
    ];

    /**
     * Get the Blog instance associated with this BlogDil.
     */
    public function urunVaryant()
    {
        return $this->belongsTo(UrunVaryant::class, 'urun_varyant_id', 'id');
    }
}
