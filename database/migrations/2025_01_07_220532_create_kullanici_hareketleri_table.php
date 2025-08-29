<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kullanici_hareketleri', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kullanici_id')->nullable();
            $table->string('ip_adresi', 45);
            $table->string('url');
            $table->string('tarayici_isim');
            $table->string('tarayici_surum');
            $table->string('platform_isim');
            $table->string('platform_surum');
            $table->string('cihaz_tip');
            $table->string('bot_bilgi');
            $table->string('il_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kullanici_hareketleri');
    }
};
