<x-layout.web>
    <x-slot:baslik>
        {{ ayar('siteBaslik', $aktifDil) }}
    </x-slot>
    <x-slot:aciklama>
        {{ ayar('metaIcerik', $aktifDil) }}
    </x-slot>
    <x-slot:anahtar>
        {{ ayar('metaAnahtar', $aktifDil) }}
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
                                <h1 class="rs-breadcrumb-title">Sertifikalarımız</h1>
                            </div>
                            <div class="rs-breadcrumb-menu">
                                <nav>
                                    <ul>
                                        <li><span><a href="{{ rota('index') }}">Anasayfa</a></span></li>
                                        <li><span>Sertifikalarımız</span></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb area end -->


        <!-- team area start -->
        <section class="rs-team-area section-space rs-team-one">
            <div class="container">
                <div class="row g-5">

                    @foreach ($kataloglar as $index => $katalog)
                        @php
                            $katalogDilVerisi = $katalog->katalogDiller->where('dil', $aktifDil)->first();
                        @endphp
                        <div class="col-xl-4 col-lg-4 col-md-6">
                            <div class="rs-team-item">
                                <div class="rs-team-thumb has-clip">
                                    <a href="{{ Storage::url($katalog->dosya_url) }}" target="blank"><img
                                            src="{{ Storage::url($katalog->resim_url) }}" alt="image"></a>
                                </div>
                                <div class="rs-team-content-wrapper">
                                    <div class="rs-team-content-box">
                                        <h5 class="rs-team-title"><a href="{{ Storage::url($katalog->dosya_url) }}"
                                                target="blank">
                                                {{ $katalogDilVerisi->baslik }}
                                            </a></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </section>
        <!-- team area end -->

                                                                                    


    </main>
    <!-- Body main wrapper end -->

</x-layout.web>
