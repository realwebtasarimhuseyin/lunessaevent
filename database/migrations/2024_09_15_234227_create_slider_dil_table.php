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
        Schema::create('slider_dil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('slider_id');
            $table->string('baslik')->nullable();
            $table->string('alt_baslik')->nullable();
            $table->string('buton_icerik')->nullable();
            $table->string('buton_url')->nullable();
            $table->string('dil');
            $table->timestamps();
            $table->foreign('slider_id')->references('id')->on('slider')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slider_dil');
    }
};
