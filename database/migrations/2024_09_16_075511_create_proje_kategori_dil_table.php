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
        Schema::create('proje_kategori_dil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proje_kategori_id');
            $table->string('isim');
            $table->string('slug')->unique();
            $table->string('dil');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proje_kategori_dil');
    }
};
