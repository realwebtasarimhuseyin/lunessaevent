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
        Schema::create('kupon', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('kod')->unique();
            $table->integer('adet');
            $table->integer('tutar')->nullable();
            $table->integer('yuzde')->nullable();
            $table->dateTime('baslangic_tarih');
            $table->dateTime('bitis_tarih');
            $table->boolean('durum')->default(true);
            $table->timestamps();
            $table->foreign('admin_id')->references('id')->on('admin')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kupon');
    }
};
