<x-layout.web>
    <x-slot:baslik>
        {{ ayar('siteBaslik') }} | Favorilerim
    </x-slot>
    <x-slot:aciklama>
        {{ ayar('metaIcerik') }}
    </x-slot>
    <x-slot:anahtar>
        {{ ayar('metaAnahtar') }}
    </x-slot>


    <section class="section-b-space pt-0">
        <div class="heading-banner">
            <div class="custom-container container">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4>Favoriler</h4>
                    </div>
                    <div class="col-sm-6">
                        <ul class="breadcrumb float-end">
                            <li class="breadcrumb-item"><a href="{{ rota('index') }}"> Anasayfa </a></li>
                            <li class="breadcrumb-item active"><a href="#"> Favoriler</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-b-space pt-0">
        <div class="custom-container container wishlist-box">
            <div class="product-tab-content ratio1_3">

                @if (!empty($favoriUrunler) && count($favoriUrunler) > 0)
                    <div class="row-cols-xl-4 row-cols-md-3 row-cols-2 grid-section view-option row gy-4 g-xl-4 "
                        id="favoriTablo">
                        @foreach ($favoriUrunler as $urun)
                            @php
                                $urun = $urun->urun;
                                $urunDilVerisi = dilVerisi($urun, 'urunDiller')->first();
                                $urunAnaResim = depolamaUrl($urun->urunResimler->where('tip', 1)->first());
                                $urunNormalResim = depolamaUrl($urun->urunResimler->where('tip', 2)->first());
                            @endphp

                            <div class="col-lg-3 col-md-4 col-6 favori-oge" urun-id="{{ $urun->id }}">
                                <div class="product-box-3">
                                    <div class="img-wrapper">
                                        @if ($urun->stok_adet < 1)
                                            <div class="stok-yok-etiket">
                                                Tükendi
                                            </div>
                                        @endif
                                        <div class="label-block">

                                            <a class="label-2 wishlist-icon favori-sil-btn" href="javascript:void(0);"
                                                tabindex="0">
                                                <i class="iconsax" data-icon="trash" aria-hidden="true"
                                                    data-bs-toggle="tooltip" data-bs-title="Favorilerden Kaldır">
                                                </i>
                                            </a>

                                        </div>
                                        <div class="product-image">
                                            <a class="pro-first"
                                                href="{{ rota('urun-detay', ['slug' => $urunDilVerisi->slug]) }}">
                                                <img class="bg-img" src="{{ depolamaUrl($urunAnaResim) }}"
                                                    alt="{{ $urunDilVerisi->baslik }} " />
                                            </a>
                                            <a class="pro-sec"
                                                href="{{ rota('urun-detay', ['slug' => $urunDilVerisi->slug]) }}">
                                                <img class="bg-img" src="{{ depolamaUrl($urunNormalResim) }}"
                                                    alt="{{ $urunDilVerisi->baslik }} " />
                                            </a>
                                        </div>
                                        <div class="cart-info-icon">

                                            <a href="{{ rota('urun-detay', ['slug' => $urunDilVerisi->slug]) }}"
                                                tabindex="0">
                                                <i class="iconsax" data-icon="eye" aria-hidden="true"
                                                    data-bs-toggle="tooltip" data-bs-title="Ürünü İncele">
                                                </i>
                                            </a>
                                        </div>

                                    </div>
                                    <div class="product-detail">
                                        <a href="{{ rota('urun-detay', ['slug' => $urunDilVerisi->slug]) }}">
                                            <h6> {{ $urunDilVerisi->baslik }} </h6>
                                        </a>

                                        <p> {{ formatPara(indirimliFiyatHesapla($urun)) }}
                                            @if (tekliIndirimOran($urun) > 0)
                                                <del>{{ formatPara($urun->birim_fiyat) }}</del>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="col-12">
                        <h2 class="w-100 heading2 text-center" style="margin: 5rem 0">
                            Favorilere Eklenen Ürün Bulunmamakta ...
                        </h2>
                    </div>

                @endif


            </div>
        </div>
    </section>
</x-layout.web>
