<x-layout.web>
    <x-slot:baslik>
        {{ ayar('siteBaslik', $aktifDil) }} | Paketlerimiz
    </x-slot>
    <x-slot:aciklama>
        {{ ayar('metaIcerik', $aktifDil) }}
    </x-slot>
    <x-slot:anahtar>
        {{ ayar('metaAnahtar', $aktifDil) }}
    </x-slot>


    <!-- Hero/Breadcrumb Section -->
    <section class="hero-banner bg-success position-relative text-white"
        style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ Storage::url(ayar('reklamBanner2Resim-tr')) }}') no-repeat center center; background-size: cover;">
        <div class="container py-5">
            <div class="row py-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-3">Paketlerimiz</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="{{ rota('index') }}" class="text-white">Anasayfa</a>
                            </li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Paketlerimiz</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="custom-shape-divider-bottom-1621361714">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                preserveAspectRatio="none">
                <path
                    d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                    opacity=".25" class="shape-fill"></path>
                <path
                    d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z"
                    opacity=".5" class="shape-fill"></path>
                <path
                    d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"
                    class="shape-fill"></path>
            </svg>
        </div>
    </section>
    <div class="package-area package-style-one pt-110">
        <div class="container">
            <div class="row g-4">
                @foreach ($urunler as $urun)
                    @php
                        $urunDilVerisi = dilVerisi($urun, 'urunDiller')->first();
                        $urunAnaResim = $urun->urunResimler->where('tip', 1)->first();
                        $urunNormalResim = $urun->urunResimler->where('tip', 2)->first();
                        $urunKategori = $urun->urunKategori->urunKategoriDiller->where('dil', $aktifDil)->first();
                        // Alt kategori bilgisini çekiyoruz
                        $urunAltKategori = $urun->urunAltKategori;
                        $urunAltKategoriDilVerisi = $urunAltKategori
                            ? dilVerisi($urunAltKategori, 'urunAltKategoriDiller')->where('dil', $aktifDil)->first()
                            : null;
                    @endphp
                    <div class="col-lg-4 col-md-6">
                        <div class="package-card-alpha">
                            <div class="package-thumb">
                                <a href="{{ rota('urun-detay', ['slug' => $urunDilVerisi->slug]) }}">
                                    <img src="{{ depolamaUrl($urunAnaResim) }}" alt="" /></a>
                                <p class="card-lavel">
                                    <i class="bi bi-clock"></i> <span>
                                        @if ($urunAltKategoriDilVerisi)
                                            <span> {{ $urunAltKategoriDilVerisi->isim }}</span>
                                            / {{ $urunKategori->isim }}
                                        @endif
                                    </span>
                                </p>
                            </div>
                            <div class="package-card-body">
                                <h3 class="p-card-title">
                                    <a href="{{ rota('urun-detay', ['slug' => $urunDilVerisi->slug]) }}">
                                        {{ $urunDilVerisi->baslik }}
                                    </a>
                                </h3>
                                <div class="p-card-bottom">
                                    <div class="book-btn">
                                        <a href="{{ rota('urun-detay', ['slug' => $urunDilVerisi->slug]) }}">İncele <i
                                                class="bx bxs-right-arrow-alt"></i></a>
                                    </div>

                                    <div class="p-card-info">
                                        <span></span>
                                        <h6>
                                            {{ formatPara(indirimliFiyatHesapla($urun)) }} $
                                            <br>
                                            @if (tekliIndirimOran($urun) > 0)
                                                <del class="text-danger">{{ formatPara($urun->birim_fiyat) }}
                                                    $</del>
                                            @endif
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


</x-layout.web>
