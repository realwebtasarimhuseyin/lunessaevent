<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopupDil extends Model
{
    use HasFactory;

    /**
     * Bu modelin bağlı olduğu veritabanı tablosunun adı.
     *
     * @var string
     */
    protected $table = 'popup_dil';

    /**
     * Tabloyla ilişkili birincil anahtar (primary key) sütununun adı.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Modelin zaman damgaları (created_at, updated_at) otomatik olarak yönetilip
     * yönetilmeyeceğini belirler.
     * true olarak ayarlanmışsa, Laravel bu alanları otomatik olarak oluşturur.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Toplu atama (mass assignment) ile doldurulabilecek model özelliklerinin
     * bir listesini belirtir.
     *
     * @var array
     */
    protected $fillable = [
        'popup_id',
        'baslik',
        'icerik',
        'dil'
    ];
}
