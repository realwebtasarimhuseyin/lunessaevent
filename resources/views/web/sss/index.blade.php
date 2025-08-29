<x-layout.web>
    <x-slot:baslik>
        {{ ayar('siteBaslik', $aktifDil) }} | Sıkça Sorulan Sorular
    </x-slot>
    <x-slot:aciklama>
        {{ ayar('metaIcerik', $aktifDil) }}
    </x-slot>
    <x-slot:anahtar>
        {{ ayar('metaAnahtar', $aktifDil) }}
    </x-slot>


    <main>

        <!-- =========  Breadcrumb Area Start =========== -->
        <section class="breadcrumb include-bg breadcrumb__overlay"
            style="background-image: url({{ Storage::url(ayar('reklamBanner2Resim-tr')) }});">
            <div class="container">
                <div class="breadcrumb__content p-relative z-index-1" data-aos="fade-right" data-aos-duration="1500"
                    data-aos-once="true">
                    <h3 class="breadcrumb__title">Sıkça Sorulan Sorular</h3>
                    <div class="breadcrumb__list">
                        <span><a href="{{ rota('index') }}">Anasayfa</a></span>
                        <span class="dvdr"><i class="fa-regular fa-angle-right"></i>
                        </span>
                        <span>Sıkça Sorulan Sorular</span>
                    </div>
                </div>
            </div>
            <div class="breadcrumb__bottom-shape">
                <img src="{{ asset('web/images/png/home-1/home-1-hero-shape-bottom.png') }}" alt="" />
            </div>
        </section>


        <!-- =========  Postbox Area Start =========== -->
        <section class="postbox__area pt-120 pb-120">
            <div class="container">
                <div class="row gx-50 gy-10">

                    <!-- Faq Accordion -->
                    <div class="col-lg-12 order-1 order-lg-2">
                        <div class="accordion accordion--style-3" id="accordionExample" data-aos="fade-left"
                            data-aos-duration="1500" data-aos-once="true">


                            @foreach ($sssler as $index => $sss)
                                @php
                                    $sssDilVerisi = dilVerisi($sss, 'sssDiller')->first();
                                @endphp
                                <!-- Accordion Item -->
                                <div class="accordion__item">
                                    <h3>
                                        <button class="accordion__item__heading" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $index }}"
                                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                            aria-controls="collapse{{ $index }}">
                                            {{ $sssDilVerisi->baslik }}
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </h3>
                                    <div id="collapse{{ $index }}"
                                        class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                        data-bs-parent="#accordionExample">
                                        <div class="row gy-20 justify-content-between accordion-body-content">
                                            <div class="col-xl-12">
                                                <div class="accordion__body">
                                                    {!! $sssDilVerisi->icerik !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- End Faq Accordion -->
                </div>
            </div>
        </section>
        <!-- =========  Postbox Area End =========== -->

    </main>

</x-layout.web>
