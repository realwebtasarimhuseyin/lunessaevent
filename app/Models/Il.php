<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Il extends Model
{
    use HasFactory;

    protected $table = 'il';

    protected $primaryKey = 'id';

    public $timestamps = true;

    
    /**
     * Kütle atama (mass assignment) sırasında doldurulabilir sütunlar.
     *
     * @var array
     */
    protected $fillable = [
        'il_isim'
    ];


    public function ilceler()
    {
        return $this->hasMany(Ilce::class, 'il_id');
    }
}
