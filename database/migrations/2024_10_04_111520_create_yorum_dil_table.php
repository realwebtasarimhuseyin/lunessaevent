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
        Schema::create('yorum_dil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('yorum_id');
            $table->text('icerik');
            $table->string('dil');
            $table->timestamps();
            $table->foreign('yorum_id')->references('id')->on('yorum')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yorum_dil');
    }
};