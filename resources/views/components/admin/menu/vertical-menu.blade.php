<div class="sidebar-wrapper sidebar-theme">
    <nav id="sidebar">
        <div class="navbar-nav theme-brand flex-row  text-center">
            <div class="nav-logo">
                <div class="nav-item theme-text">
                    <a href="{{ route('realpanel.index') }}" class="nav-link"> Lunessaevent </a>
                </div>
            </div>
            <div class="nav-item sidebar-toggle">
                <div class="btn-toggle sidebarCollapse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-chevrons-left">
                        <polyline points="11 17 6 12 11 7"></polyline>
                        <polyline points="18 17 13 12 18 7"></polyline>
                    </svg>
                </div>
            </div>
        </div>
        <div class="profile-info">
            <div class="user-info">
                <div class="profile-img">
                    <img src="{{ Vite::asset('resources/images/blank.png') }}" alt="avatar">
                </div>
                <div class="profile-content">
                    @auth('admin')
                        <h6 class="">
                            {{ e(optional(Auth::guard('admin')->user())->isim) . ' ' . e(optional(Auth::guard('admin')->user())->soyisim) }}
                        </h6>
                    @endauth
                </div>
            </div>
        </div>

        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu">
                <a href="{{ route('index') }}" target="_blank" aria-expanded="false"
                    class="dropdown-toggle btn btn-info mb-3">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            style="color: white !important" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link">
                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                            <polyline points="15 3 21 3 21 9"></polyline>
                            <line x1="10" y1="14" x2="21" y2="3"></line>
                        </svg>
                        <span>Web Site</span>
                    </div>
                </a>
            </li>

            <li class="menu {{ Request::routeIs('realpanel.index') ? 'active' : '' }}">
                <a href="{{ route('realpanel.index') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-map">
                            <polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon>
                            <line x1="8" y1="2" x2="8" y2="18"></line>
                            <line x1="16" y1="6" x2="16" y2="22"></line>
                        </svg>
                        <span>Anasayfa</span>
                    </div>
                </a>
            </li>

            {{-- <li class="menu {{ Request::routeIs('realpanel.duyuru.*') ? 'active' : '' }}">
                <a href="#duyuru" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::routeIs('realpanel.duyuru.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-bell">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        <span>Duyuru</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.duyuru.*') ? 'show' : '' }}"
                    id="duyuru" data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('realpanel.duyuru.index') ? 'active' : '' }}">
                        <a href="{{ route('realpanel.duyuru.index') }}"> Liste </a>
                    </li>
                    <li class="{{ Request::routeIs('realpanel.duyuru.ekle') ? 'active' : '' }}">
                        <a href="{{ route('realpanel.duyuru.ekle') }}"> Ekle </a>
                    </li>
                </ul>
            </li> --}}


             <li class="menu {{ Request::routeIs('realpanel.galeri.*') ? 'active' : '' }}">
                <a href="#galeri" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::routeIs('realpanel.galeri.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-package">
                            <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>
                            <path
                                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                            </path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                        <span>Galeri</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.galeri.*') ? 'show' : '' }}"
                    id="galeri" data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('realpanel.galeri.index') ? 'active' : '' }}">
                        <a href="{{ route('realpanel.galeri.index') }}"> Liste </a>
                    </li>
                    <li class="{{ Request::routeIs('realpanel.galeri.ekle') ? 'active' : '' }}">
                        <a href="{{ route('realpanel.galeri.ekle') }}"> Ekle </a>
                    </li>
                </ul> 
            </li>
{{-- 
             <li class="menu {{ Request::routeIs('realpanel.marka.*') ? 'active' : '' }}">
                <a href="#marka" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::routeIs('realpanel.marka.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-anchor">
                            <circle cx="12" cy="5" r="3"></circle>
                            <line x1="12" y1="22" x2="12" y2="8"></line>
                            <path d="M5 12H2a10 10 0 0 0 20 0h-3"></path>
                        </svg>
                        <span>Marka</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.marka.*') ? 'show' : '' }}"
                    id="marka" data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('realpanel.marka.index') ? 'active' : '' }}">
                        <a href="{{ route('realpanel.marka.index') }}"> Liste </a>
                    </li>
                    <li class="{{ Request::routeIs('realpanel.marka.ekle') ? 'active' : '' }}">
                        <a href="{{ route('realpanel.marka.ekle') }}"> Ekle </a>
                    </li>
                </ul>
            </li>  --}}

            @if (yetkiKontrol(['slider-tumunugor', 'slider-gor', 'slider-ekle']))
                <li class="menu {{ Request::routeIs('realpanel.slider.*') ? 'active' : '' }}">
                    <a href="#slider" data-bs-toggle="collapse"
                        aria-expanded="{{ Request::routeIs('realpanel.slider.*') ? 'true' : 'false' }}"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-play">
                                <polygon points="5 3 19 12 5 21 5 3"></polygon>
                            </svg>
                            <span>Slider</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.slider.*') ? 'show' : '' }}"
                        id="slider" data-bs-parent="#accordionExample">
                        @if (yetkiKontrol(['slider-tumunugor', 'slider-gor']))
                            <li class="{{ Request::routeIs('realpanel.slider.index') ? 'active' : '' }}">
                                <a href="{{ route('realpanel.slider.index') }}"> Liste </a>
                            </li>
                        @endif
                        @if (yetkiKontrol(['slider-ekle']))
                            <li class="{{ Request::routeIs('realpanel.slider.ekle') ? 'active' : '' }}">
                                <a href="{{ route('realpanel.slider.ekle') }}"> Ekle </a>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif

            @if (yetkiKontrol(['blog-tumunugor', 'blog-gor', 'blog-ekle']))
                <li class="menu {{ Request::routeIs('realpanel.blog.*') ? 'active' : '' }}">
                    <a href="#blog" data-bs-toggle="collapse"
                        aria-expanded="{{ Request::routeIs('realpanel.blog.*') ? 'true' : 'false' }}"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-pen-tool">
                                <path d="M12 19l7-7 3 3-7 7-3-3z"></path>
                                <path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"></path>
                                <path d="M2 2l7.586 7.586"></path>
                                <circle cx="11" cy="11" r="2"></circle>
                            </svg>
                            <span>Blog</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.blog.*') ? 'show' : '' }}"
                        id="blog" data-bs-parent="#accordionExample">

                        @if (yetkiKontrol(['blog-tumunugor', 'blog-gor']))
                            <li class="{{ Request::routeIs('realpanel.blog.index') ? 'active' : '' }}">
                                <a href="{{ route('realpanel.blog.index') }}"> Liste </a>
                            </li>
                        @endif
                        @if (yetkiKontrol(['blog-ekle']))
                            <li class="{{ Request::routeIs('realpanel.blog.ekle') ? 'active' : '' }}">
                                <a href="{{ route('realpanel.blog.ekle') }}"> Ekle </a>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif

            
            {{-- <li class="menu {{ Request::routeIs('realpanel.katalogkategori.*') ? 'active' : '' }}">
                <a href="#katalogkategori" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::routeIs('realpanel.katalogkategori.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag">
                            <path
                                d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z">
                            </path>
                            <line x1="7" y1="7" x2="7.01" y2="7"></line>
                        </svg>
                        <span>Katalog Kategori</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.katalogkategori.*') ? 'show' : '' }}"
                    id="katalogkategori" data-bs-parent="#accordionExample">
                        <li class="{{ Request::routeIs('realpanel.katalogkategori.index') ? 'active' : '' }}">
                            <a href="{{ route('realpanel.katalogkategori.index') }}"> Liste </a>
                        </li>
                   
                        <li class="{{ Request::routeIs('realpanel.katalogkategori.ekle') ? 'active' : '' }}">
                            <a href="{{ route('realpanel.katalogkategori.ekle') }}"> Ekle </a>
                        </li>
                </ul>
            </li> --}}


           {{--  <li class="menu {{ Request::routeIs('realpanel.katalog.*') ? 'active' : '' }}">
                <a href="#katalog" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::routeIs('realpanel.katalog.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag">
                            <path
                                d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z">
                            </path>
                            <line x1="7" y1="7" x2="7.01" y2="7"></line>
                        </svg>
                        <span>Sertifika</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.katalog.*') ? 'show' : '' }}"
                    id="katalog" data-bs-parent="#accordionExample">
                        <li class="{{ Request::routeIs('realpanel.katalog.index') ? 'active' : '' }}">
                            <a href="{{ route('realpanel.katalog.index') }}"> Liste </a>
                        </li>
                   
                        <li class="{{ Request::routeIs('realpanel.katalog.ekle') ? 'active' : '' }}">
                            <a href="{{ route('realpanel.katalog.ekle') }}"> Ekle </a>
                        </li>
                </ul>
            </li> 
 --}}
            @if (yetkiKontrol(['urun-kategori-tumunugor', 'urun-kategori-gor', 'urun-kategori-ekle']))
                <li class="menu {{ Request::routeIs('realpanel.urunkategori.*') ? 'active' : '' }}">
                    <a href="#urunkategori" data-bs-toggle="collapse"
                        aria-expanded="{{ Request::routeIs('realpanel.urunkategori.*') ? 'true' : 'false' }}"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag">
                                <path
                                    d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z">
                                </path>
                                <line x1="7" y1="7" x2="7.01" y2="7"></line>
                            </svg>
                            <span>Ürün Katagori</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.urunkategori.*') ? 'show' : '' }}"
                        id="urunkategori" data-bs-parent="#accordionExample">
                        @if (yetkiKontrol(['urun-kategori-tumunugor', 'urun-kategori-gor']))
                            <li class="{{ Request::routeIs('realpanel.urunkategori.index') ? 'active' : '' }}">
                                <a href="{{ route('realpanel.urunkategori.index') }}"> Liste </a>
                            </li>
                        @endif
                        @if (yetkiKontrol(['urun-kategori-ekle']))
                            <li class="{{ Request::routeIs('realpanel.urunkategori.ekle') ? 'active' : '' }}">
                                <a href="{{ route('realpanel.urunkategori.ekle') }}"> Ekle </a>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif 

             @if (yetkiKontrol(['urun-alt-kategori-tumunugor', 'urun-alt-kategori-gor', 'urun-alt-kategori-ekle']))
                <li class="menu {{ Request::routeIs('realpanel.urunaltkategori.*') ? 'active' : '' }}">
                    <a href="#urunaltkategori" data-bs-toggle="collapse"
                        aria-expanded="{{ Request::routeIs('realpanel.urunaltkategori.*') ? 'true' : 'false' }}"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                            <span>Ürün Alt Katagori</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.urunaltkategori.*') ? 'show' : '' }}"
                        id="urunaltkategori" data-bs-parent="#accordionExample">
                        @if (yetkiKontrol(['urun-alt-kategori-tumunugor', 'urun-alt-kategori-gor']))
                            <li class="{{ Request::routeIs('realpanel.urunaltkategori.index') ? 'active' : '' }}">
                                <a href="{{ route('realpanel.urunaltkategori.index') }}"> Liste </a>
                            </li>
                        @endif
                        @if (yetkiKontrol(['urun-alt-kategori-ekle']))
                            <li class="{{ Request::routeIs('realpanel.urunaltkategori.ekle') ? 'active' : '' }}">
                                <a href="{{ route('realpanel.urunaltkategori.ekle') }}"> Ekle </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif 

            {{-- @if (yetkiKontrol(['urun-varyant-tumunugor', 'urun-varyant-gor', 'urun-varyant-ekle']))
                <li class="menu {{ Request::routeIs('realpanel.urunvaryant.*') ? 'active' : '' }}">
                    <a href="#urunvaryant" data-bs-toggle="collapse"
                        aria-expanded="{{ Request::routeIs('realpanel.urunvaryant.*') ? 'true' : 'false' }}"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers">
                                <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                <polyline points="2 17 12 22 22 17"></polyline>
                                <polyline points="2 12 12 17 22 12"></polyline>
                            </svg>
                            <span>Ürün Varyant</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.urunvaryant.*') ? 'show' : '' }}"
                        id="urunvaryant" data-bs-parent="#accordionExample">
                        @if (yetkiKontrol(['urun-varyant-tumunugor', 'urun-varyant-gor']))
                            <li class="{{ Request::routeIs('realpanel.urunvaryant.index') ? 'active' : '' }}">
                                <a href="{{ route('realpanel.urunvaryant.index') }}"> Liste </a>
                            </li>
                        @endif
                        @if (yetkiKontrol(['urun-varyant-ekle']))
                            <li class="{{ Request::routeIs('realpanel.urunkategori.ekle') ? 'active' : '' }}">
                                <a href="{{ route('realpanel.urunvaryant.ekle') }}"> Ekle </a>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif --}}

            {{-- @if (yetkiKontrol(['urun-varyant-ozellik-tumunugor', 'urun-varyant-ozellik-gor', 'urun-varyant-ozellik-ekle']))
                <li class="menu {{ Request::routeIs('realpanel.urunvaryantozellik.*') ? 'active' : '' }}">
                    <a href="#urunvaryantozellik" data-bs-toggle="collapse"
                        aria-expanded="{{ Request::routeIs('realpanel.urunvaryantozellik.*') ? 'true' : 'false' }}"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-list">
                                <line x1="8" y1="6" x2="21" y2="6"></line>
                                <line x1="8" y1="12" x2="21" y2="12"></line>
                                <line x1="8" y1="18" x2="21" y2="18"></line>
                                <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                <line x1="3" y1="18" x2="3.01" y2="18"></line>
                            </svg>
                            <span>Ü. Varyant Özellik</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.urunvaryantozellik.*') ? 'show' : '' }}"
                        id="urunvaryantozellik" data-bs-parent="#accordionExample">
                        @if (yetkiKontrol(['urun-varyant-ozellik-tumunugor', 'urun-varyant-ozellik-gor']))
                            <li class="{{ Request::routeIs('realpanel.urunvaryantozellik.index') ? 'active' : '' }}">
                                <a href="{{ route('realpanel.urunvaryantozellik.index') }}"> Liste </a>
                            </li>
                        @endif
                        @if (yetkiKontrol(['urun-varyant-ozellik-ekle']))
                            <li class="{{ Request::routeIs('realpanel.urunvaryantozellik.ekle') ? 'active' : '' }}">
                                <a href="{{ route('realpanel.urunvaryantozellik.ekle') }}"> Ekle </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif --}}

            {{-- <li class="menu {{ Request::routeIs('realpanel.urunozellik.*') ? 'active' : '' }}">
                <a href="#urunozellik" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::routeIs('realpanel.urunozellik.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-layers">
                            <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                            <polyline points="2 17 12 22 22 17"></polyline>
                            <polyline points="2 12 12 17 22 12"></polyline>
                        </svg>
                        <span>Ürün Özellik</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.urunozellik.*') ? 'show' : '' }}"
                    id="urunozellik" data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('realpanel.urunozellik.index') ? 'active' : '' }}">
                        <a href="{{ route('realpanel.urunozellik.index') }}"> Liste </a>
                    </li>
                    <li class="{{ Request::routeIs('realpanel.urunozellik.ekle') ? 'active' : '' }}">
                        <a href="{{ route('realpanel.urunozellik.ekle') }}"> Ekle </a>
                    </li>
                </ul>
            </li>
 --}}
            {{-- @if (yetkiKontrol(['urun-kdv-tumunugor', 'urun-kdv-gor', 'urun-kdv-ekle']))
                <li class="menu {{ Request::routeIs('realpanel.urunkdv.*') ? 'active' : '' }}">
                    <a href="#urunkdv" data-bs-toggle="collapse"
                        aria-expanded="{{ Request::routeIs('realpanel.urunkdv.*') ? 'true' : 'false' }}"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                            <span>Ürün Kdv Yönetimi</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.urunkdv.*') ? 'show' : '' }}"
                        id="urunkdv" data-bs-parent="#accordionExample">
                        @if (yetkiKontrol(['urun-kdv-tumunugor', 'urun-kdv-gor']))
                            <li class="{{ Request::routeIs('realpanel.urunkdv.index') ? 'active' : '' }}">
                                <a href="{{ route('realpanel.urunkdv.index') }}"> Liste </a>
                            </li>
                        @endif
                        @if (yetkiKontrol(['urun-kdv-ekle']))
                            <li class="{{ Request::routeIs('realpanel.urunkdv.ekle') ? 'active' : '' }}">
                                <a href="{{ route('realpanel.urunkdv.ekle') }}"> Ekle </a>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif --}}

            @if (yetkiKontrol(['urun-tumunugor', 'urun-gor', 'urun-ekle']))
                <li class="menu {{ Request::routeIs('realpanel.urun.*') ? 'active' : '' }}">
                    <a href="#urun" data-bs-toggle="collapse"
                        aria-expanded="{{ Request::routeIs('realpanel.urun.*') ? 'true' : 'false' }}"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-package">
                                <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>
                                <path
                                    d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                </path>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                            </svg>
                            <span>Ürün</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.urun.*') ? 'show' : '' }}"
                        id="urun" data-bs-parent="#accordionExample">
                        @if (yetkiKontrol(['urun-tumunugor', 'urun-gor']))
                            <li class="{{ Request::routeIs('realpanel.urun.index') ? 'active' : '' }}">
                                <a href="{{ route('realpanel.urun.index') }}"> Liste </a>
                            </li>
                        @endif
                        @if (yetkiKontrol(['urun-ekle']))
                            <li class="{{ Request::routeIs('realpanel.urun.ekle') ? 'active' : '' }}">
                                <a href="{{ route('realpanel.urun.ekle') }}"> Ekle </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif 
{{-- 
            <li class="menu {{ Request::routeIs('realpanel.proje.*') ? 'active' : '' }}">
                <a href="#proje" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::routeIs('realpanel.proje.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-briefcase">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                        <span>Proje</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.proje.*') ? 'show' : '' }}"
                    id="proje" data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('realpanel.proje.index') ? 'active' : '' }}">
                        <a href="{{ route('realpanel.proje.index') }}"> Liste </a>
                    </li>
                    <li class="{{ Request::routeIs('realpanel.proje.ekle') ? 'active' : '' }}">
                        <a href="{{ route('realpanel.proje.ekle') }}"> Ekle </a>
                    </li>
                </ul>
            </li> 
 --}}

          {{--  <li class="menu {{ Request::routeIs('realpanel.projekategori.*') ? 'active' : '' }}">
                <a href="#projekategori" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::routeIs('realpanel.projekategori.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-tag">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z">
                            </path>
                            <line x1="7" y1="7" x2="7.01" y2="7"></line>
                        </svg>
                        <span>Proje Katagori</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.projekategori.*') ? 'show' : '' }}"
                    id="projekategori" data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('realpanel.projekategori.index') ? 'active' : '' }}">
                        <a href="{{ route('realpanel.projekategori.index') }}"> Liste </a>
                    </li>
                    <li class="{{ Request::routeIs('realpanel.projekategori.ekle') ? 'active' : '' }}">
                        <a href="{{ route('realpanel.projekategori.ekle') }}"> Ekle </a>
                    </li>
                </ul>
            </li> 
 --}}
             {{-- <li class="menu {{ Request::routeIs('realpanel.hizmet.*') ? 'active' : '' }}">
                <a href="#hizmet" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::routeIs('realpanel.hizmet.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-briefcase">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                        <span>Hizmet</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.hizmet.*') ? 'show' : '' }}"
                    id="hizmet" data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('realpanel.hizmet.index') ? 'active' : '' }}">
                        <a href="{{ route('realpanel.hizmet.index') }}"> Liste </a>
                    </li>
                    <li class="{{ Request::routeIs('realpanel.hizmet.ekle') ? 'active' : '' }}">
                        <a href="{{ route('realpanel.hizmet.ekle') }}"> Ekle </a>
                    </li>
                </ul>
            </li>  --}}


           {{-- <li class="menu {{ Request::routeIs('realpanel.hizmetkategori.*') ? 'active' : '' }}">
                <a href="#hizmetkategori" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::routeIs('realpanel.hizmetkategori.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-tag">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z">
                            </path>
                            <line x1="7" y1="7" x2="7.01" y2="7"></line>
                        </svg>
                        <span>Hizmet Katagori</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.hizmetkategori.*') ? 'show' : '' }}"
                    id="hizmetkategori" data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('realpanel.hizmetkategori.index') ? 'active' : '' }}">
                        <a href="{{ route('realpanel.hizmetkategori.index') }}"> Liste </a>
                    </li>
                    <li class="{{ Request::routeIs('realpanel.hizmetkategori.ekle') ? 'active' : '' }}">
                        <a href="{{ route('realpanel.hizmetkategori.ekle') }}"> Ekle </a>
                    </li>
                </ul>
            </li>  --}}

{{-- 
          <li class="menu {{ Request::routeIs('realpanel.ekip.*') ? 'active' : '' }}">
                <a href="#ekip" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::routeIs('realpanel.ekip.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-clipboard">
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                            <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                        </svg>
                        <span>Nasıl Çalışırız</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.ekip.*') ? 'show' : '' }}"
                    id="ekip" data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('realpanel.ekip.index') ? 'active' : '' }}">
                        <a href="{{ route('realpanel.ekip.index') }}"> Liste </a>
                    </li>
                    <li class="{{ Request::routeIs('realpanel.ekip.ekle') ? 'active' : '' }}">
                        <a href="{{ route('realpanel.ekip.ekle') }}"> Ekle </a>
                    </li>
                </ul>
            </li> --}}

            {{--  <li class="menu {{ Request::routeIs('realpanel.sektor.*') ? 'active' : '' }}">
                <a href="#sektor" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::routeIs('realpanel.sektor.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-briefcase">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                        <span>Sektör</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.sektor.*') ? 'show' : '' }}"
                    id="sektor" data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('realpanel.sektor.index') ? 'active' : '' }}">
                        <a href="{{ route('realpanel.sektor.index') }}"> Liste </a>
                    </li>
                    <li class="{{ Request::routeIs('realpanel.sektor.ekle') ? 'active' : '' }}">
                        <a href="{{ route('realpanel.sektor.ekle') }}"> Ekle </a>
                    </li>
                </ul>
            </li> --}}

            {{-- @if (yetkiKontrol(['kupon-tumunugor', 'kupon-gor', 'kupon-ekle']))
                <li class="menu {{ Request::routeIs('realpanel.kupon.*') ? 'active' : '' }}">
                    <a href="#kupon" data-bs-toggle="collapse"
                        aria-expanded="{{ Request::routeIs('realpanel.kupon.*') ? 'true' : 'false' }}"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-percent">
                                <line x1="19" y1="5" x2="5" y2="19"></line>
                                <circle cx="6.5" cy="6.5" r="2.5"></circle>
                                <circle cx="17.5" cy="17.5" r="2.5"></circle>
                            </svg>
                            <span>Kupon</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.kupon.*') ? 'show' : '' }}"
                        id="kupon" data-bs-parent="#accordionExample">
                        @if (yetkiKontrol(['kupon-tumunugor', 'kupon-gor']))
                            <li class="{{ Request::routeIs('realpanel.kupon.index') ? 'active' : '' }}">
                                <a href="{{ route('realpanel.kupon.index') }}"> Liste </a>
                            </li>
                        @endif
                        @if (yetkiKontrol(['kupon-ekle']))
                            <li class="{{ Request::routeIs('realpanel.kupon.ekle') ? 'active' : '' }}">
                                <a href="{{ route('realpanel.kupon.ekle') }}"> Ekle </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif --}}
            {{-- @if (yetkiKontrol(['popup-tumunugor', 'popup-gor', 'popup-ekle']))
                <li class="menu {{ Request::routeIs('realpanel.popup.*') ? 'active' : '' }}">
                    <a href="#popup" data-bs-toggle="collapse"
                        aria-expanded="{{ Request::routeIs('realpanel.popup.*') ? 'true' : 'false' }}"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2">
                                </rect>
                                <line x1="3" y1="9" x2="21" y2="9"></line>
                                <line x1="9" y1="21" x2="9" y2="9"></line>
                            </svg>
                            <span>Popup</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.popup.*') ? 'show' : '' }}"
                        id="popup" data-bs-parent="#accordionExample">
                        @if (yetkiKontrol(['popup-tumunugor', 'popup-gor']))
                            <li class="{{ Request::routeIs('realpanel.popup.index') ? 'active' : '' }}">
                                <a href="{{ route('realpanel.popup.index') }}"> Liste </a>
                            </li>
                        @endif
                        @if (yetkiKontrol(['popup-ekle']))
                            <li class="{{ Request::routeIs('realpanel.popup.ekle') ? 'active' : '' }}">
                                <a href="{{ route('realpanel.popup.ekle') }}"> Ekle </a>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif --}}
           {{--  @if (yetkiKontrol(['sss-tumunugor', 'sss-gor', 'sss-ekle']))
                <li class="menu {{ Request::routeIs('realpanel.sss.*') ? 'active' : '' }}">
                    <a href="#sss" data-bs-toggle="collapse"
                        aria-expanded="{{ Request::routeIs('realpanel.sss.*') ? 'true' : 'false' }}"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-help-circle">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                            <span>SSS</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.sss.*') ? 'show' : '' }}"
                        id="sss" data-bs-parent="#accordionExample">
                        @if (yetkiKontrol(['sss-tumunugor', 'sss-gor']))
                            <li class="{{ Request::routeIs('realpanel.sss.index') ? 'active' : '' }}">
                                <a href="{{ route('realpanel.sss.index') }}"> Liste </a>
                            </li>
                        @endif
                        @if (yetkiKontrol(['sss-ekle']))
                            <li class="{{ Request::routeIs('realpanel.sss.ekle') ? 'active' : '' }}">
                                <a href="{{ route('realpanel.sss.ekle') }}"> Ekle </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif --}}
            @if (yetkiKontrol(['sayfayonetim-gor']))
                <li class="menu {{ Request::routeIs('realpanel.sayfayonetim.*') ? 'active' : '' }}">
                    <a href="{{ route('realpanel.sayfayonetim.index') }}" aria-expanded="false"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder">
                                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z">
                                </path>
                            </svg>
                            <span>Sayfa Yönetim</span>
                        </div>
                    </a>
                </li>
            @endif
            {{-- @if (yetkiKontrol(['siparis-gor']))
                <li class="menu {{ Request::routeIs('realpanel.siparis.*') ? 'active' : '' }}">
                    <a href="{{ route('realpanel.siparis.index') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck">
                                <rect x="1" y="3" width="15" height="13"></rect>
                                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                            </svg>
                            <span>Sipariş</span>
                        </div>
                    </a>
                </li>
            @endif --}}
            @if (yetkiKontrol(['iletisimform-gor']))
                <li class="menu {{ Request::routeIs('realpanel.iletisimform.*') ? 'active' : '' }}">
                    <a href="{{ route('realpanel.iletisimform.index') }}" aria-expanded="false"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                </path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <span>İletişim Form</span>
                        </div>
                    </a>
                </li>
            @endif

         {{--    @if (yetkiKontrol(['bulten-gor']))
                <li class="menu {{ Request::routeIs('realpanel.bulten.*') ? 'active' : '' }}">
                    <a href="{{ route('realpanel.bulten.index') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-send">
                                <line x1="22" y1="2" x2="11" y2="13"></line>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                            </svg>
                            <span>Bülten</span>
                        </div>
                    </a>
                </li>
            @endif --}}
            
            <li class="menu {{ Request::routeIs('realpanel.yorum.*') ? 'active' : '' }}">
                <a href="#yorum" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::routeIs('realpanel.yorum.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-pen-tool">
                            <path d="M12 19l7-7 3 3-7 7-3-3z"></path>
                            <path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"></path>
                            <path d="M2 2l7.586 7.586"></path>
                            <circle cx="11" cy="11" r="2"></circle>
                        </svg>
                        <span>Yorum</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.yorum.*') ? 'show' : '' }}"
                    id="yorum" data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('realpanel.yorum.index') ? 'active' : '' }}">
                        <a href="{{ route('realpanel.yorum.index') }}"> Liste </a>
                    </li>
                    <li class="{{ Request::routeIs('realpanel.yorum.ekle') ? 'active' : '' }}">
                        <a href="{{ route('realpanel.yorum.ekle') }}"> Ekle </a>
                    </li>
                </ul>
            </li>

            {{-- @if (yetkiKontrol(['kullanici-gor']))
                <li class="menu {{ Request::routeIs('realpanel.kullanici.*') ? 'active' : '' }}">
                    <a href="{{ route('realpanel.kullanici.index') }}" aria-expanded="false"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span>Kullanıcı</span>
                        </div>
                    </a>
                </li>
            @endif --}}

            {{-- @if (auth()->guard('admin')->user()->isSuperAdmin())
                <li class="menu {{ Request::routeIs('realpanel.yetki.*') ? 'active' : '' }}">
                    <a href="#yetki" data-bs-toggle="collapse"
                        aria-expanded="{{ Request::routeIs('realpanel.yetki.*') ? 'true' : 'false' }}"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                            <span>Yetki Yönetim</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.yetki.*') ? 'show' : '' }}"
                        id="yetki" data-bs-parent="#accordionExample">
                        <li class="{{ Request::routeIs('realpanel.yetki.index') ? 'active' : '' }}">
                            <a href="{{ route('realpanel.yetki.index') }}"> Liste </a>
                        </li>
                        <li class="{{ Request::routeIs('realpanel.yetki.ekle') ? 'active' : '' }}">
                            <a href="{{ route('realpanel.yetki.ekle') }}"> Ekle </a>
                        </li>
                    </ul>
                </li>
            @endif --}}

            @if (yetkiKontrol(['admin-tumunugor', 'admin-gor', 'admin-ekle']))
                <li class="menu {{ Request::routeIs('realpanel.admin.*') ? 'active' : '' }}">
                    <a href="#admin" data-bs-toggle="collapse"
                        aria-expanded="{{ Request::routeIs('realpanel.admin.*') ? 'true' : 'false' }}"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                            <span>Admin</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ Request::routeIs('realpanel.admin.*') ? 'show' : '' }}"
                        id="admin" data-bs-parent="#accordionExample">
                        @if (yetkiKontrol(['admin-tumunugor', 'admin-gor']))
                            <li class="{{ Request::routeIs('realpanel.admin.index') ? 'active' : '' }}">
                                <a href="{{ route('realpanel.admin.index') }}"> Liste </a>
                            </li>
                        @endif
                        @if (yetkiKontrol(['admin-ekle']))
                            <li class="{{ Request::routeIs('realpanel.admin.ekle') ? 'active' : '' }}">
                                <a href="{{ route('realpanel.admin.ekle') }}"> Ekle </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (yetkiKontrol(['ayar-gor', 'ayar-duzenle']))
                <li class="menu {{ Request::routeIs('realpanel.ayar.*') ? 'active' : '' }}">
                    <a href="{{ route('realpanel.ayar.index') }}" aria-expanded="false"
                        class="dropdown-toggle mb-4">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path
                                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                </path>
                            </svg>
                            <span>Ayar</span>
                        </div>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</div>
