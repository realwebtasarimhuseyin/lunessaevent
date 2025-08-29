<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrunOzellikDil extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'urun_ozellik_dil';

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
        'urun_ozellik_id',
        'isim',
        'dil',
    ];

    /**
     * Get the Blog instance associated with this BlogDil.
     */
    public function urunOzellik()
    {
        return $this->belongsTo(UrunOzellik::class, 'urun_ozellik_id', 'id');
    }
}
