<x-layout.web>
    @php
        $projeDilVerisi = dilVerisi($proje, 'projeDiller')->first();
        $projeAnaResim = $proje->projeResimler->where('tip', 1)->first();
        $projeNormalResimler = $proje->projeResimler->where('tip', 2);
    @endphp

    <x-slot:baslik>
        {{ ayar('siteBaslik') . ' | ' . $projeDilVerisi->baslik }}
    </x-slot>
    <x-slot:aciklama>
        {{ $projeDilVerisi->meta_icerik }}
    </x-slot>
    <x-slot:anahtar>
        {{ $projeDilVerisi->meta_anahtar }}
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
                                <h1 class="rs-breadcrumb-title">{{ $projeDilVerisi->baslik }}</h1>
                            </div>
                            <div class="rs-breadcrumb-menu">
                                <nav>
                                    <ul>
                                        <li><span><a href="{{ rota('index') }}">Anasayfa</a></span></li>
                                        <li><span><a href="{{ rota('projelerimiz') }}">Projelerimiz</a></span></li>
                                        <li><span>{{ $projeDilVerisi->baslik }}</span></li>
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
                                <img src="{{ Storage::url($projeAnaResim->resim_url) }}" alt="image">
                            </div>
                            <div class="rs-postbox-content">
                                <h3 class="rs-postbox-details-title mx-auto text-center">
                                    {{ $projeDilVerisi->baslik }}
                                </h3>
                            </div>
                            <div class="rs-postbox-details-content">
                                {!! $projeDilVerisi->icerik !!}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- rs-postbox area end -->

        <section class="rs-elements-blog-are section-space rs-blog-four">
            <div class="container">

                <div class="row g-5">
                    @foreach ($projeNormalResimler as $projeNormalResim)
                        <div class="col-xl-4 col-lg-4 col-md-6">
                            <div class="rs-blog-item wow fadeInUp" data-wow-delay=".3s" data-wow-duration="1s"
                                style="visibility: visible; animation-duration: 1s; animation-delay: 0.3s; animation-name: fadeInUp;">
                                <div class="rs-blog-thumb">
                                    <img src="{{ Storage::url($projeNormalResim->resim_url) }}" alt="image">
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

    </main>
    <!-- Body main wrapper end -->



</x-layout.web>
