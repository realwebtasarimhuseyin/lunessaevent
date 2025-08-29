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
        Schema::create('sayfa_yonetim', function (Blueprint $table) {
            $table->id();
            $table->integer('sira_no')->nullable();
            $table->string('slug')->unique();
            $table->string('resim_url')->nullable();
            $table->boolean('resim_izin');
            $table->boolean('durum')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sayfa_yonetim');
    }
};
