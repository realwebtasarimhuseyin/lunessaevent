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
        Schema::create('ilce', function (Blueprint $table) {
            $table->id();
            $table->string('ilce_isim', 150);
            $table->unsignedBigInteger('il_id');
            $table->foreign('il_id')->references('id')->on('il')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ilce');
    }
};
