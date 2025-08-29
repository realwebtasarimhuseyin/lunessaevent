<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Trigger oluşturma
        DB::unprepared('
            CREATE TRIGGER set_yorum_sira_no_before_insert
            BEFORE INSERT ON yorum
            FOR EACH ROW
            BEGIN
                DECLARE max_sira_no INT;
                -- Mevcut en büyük sira_no değerini al
                SELECT IFNULL(MAX(sira_no), 0) INTO max_sira_no FROM yorum;
                -- Yeni sira_no değerini ayarla
                SET NEW.sira_no = max_sira_no + 1;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yorum_sira_no_trigger');
    }
};
