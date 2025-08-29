<?php

namespace App\Console\Commands;

use App\Models\Blog;
use App\Models\BlogDil;
use App\Models\Duyuru;
use App\Models\DuyuruDil;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class TestVerisi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-verisi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $desteklenenDil = Config::get('app.supported_locales');

        $duyuru = Duyuru::create(["admin_id" => 1]);
        foreach ($desteklenenDil as $dil) {
            DuyuruDil::create([
                'duyuru_id' => $duyuru->id,
                'icerik' => "Deneme Duyuru İçeriği",
                'dil' => $dil,
            ]);
        }

        $blog = Blog::create(["admin_id" => 1]);
        foreach ($desteklenenDil as $dil) {
            BlogDil::create([
                'blog_id' => $blog->id,
                'icerik' => "Deneme Duyuru İçeriği",
                'dil' => $dil,
            ]);
        }
    }
}
