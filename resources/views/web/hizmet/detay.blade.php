<x-layout.web>
    @php
        $hizmetDilVerisi = dilVerisi($hizmet, 'hizmetDiller')->first();
    @endphp

    <x-slot:baslik>
        {{ ayar('siteBaslik') . ' | ' . $hizmetDilVerisi->baslik }}
    </x-slot>
    <x-slot:aciklama>
        {{ $hizmetDilVerisi->meta_icerik }}
    </x-slot>
    <x-slot:anahtar>
        {{ $hizmetDilVerisi->meta_anahtar }}
    </x-slot>

    <!-- Body main wrapper start -->
    <main>


        <!-- breadcrumb area start -->
        <section class="rs-breadcrumb-area rs-breadcrumb-one p-relative">
            <div class="rs-breadcrumb-bg" data-background="{{ asset('web/images/bg/testimonials-bg-01.png') }}"></div>
            <div class="container">
                <div class="row">
                    <div class="col-xxl-6 col-xl-8 col-lg-8">
                        <div class="rs-breadcrumb-content-wrapper">
                            <div class="rs-breadcrumb-title-wrapper">
                                <h1 class="rs-breadcrumb-title">{{ $hizmetDilVerisi->baslik }}</h1>
                            </div>
                            <div class="rs-breadcrumb-menu">
                                <nav>
                                    <ul>
                                        <li><span><a href="{{ rota('index') }}">Anasayfa</a></span></li>
                                        <li><span><a href="{{ rota('hizmetler') }}">Hizmetler</a></span></li>
                                        <li><span>{{ $hizmetDilVerisi->baslik }}</span></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb area end -->
        <!-- postbox area start -->
        <section class="rs-postbox-area section-space">
            <div class="container">
                <div class="row g-5">
                    <div class="col-xl-12 col-lg-12">
                        <div class="rs-postbox-details-wrapper">
                            <div class="rs-postbox-details-thumb col-xl-8 mx-auto text-center">
                                <img src="{{ depolamaUrl($hizmet) }}" alt="image">
                            </div>
                            <div class="rs-postbox-content">
                                <h3 class="rs-postbox-details-title mx-auto text-center">
                                    {{ $hizmetDilVerisi->baslik }}
                                </h3>
                            </div>
                            <div class="rs-postbox-details-content">
                                {!! $hizmetDilVerisi->icerik !!}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- rs-postbox area end -->

    </main>
    <!-- Body main wrapper end -->



</x-layout.web>
