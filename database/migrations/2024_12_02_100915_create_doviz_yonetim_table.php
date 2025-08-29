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
        Schema::create('doviz_yonetim', function (Blueprint $table) {
            $table->id();
            $table->string('doviz_slug')->unique();
            $table->string('kaynak');
            $table->decimal("yuzde", 8, 2);
            $table->decimal("birim", 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doviz_yonetim');
    }
};
