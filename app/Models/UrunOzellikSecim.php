<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class UrunOzellikSecim extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'urun_ozellik_secim';

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
        'id',
        'urun_id',
        'urun_ozellik_id',
        'deger',
    ];


    /**
     * Ozellik ile ilişki.
     */
    public function ozellik()
    {
        return $this->belongsTo(UrunOzellik::class, 'urun_ozellik_id', 'id');
    }



    public function urunOzellikDiller()
    {
        return $this->hasMany(UrunOzellikDil::class, 'urun_ozellik_id', 'urun_ozellik_id');
    }
}
