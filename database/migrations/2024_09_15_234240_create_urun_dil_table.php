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
        Schema::create('urun_dil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('urun_id');
            $table->string('baslik');
            $table->longText('icerik');
            $table->string('meta_baslik');
            $table->string('meta_anahtar');
            $table->text('meta_icerik');
            $table->string('slug')->unique();
            $table->string('dil');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('urun_id')->references('id')->on('urun')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urun_dil');
    }
};
