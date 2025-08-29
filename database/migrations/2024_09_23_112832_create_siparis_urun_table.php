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
        Schema::create('siparis_urun', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("siparis_id");
            $table->string("urun_id");
            $table->text("urun_baslik");
            $table->decimal('kdv_oran', 5, 2);
            $table->boolean('kdv_durum');
            $table->integer("adet");
            $table->decimal('birim_fiyat', 12, 2);
            $table->decimal('iscilik_fiyat', 12, 2)->nullable()->default(0);
            $table->timestamps();
            $table->foreign('siparis_id')->references('id')->on('siparis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siparis_urun');
    }
};
