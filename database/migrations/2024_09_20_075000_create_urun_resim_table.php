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
        Schema::create('urun_resim', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('urun_id');
            $table->string('resim_url');
            $table->integer("tip")->default(1);
            $table->timestamps();
            $table->foreign('urun_id')->references('id')->on('urun')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urun_resim');
    }
};
