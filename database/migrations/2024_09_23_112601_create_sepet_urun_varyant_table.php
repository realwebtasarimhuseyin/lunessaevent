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
        Schema::create('sepet_urun_varyant', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sepet_id');
            $table->unsignedBigInteger('urun_id');
            $table->unsignedBigInteger('urun_varyant_id');
            $table->unsignedBigInteger('urun_varyant_ozellik_id');

            $table->timestamps();

            $table->foreign('sepet_id')->references('id')->on('sepet')->onDelete('cascade');
            $table->foreign('urun_id')->references('id')->on('urun')->onDelete('cascade');
            $table->foreign('urun_varyant_id')->references('id')->on('urun_varyant')->onDelete('cascade');
            $table->foreign('urun_varyant_ozellik_id')->references('id')->on('urun_varyant_ozellik')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sepet_urun_varyant');
    }
};
