<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderDil extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'slider_dil';

    /**
     * The primary key associated with the table.
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


    protected $fillable = [
        'slider_id',
        'baslik',
        'alt_baslik',
        'buton_icerik',
        'buton_url',
        'dil'
    ];

    /**
     * Get the Blog instance associated with this BlogDil.
     */
    public function slider()
    {
        return $this->belongsTo(Slider::class, 'slider_id', 'id');
    }
}
