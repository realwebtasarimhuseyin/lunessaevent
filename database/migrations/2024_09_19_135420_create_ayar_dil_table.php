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
        Schema::create('ayar_dil', function (Blueprint $table) {
            $table->id();
            $table->string('ayar_isim');
            $table->text('deger')->nullable();
            $table->string('dil');
            $table->timestamps();

            $table->foreign('ayar_isim')->references('ayar_isim')->on('ayar')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ayar_dil');
    }
};
