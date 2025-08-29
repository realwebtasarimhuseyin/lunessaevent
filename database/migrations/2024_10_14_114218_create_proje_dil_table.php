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
        Schema::create('proje_dil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proje_id');
            $table->string('baslik');
            $table->text('icerik');
            
            $table->string('meta_baslik'); // snake_case formatında
            $table->text('meta_icerik'); // snake_case formatında
            $table->string('meta_anahtar'); // snake_case formatında

            $table->string('slug');
            $table->string('dil');
            $table->timestamps();
            $table->foreign('proje_id')->references('id')->on('proje')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proje_dil');
    }
};
