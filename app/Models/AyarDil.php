<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AyarDil extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ayar_dil';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'ayar_isim',
        'deger',
        'dil',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the Ayar instance associated with this AyarDil.
     */
    public function ayar()
    {
        return $this->belongsTo(Ayar::class, 'ayar_isim', 'ayar_isim');
    }
}
