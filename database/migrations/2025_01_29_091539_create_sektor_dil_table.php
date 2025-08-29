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
        Schema::create('sektor_dil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sektor_id');
            $table->string('baslik');
            $table->text('icerik');
            
            $table->string('meta_baslik');
            $table->text('meta_icerik');
            $table->string('meta_anahtar');

            $table->string('slug');
            $table->string('dil');
            $table->timestamps();
            $table->foreign('sektor_id')->references('id')->on('sektor')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sektor_dil');
    }
};
