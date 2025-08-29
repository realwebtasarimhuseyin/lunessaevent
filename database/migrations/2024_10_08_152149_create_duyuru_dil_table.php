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
        Schema::create('duyuru_dil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('duyuru_id');
            $table->text('icerik');
            $table->string('dil');
            $table->timestamps();
            $table->foreign('duyuru_id')->references('id')->on('duyuru')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('duyuru_dil');
    }
};
