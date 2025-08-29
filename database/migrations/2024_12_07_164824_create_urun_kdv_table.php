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
        Schema::create('urun_kdv', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('baslik');
            $table->integer('sira_no')->nullable();
            $table->integer('kdv');
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
        Schema::dropIfExists('urun_kdv');
    }
};
