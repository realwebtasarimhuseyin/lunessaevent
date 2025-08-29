<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YorumDil extends Model
{
    use HasFactory;

    /**
     * Bu modelin ilişkili olduğu tablo.
     *
     * @var string
     */
    protected $table = 'yorum_dil';

    /**
     * Tablo ile ilişkili birincil anahtar.
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

    /**
     * Toplu olarak atanabilir alanlar.
     *
     * @var array
     */
    protected $fillable = [
        'yorum_id', // Yorumun ID'si
        'icerik',   // Yorumun içeriği
        'dil'       // Yorumun dili
    ];

    /**
     * Bu YorumDil kaydının ait olduğu Yorum modelini getirir.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function yorum()
    {
        // YorumDil modelinin Yorum modeline ait olduğunu belirtir
        return $this->belongsTo(Yorum::class, 'yorum_id', 'id');
    }
}
