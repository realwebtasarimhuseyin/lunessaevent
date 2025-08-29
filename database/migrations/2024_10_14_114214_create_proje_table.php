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
        Schema::create('proje', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('proje_kategori_id')->nullable();
            $table->string("sira_no")->nullable();

            $table->unsignedBigInteger('il_id');
            $table->string('tarih');
            $table->string('tur');
            $table->string('alan');
            $table->string('asama');

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
        Schema::dropIfExists('proje');
    }
};
