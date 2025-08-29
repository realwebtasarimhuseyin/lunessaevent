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
        Schema::create('proje_resim', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proje_id');
            $table->string('resim_url');
            $table->integer("tip")->default(1);
            $table->timestamps();
            $table->foreign('proje_id')->references('id')->on('proje')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proje_resim');
    }
};
