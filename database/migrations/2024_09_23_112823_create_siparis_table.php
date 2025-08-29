<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siparis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kullanici_id');
            $table->string("kod")->nullable();
            $table->string('kupon_kod')->nullable();
            $table->unsignedBigInteger('indirim_tutar')->nullable();
            $table->unsignedBigInteger('toplam_tutar')->nullable();
            $table->unsignedBigInteger('kargo_tutar')->nullable();
            $table->string('odeme_tip');
            $table->integer('durum')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siparis');
    }
};
