<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB as FacadesDB;

class ResetSiraNo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:sirano {table} {column}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tablolardaki sıralama numaralarını sıfırlar ve yeniden oluşturur.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Parametreleri al
        $table = $this->argument('table');
        $column = $this->argument('column');

        // Komut satırında verilen tabloyu ve sütunu kullanarak sıralama numarasını sıfırla
        $this->info("Tablo: $table, Sütun: $column");

        // Sıralama numaralarını baştan oluşturma işlemi
        $this->resetSiraNo($table, $column);
    }

    /**
     * Sıralama numaralarını baştan oluştur.
     *
     * @param string $table
     * @param string $column
     * @return void
     */
    private function resetSiraNo($table, $column)
    {
        FacadesDB::transaction(function () use ($table, $column) {
            FacadesDB::statement("SET @sira_no = 0;");

            FacadesDB::statement("UPDATE $table SET $column = (@sira_no := @sira_no + 1) ORDER BY $column ASC;");
        });

        $this->info("Sıralama numaraları başarıyla güncellendi.");
    }
}
