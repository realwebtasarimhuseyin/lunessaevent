<x-layout.web>
    <x-slot:baslik>
        {{ ayar('siteBaslik', $aktifDil) }} | {{ $vitrinBaslik }}
    </x-slot>
    <x-slot:aciklama>
        {{ ayar('metaIcerik', $aktifDil) }}
    </x-slot>
    <x-slot:anahtar>
        {{ ayar('metaAnahtar', $aktifDil) }}
    </x-slot>

    <section class="section-b-space pt-0">
        <div class="heading-banner">
            <div class="custom-container container">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4>{{ $vitrinBaslik }}</h4>
                    </div>
                    <div class="col-sm-6">
                        <ul class="breadcrumb float-end">
                            <li class="breadcrumb-item"><a href="{{ rota('index') }}"> Anasayfa </a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);"> {{ $vitrinBaslik }} </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-b-space pt-0">
        <div class="custom-container container">
            <div class="row">
                <div class="col-12">
                    <div class="sticky">
                        <div class="top-filter-menu">
                            <div>
                                <a class="filter-button btn">
                                    <h6><i class="iconsax" data-icon="filter"></i> Filtreleme </h6>
                                </a>
                                <div class="category-dropdown">
                                    <label for="cars">Sıralama :</label>

                                    <select class="form-select filtre-select">
                                        <option value="" @if (empty($filtre))
                                            'selected'
                                        @endif>İlgili</option>
                                        <option value="" @if ($filtre == 'a-z')
                                            'selected'
                                        @endif>İsim (A-Z)</option>
                                        <option value="" @if ($filtre == 'z-a')
                                            'selected'
                                        @endif>İsim (Z-A)</option>
                                        <option value="" @if ($filtre == '0-1')
                                            'selected'
                                        @endif>Fiyat(Düşük)</option>
                                        <option value="" @if ($filtre == '1-0')
                                            'selected'
                                        @endif>Fiyat(Yüksek)</option>
                                    </select>
                                </div>
                            </div>
                            <ul class="filter-option-grid">
                                <li class="nav-item d-none d-md-flex">
                                    <button class="nav-link" data-grid="2">
                                        <svg>
                                            <use href="{{asset('web/icons/icon-sprite.svg#grid-2')}}"></use>
                                        </svg>
                                    </button>
                                </li>
                                <li class="nav-item d-none d-md-flex">
                                    <button class="nav-link" data-grid="3">
                                        <svg>
                                            <use href="{{asset('web/icons/icon-sprite.svg#grid-3')}}"></use>
                                        </svg>
                                    </button>
                                </li>
                                <li class="nav-item d-none d-lg-flex">
                                    <button class="nav-link active" data-grid="4">
                                        <svg>
                                            <use href="{{asset('web/icons/icon-sprite.svg#grid-4')}}"></use>
                                        </svg>
                                    </button>
                                </li>

                            </ul>
                        </div>
                        <div class="product-tab-content ratio1_3">
                            <div class="row-cols-lg-4 row-cols-md-3 row-cols-2 grid-section view-option row g-3 g-xl-4">


                                @foreach ($urunler as $urun)
                                    @php
                                        $urunDilVerisi = dilVerisi($urun, 'urunDiller')->first();
                                        $urunAnaResim = $urun->urunResimler->where('tip', 1)->first();
                                        $urunNormalResim = $urun->urunResimler->where('tip', 2)->first();
                                    @endphp

                                    <div>
                                        <div class="product-box-3">
                                            <div class="img-wrapper">
                                                @if ($urun->stok_adet < 1)
                                                    <div class="stok-yok-etiket">
                                                        Tükendi
                                                    </div>
                                                @endif
                                                <div class="label-block">
                                                    @auth('web')
                                                        <a class="label-2 wishlist-icon favori-ekle-btn {{ $urun->favorideMi() == true ? 'd-none' : '' }}"
                                                            urun-id="{{ $urun->id }}" href="javascript:void(0)"
                                                            tabindex="0">
                                                            <i class="fa-regular fa-heart"></i>
                                                        </a>
    
                                                        <a class="label-2 wishlist-icon favori-sil-btn urun-detay {{ $urun->favorideMi() == false ? 'd-none' : '' }}"
                                                            urun-id="{{ $urun->id }}" href="javascript:void(0)"
                                                            tabindex="0">
                                                            <i class="fa-solid fa-heart"></i>
                                                        </a>
                                                    @endauth
    
                                                </div>
                                                <div class="product-image">
                                                    <a class="pro-first"
                                                       href="{{rota('urun-detay', ['slug' => $urunDilVerisi->slug])}}">
                                                        <img
                                                                class="bg-img"
                                                                src="{{depolamaUrl($urunAnaResim)}}"
                                                                alt=" {{ $urunDilVerisi->baslik }}">
                                                    </a>
                                                    <a class="pro-sec"
                                                       href="{{rota('urun-detay', ['slug' => $urunDilVerisi->slug])}}">
                                                        <img class="bg-img"
                                                             src="{{depolamaUrl($urunNormalResim)}}"
                                                             alt=" {{ $urunDilVerisi->baslik }}">
                                                    </a>
                                                </div>
                                                <div class="cart-info-icon">

                                                    <a href="{{rota('urun-detay', ['slug' => $urunDilVerisi->slug])}}">
                                                        <i class="iconsax" data-icon="eye"
                                                           aria-hidden="true" data-bs-toggle="tooltip"
                                                           data-bs-title="Ürünü İncele"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="product-detail">

                                                <a href="{{rota('urun-detay', ['slug' => $urunDilVerisi->slug])}}">
                                                    <h6> {{ $urunDilVerisi->baslik }}</h6>
                                                </a>
                                                <p class="list-per"></p>
                                                <p>

                                                    {{ formatPara(indirimliFiyatHesapla($urun)) }} TL

                                                    @if (tekliIndirimOran($urun) > 0)
                                                        <del> {{ formatPara($urun->birim_fiyat) }} TL</del>
                                                        <span>{{formatIndirimYuzdesi(tekliIndirimOran($urun)) }}%</span>
                                                    @endif


                                                </p>
                                                <div class="listing-button">
                                                    <a class="btn"
                                                       href="{{rota('urun-detay', ['slug' => $urunDilVerisi->slug])}}">
                                                        Ürünü İncele
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach


                            </div>
                        </div>
                        <div class="pagination-wrap">
                            @if ($urunler->hasPages())
                                <ul class="pagination">
                                    {{-- Önceki Sayfa Butonu --}}
                                    @if ($urunler->onFirstPage())
                                        <li class="disabled">
                                            <a class="prev"><i class="iconsax" data-icon="chevron-left"></i></a>
                                        </li>
                                    @else
                                        <li>
                                            <a class="prev" href="{{ $urunler->previousPageUrl() }}"><i class="iconsax" data-icon="chevron-left"></i></a>
                                        </li>
                                    @endif

                                    {{-- Sayfa Numaraları --}}
                                    @php
                                        $currentPage = $urunler->currentPage();
                                        $lastPage = $urunler->lastPage();
                                    @endphp

                                    @for ($i = 1; $i <= $lastPage; $i++)
                                        @if ($i == 1 || $i == $lastPage || ($i >= $currentPage - 1 && $i <= $currentPage + 1))
                                            @if ($i == $currentPage)
                                                <li><a class="active" href="#">{{ $i }}</a></li>
                                            @else
                                                <li><a href="{{ $urunler->url($i) }}">{{ $i }}</a></li>
                                            @endif
                                        @elseif ($i == 2 && $currentPage > 3)
                                            <li><a href="#">...</a></li>
                                        @elseif ($i == $lastPage - 1 && $currentPage < $lastPage - 2)
                                            <li><a href="#">...</a></li>
                                        @endif
                                    @endfor

                                    {{-- Sonraki Sayfa Butonu --}}
                                    @if ($urunler->hasMorePages())
                                        <li>
                                            <a class="next" href="{{ $urunler->nextPageUrl() }}"><i class="iconsax" data-icon="chevron-right"></i></a>
                                        </li>
                                    @else
                                        <li class="disabled">
                                            <a class="next"><i class="iconsax" data-icon="chevron-right"></i></a>
                                        </li>
                                    @endif
                                </ul>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script>
        const enBuyukBirimFiyat = {{ $enBuyukBirimFiyat }};
    </script>
</x-layout.web>
