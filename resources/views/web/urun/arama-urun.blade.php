<x-layout.web>
    <x-slot:baslik>
        {{ ayar('siteBaslik', $aktifDil) }} | Ürünlerimiz
    </x-slot>
    <x-slot:aciklama>
        {{ ayar('metaIcerik', $aktifDil) }}
    </x-slot>
    <x-slot:anahtar>
        {{ ayar('metaAnahtar', $aktifDil) }}
    </x-slot>

    <!-- =========  Main Area Start =========== -->
    <main>
        <!-- =========  Breadcrumb Area Start =========== -->
        <section class="breadcrumb include-bg breadcrumb__overlay"
            style="background-image: url({{ Storage::url(ayar('reklamBanner2Resim-tr')) }});">
            <div class="container">
                <div class="breadcrumb__content p-relative z-index-1" data-aos="fade-right" data-aos-duration="1500"
                    data-aos-once="true">
                    <h3 class="breadcrumb__title">Ürünler</h3>
                    <div class="breadcrumb__list">
                        <span><a href="{{ rota('index') }}">Anasayfa</a></span>
                          <span class="dvdr"><i class="fa-regular fa-angle-right"></i>
                        </span>
                        <span><a href="{{ rota('urunler') }}">Ürünler</a></span>

                    </div>
                </div>
            </div>
            <div class="breadcrumb__bottom-shape">
                <img src="{{ asset('web/images/png/home-1/home-1-hero-shape-bottom.png') }}" alt="" />
            </div>
        </section>
        <!-- =========  Breadcrumb Area End =========== -->



        <!-- =========  Blog Area Start =========== -->
        <div class="cl-blogs cl-blogs--style-2 section-pt">
            <div class="container">
                <div class="row gy-30 gx-30 justify-content-center" data-aos="fade-up" data-aos-duration="1500"
                    data-aos-once="true">


                    @foreach ($urunler as $urun)
                        @php
                            $urunDilVerisi = dilVerisi($urun, 'urunDiller')->first();
                            $urunAnaResim = $urun->urunResimler->where('tip', 1)->first();
                            $urunNormalResim = $urun->urunResimler->where('tip', 2)->first();
                        @endphp
                        <div class="col-xs-10 col-sm-6 col-lg-4">
                            <!-- Blog Single  -->
                            <div class="cl-blogs__single">
                                <!-- Blog Image -->
                                <div class="cl-blogs__thumbnail">
                                    <a href="{{ rota('urun-detay', ['slug' => $urunDilVerisi->slug]) }}">
                                        <img src="{{ depolamaUrl($urunAnaResim) }}" alt="">
                                    </a>
                                </div>
                                <!-- End Blog Image -->

                                <!-- Blog Meta -->
                                <div class="cl-blogs__info-meta">

                                    <a href="{{ rota('urun-detay', ['slug' => $urunDilVerisi->slug]) }}">
                                        <h5 class="cl-blogs__title"> {{ $urunDilVerisi->baslik }}</h5>
                                    </a>
                                    <p>
                                        {!! Str::limit(strip_tags($urunDilVerisi->icerik), 80, '...') !!}
                                    </p>
                                    <a href="{{ rota('urun-detay', ['slug' => $urunDilVerisi->slug]) }}"
                                        class="cl-btn cl-btn--secondary">Devamını Oku</a>
                                </div>
                                <!-- End Blog Meta -->
                            </div>
                            <!-- End Blog Single -->
                        </div>
                    @endforeach



                </div>
            </div>
        </div>
        <!-- =========  Blog Area Start =========== -->


    </main>

</x-layout.web>
