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
        Schema::create('urun_alt_kategori', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->integer('sira_no')->nullable();
            $table->unsignedBigInteger('urun_kategori_id');
            $table->boolean('durum')->default(true);
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admin')->onDelete('set null');
            $table->foreign('urun_kategori_id')->references('id')->on('urun_kategori')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urun_alt_kategori');
    }
};
