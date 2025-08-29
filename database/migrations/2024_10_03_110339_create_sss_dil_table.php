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
        Schema::create('sss_dil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sss_id');
            $table->string('baslik');
            $table->text('icerik');
            $table->string('dil');
            $table->timestamps();

            $table->foreign('sss_id')->references('id')->on('sss')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sss_dil');
    }
};
