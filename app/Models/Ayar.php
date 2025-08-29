<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ayar extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ayar';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'ayar_isim',
        'created_at',
        'updated_at'
    ];

    public function ayarDiller()
    {
        return $this->hasMany(AyarDil::class, 'ayar_isim', 'ayar_isim');
    }
}
