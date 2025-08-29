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
        Schema::create('urun_varyant_ozellik', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->integer('sira_no')->nullable();
            $table->unsignedBigInteger('urun_varyant_id');
            $table->boolean('durum')->default(true);
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admin')->onDelete('set null');
            $table->foreign('urun_varyant_id')->references('id')->on('urun_varyant')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urun_varyant_ozellik');
    }
};
