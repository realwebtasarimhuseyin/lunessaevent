<x-layout.web>
    <x-slot:baslik>
        {{ ayar('siteBaslik', $aktifDil) }} | {{ $sayfaBaslik }}
    </x-slot>
    <x-slot:aciklama>
        {{ ayar('metaIcerik', $aktifDil) }}
    </x-slot>
    <x-slot:anahtar>
        {{ ayar('metaAnahtar', $aktifDil) }}
    </x-slot>

    @php
        $sayfaYonetimDilVerisi = dilVerisi($sayfaYonetim, 'sayfaYonetimDiller')->first();
    @endphp

    <main>

        <!-- =========  Breadcrumb Area Start =========== -->
        <section class="breadcrumb include-bg breadcrumb__overlay"
            style="background-image: url({{ Storage::url(ayar('reklamBanner2Resim-tr')) }});">
            <div class="container">
                <div class="breadcrumb__content p-relative z-index-1" data-aos="fade-right" data-aos-duration="1500"
                    data-aos-once="true">
                    <h3 class="breadcrumb__title">{{ $sayfaBaslik }}</h3>
                    <div class="breadcrumb__list">
                        <span><a href="{{ rota('index') }}">Anasayfa</a></span>
                        <span class="dvdr"><i class="fa-regular fa-angle-right"></i>
                        </span>
                        <span>{{ $sayfaBaslik }}</span>
                    </div>
                </div>
            </div>
            <div class="breadcrumb__bottom-shape">
                <img src="{{ asset('web/images/png/home-1/home-1-hero-shape-bottom.png') }}" alt="" />
            </div>
        </section>
        <!-- =========  Breadcrumb Area End =========== -->

        <!-- Privacy Policy Content Start -->
        <section class="privacy-policy pt-120 pb-120">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="privacy-policy__content">
                            <div class="section__title mb-40 text-center">
                                <h2> {{ $sayfaYonetimDilVerisi->baslik ?? '' }}</h2>
                            </div>
                            {!! $sayfaYonetimDilVerisi->icerik ?? '' !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Privacy Policy Content End -->
    </main>

    <style>
        .privacy-policy {
            background-color: #f9f9f9;
        }

        .privacy-policy__content {
            background: #fff;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.05);
        }

        .privacy-item h3 {
            color: #2a5a78;
            font-weight: 700;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }

        .privacy-subitem h4 {
            color: #3a6b8a;
            font-weight: 600;
            margin-top: 25px;
        }

        .list-style-two {
            list-style-type: none;
            padding-left: 0;
        }

        .list-style-two li {
            position: relative;
            padding-left: 25px;
            margin-bottom: 8px;
        }

        .list-style-two li:before {
            content: "\f054";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            position: absolute;
            left: 0;
            color: #4a90e2;
            font-size: 12px;
        }

        .cookie-type-card {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
            border: 1px solid #eee;
            transition: all 0.3s ease;
        }

        .cookie-type-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .cookie-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        @media (max-width: 767px) {
            .privacy-policy__content {
                padding: 30px 20px;
            }
        }
    </style>




    </main>

</x-layout.web>
