<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Cache;

use App\Enums\DilEnum;
use App\Helper\IpApiHelper;
use App\Models\Blog;
use App\Models\Duyuru;
use App\Models\Hizmet;
use App\Models\Il;
use App\Models\Marka;
use App\Models\SayfaYonetim;
use App\Models\Urun;
use App\Models\UrunKategori;
use App\Models\UrunVaryant;

use Closure;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use hisorange\BrowserDetect\Parser as Browser;


class VeriPaylasim
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        View::share('varsayilanDil', Config::get('app.locale'));
        View::share('desteklenenDil', Config::get('app.supported_locales'));


        View::share('duyurular', Duyuru::aktif()->orderBy('sira_no', 'asc')->get());

        View::share('urunKategoriler', UrunKategori::aktif()->withCount('urunler')->orderBy('sira_no', 'asc')->get());
        View::share('menuUrunKategoriler', UrunKategori::menuAktif()->orderBy('sira_no', 'asc')->get());
        View::share('anaSayfaUrunKategoriler', UrunKategori::anaSayfaAktif()->orderBy('sira_no', 'asc')->get());

        View::share('urunVaryantlar', UrunVaryant::aktif()->orderBy('sira_no', 'asc')->get());
        View::share('markalar', Marka::aktif()->withCount('urunler')->orderBy('sira_no', 'asc')->get());

        View::share('bloglar', Blog::aktif()->orderBy('sira_no', 'asc')->limit(3)->get());
        View::share('hizmetler', Hizmet::aktif()->orderBy('sira_no', 'asc')->get());
        View::share('urunler', Urun::aktif()->orderBy('sira_no', 'asc')->get());

        View::share('sepet', session()->get('sepet', []));

        View::share('iller', Il::all());
        View::share('ipInfo', IpApiHelper::getIpInfo());
        View::share('cihazTipi', (Browser::isDesktop() ? "Bilgisayar" : (Browser::isMobile() ? "Telefon" : "Diğer")));

        View::composer('*', function ($view) {
            $sayfa = SayfaYonetim::where('slug', 'hakkimizda')->first();
            $dilIcerik = optional($sayfa->SayfaYonetimDiller->where('dil', app()->getLocale())->first())->icerik;
            $view->with('hakkimizda', $dilIcerik);
        });

        View::composer('*', function ($view) {
            $view->with('tamDil', function ($value) {
                return DilEnum::fromValue($value);
            });
        });

        return $next($request);
    }
}
