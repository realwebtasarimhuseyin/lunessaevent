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
        Schema::create('urun_varyant_secim', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('urun_id');
            $table->json('urun_varyantlar');
            $table->decimal('birim_fiyat', 12, 2)->default(0);
            $table->integer('stok_adet');
            $table->string('stok_kod');
            $table->timestamps();

            $table->foreign('urun_id')->references('id')->on('urun')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urun_varyant_secim');
    }
};
