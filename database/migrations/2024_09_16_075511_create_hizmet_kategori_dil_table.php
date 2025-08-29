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
        Schema::create('hizmet_kategori_dil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hizmet_kategori_id');
            $table->string('isim');
            $table->string('slug')->unique();
            $table->string('dil');
            $table->timestamps();
            $table->foreign('hizmet_kategori_id')->references('id')->on('hizmet_kategori')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hizmet_kategori_dil');
    }
};
