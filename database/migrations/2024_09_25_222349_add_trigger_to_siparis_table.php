<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER generate_siparis_kodu BEFORE INSERT ON siparis
            FOR EACH ROW
            BEGIN
                DECLARE yeni_kod VARCHAR(50);
                
                SET yeni_kod = CONCAT("SPR", DATE_FORMAT(NOW(), "%Y%m%d"), LPAD(FLOOR(RAND() * 10000), 5, "0"));
                
                WHILE (SELECT COUNT(*) FROM siparis WHERE kod = yeni_kod) > 0 DO
                    SET yeni_kod = CONCAT("S", DATE_FORMAT(NOW(), "%Y%m%d"), LPAD(FLOOR(RAND() * 10000), 5, "0"));
                END WHILE;

                SET NEW.kod = yeni_kod;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siparis', function (Blueprint $table) {
            //
        });
    }
};
