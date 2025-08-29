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
        Schema::create('siparis_bilgi', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('siparis_id');

            $table->string("sirket_isim")->nullable();
            $table->string("isim");
            $table->string("tc_vergi_no");
            $table->string("vergi_dairesi")->nullable();
            $table->string("eposta");
            $table->string("telefon");
            $table->text("adres");
            $table->boolean("fatura_adres");
            $table->timestamps();

            $table->foreign('siparis_id')->references('id')->on('siparis')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siparis_bilgi');
    }
};
