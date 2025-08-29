<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // urun_kategori tetikleyicisini kaldır ve yeniden oluştur
        DB::unprepared('
            CREATE TRIGGER set_urun_kategori_sira_no_before_insert
            BEFORE INSERT ON urun_kategori
            FOR EACH ROW
            BEGIN
                DECLARE max_sira_no INT;
                -- Mevcut en büyük sira_no değerini al
                SELECT IFNULL(MAX(sira_no), 0) INTO max_sira_no FROM urun_kategori;
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
        // Tetkileyicileri kaldır
        DB::unprepared('DROP TRIGGER IF EXISTS set_kategori_sira_no_before_insert;');
    }
};
