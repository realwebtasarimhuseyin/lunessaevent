<?php

namespace App\Providers;

use App\Models\Urun;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {    
       /*  Route::bind('urun', function ($slug) {
            return Urun::getBySlug($slug) ?? abort(404);;
        }); */
    }
    
}
