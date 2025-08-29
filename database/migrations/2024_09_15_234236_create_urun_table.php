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
        Schema::create('urun', function (Blueprint $table) {
            $table->id()->primary();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->integer('sira_no')->nullable();

            $table->unsignedBigInteger('urun_kategori_id');
            $table->unsignedBigInteger('urun_alt_kategori_id')->nullable();
            $table->unsignedBigInteger('kdv_id');
            $table->unsignedBigInteger('marka_id')->nullable();

            $table->integer('stok_adet');
            $table->string('stok_kod');
            $table->boolean('kdv_durum');
            $table->decimal('birim_fiyat', 12, 2);
            $table->decimal('indirim_yuzde', 5, 2)->nullable();
            $table->decimal('indirim_tutar', 8, 2)->nullable();
            $table->boolean('durum')->default(true);
            $table->boolean('ozel_alan_1')->default(false);
            $table->boolean('ozel_alan_2')->default(false);
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admin')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urun');
    }
};
