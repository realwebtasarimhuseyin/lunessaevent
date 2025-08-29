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
        Schema::create('siparis_urun_varyant', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('siparis_urun_id');
            $table->string('urun_varyant_isim');
            $table->string('urun_varyant_ozellik_isim');

            $table->timestamps();

            $table->foreign('siparis_urun_id')->references('id')->on('siparis_urun')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siparis_urun_varyant');
    }
};
