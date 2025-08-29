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
        Schema::create('sayfa_yonetim_dil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sayfa_yonetim_id');
            $table->longText('icerik');
            $table->string('meta_baslik');
            $table->string('meta_anahtar');
            $table->text('meta_icerik');
            $table->string('dil');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('sayfa_yonetim_id')->references('id')->on('sayfa_yonetim')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sayfa_yonetim_dil');
    }
};
