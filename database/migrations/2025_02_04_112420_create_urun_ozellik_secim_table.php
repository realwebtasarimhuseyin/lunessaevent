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
        Schema::create('urun_ozellik_secim', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('urun_id');
            $table->unsignedBigInteger('urun_ozellik_id');
            $table->string('deger');
            $table->timestamps();

            $table->foreign('urun_id')->references('id')->on('urun')->onDelete('cascade');
            $table->foreign('urun_ozellik_id')->references('id')->on('urun_ozellik')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urun_ozellik_secim');
    }
};
