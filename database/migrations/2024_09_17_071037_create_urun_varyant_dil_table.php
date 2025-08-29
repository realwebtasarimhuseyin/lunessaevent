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
        Schema::create('urun_varyant_dil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('urun_varyant_id');
            $table->string('isim');
            $table->string('dil');
            $table->timestamps();
            $table->foreign('urun_varyant_id')->references('id')->on('urun_varyant')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urun_varyant_dil');
    }
};
