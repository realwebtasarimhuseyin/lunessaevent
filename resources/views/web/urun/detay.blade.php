<x-layout.web>
    @php
        $urunDilVerisi = dilVerisi($urun, 'urunDiller')->first();
        $urunKategoriDilVerisi = dilVerisi($urun->urunKategori, 'urunKategoriDiller')->first();
        $urunAnaResim = $urun->urunResimler->where('tip', 1)->first();
        $urunNormalResimler = $urun->urunResimler->where('tip', 2);
        // Alt kategori bilgisini çekiyoruz
        $urunAltKategori = $urun->urunAltKategori;
        $urunAltKategoriDilVerisi = $urunAltKategori
            ? dilVerisi($urunAltKategori, 'urunAltKategoriDiller')->where('dil', $aktifDil)->first()
            : null;
    @endphp



    <x-slot:baslik>
        {{ $urunDilVerisi->baslik }}
    </x-slot>
    <x-slot:aciklama>
        {{ $urunDilVerisi->meta_icerik }}
    </x-slot>
    <x-slot:anahtar>
        {{ $urunDilVerisi->meta_anahtar }}
    </x-slot>


    <!-- Hero/Breadcrumb Section -->
    <section class="hero-banner bg-success position-relative text-white"
        style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ Storage::url(ayar('reklamBanner2Resim-tr')) }}') no-repeat center center; background-size: cover;">
        <div class="container py-5">
            <div class="row py-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-3">{{ $urunDilVerisi->baslik }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="{{ rota('index') }}" class="text-white">Anasayfa</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ rota('urunler') }}" class="text-white">Paketler</a>
                            </li>
                            <li class="breadcrumb-item active text-white" aria-current="page">
                                {{ $urunDilVerisi->baslik }}</li>
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

    <section class="product-detail-section py-5">
        <div class="container">
            <!-- Main Product Section -->
            <div class="row justify-content-center mb-5">
                <div class="col-lg-10">
                    <div class="card product-main-card border-0 shadow-sm">
                        <div class="row g-0">
                            <div class="d-flex flex-wrap gap-3 mt-4 justify-content-center">
                                <a href="#" onclick="sendToWhatsApp()"
                                    class="button-fill-primary banner3-btn wp-button-color">
                                    <i class="bi bi-whatsapp me-2"></i> Teklif Alın
                                </a>
                                <a href="tel:{{ str_replace([' ', '+'], '', ayar('telefon')) }}"
                                    class="button-fill-primary banner3-btn">
                                    <i class="bi bi-telephone me-2"></i> Hemen Ara
                                </a>
                            </div>
                            <!-- Product Image -->
                            <div class="row product-detail-row">
                                <!-- Ürün Görseli -->
                                <div class="col-md-12 mb-4" data-aos="fade-up" data-aos-duration="1500"
                                    data-aos-once="true">
                                    <div class="product-image-container p-4 text-center">
                                        <img src="{{ depolamaUrl($urunAnaResim) }}"
                                            class="img-fluid rounded-3 main-product-image"
                                            alt="{{ $urunDilVerisi->baslik }}">
                                    </div>
                                </div>

                                <!-- Ürün Bilgileri -->
                                <div class="col-md-12" data-aos="fade-up" data-aos-duration="1500" data-aos-once="true">
                                    <div class="product-meta-container p-4 rounded-3 shadow-sm bg-white">
                                        <!-- Kategoriler -->
                                        <div class="category-tags mb-3">
                                            @if ($urunKategoriDilVerisi)
                                                <span class="badge badge-color-orange me-2 mb-2">
                                                    <i class="bi bi-tag-fill me-1"></i>
                                                    {{ $urunKategoriDilVerisi->isim }}
                                                </span>
                                            @endif

                                            @if ($urunAltKategoriDilVerisi)
                                                <span class="badge badge-color-orange mb-2">
                                                    <i class="bi bi-tags-fill me-1"></i>
                                                    {{ $urunAltKategoriDilVerisi->isim }}
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Fiyat Bilgisi -->
                                        <div class="price-section p-3 bg-light-success rounded-3">
                                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                <div class="price-content mb-2 mb-md-0">
                                                    <span class="current-price fw-bold text-dark fs-3 me-2">
                                                        {{ formatPara(indirimliFiyatHesapla($urun)) }} $
                                                    </span>

                                                    @if (tekliIndirimOran($urun) > 0)
                                                        <del class="old-price text-muted fs-6">
                                                            {{ formatPara($urun->birim_fiyat) }} $
                                                        </del>
                                                    @endif
                                                </div>

                                                <div class="per-person-badge">
                                                    <span class="badge bg-white text-dark border border-secondary">
                                                        <i class="bi bi-people-fill me-1 text-primary"></i> Kişi Başı
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Content -->
                            <div class="col-md-12" data-aos="fade-up" data-aos-duration="1500" data-aos-once="true">
                                <div class="card-body p-4 p-lg-5">
                                    <h2 class="product-title mb-3">
                                        {{ $urunDilVerisi->baslik }}

                                    </h2>
                                    <div class="product-description mb-4">
                                        {!! $urunDilVerisi->icerik !!}
                                    </div>



<style>
    .gift-card-box {
    border-radius: 1.5rem;
    background: #fffefa;
    border: 1.5px solid #ffe8cc;
}
.gift-item {
    background: #fff;
    border: 1px solid #f3e9de;
    transition: box-shadow 0.2s, transform 0.2s;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(235,122,33,0.04);
}
.gift-item:hover {
    box-shadow: 0 8px 28px 0 rgba(235,122,33,0.14);
    transform: translateY(-3px) scale(1.05);
    background: #fff4e7;
}
.gift-icon {
    font-size: 2.2rem;
    color: #eb7a21;
}
.gift-label {
    font-size: 1.08rem;
    font-weight: 500;
    color: #4a3524;
    margin-top: 3px;
}

</style>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow gift-card-box mb-4">
                <div class="card-body">
                    <h3 class="text-center fw-bold mb-4" style="color: #eb7a21;">
                        <i class="bi bi-gift-fill me-2"></i> Hediyelerimiz
                    </h3>
                    <div class="row row-cols-2 row-cols-md-4 g-3 text-center">
                        <div class="col">
                            <div class="gift-item h-100 p-3 rounded-3">
                                <div class="gift-icon mb-2"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-suitcase-fill" viewBox="0 0 16 16">
  <path d="M6 .5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V3h1.5A1.5 1.5 0 0 1 13 4.5v9a1.5 1.5 0 0 1-1.004 1.416A1 1 0 1 1 10 15H6a1 1 0 1 1-1.997-.084A1.5 1.5 0 0 1 3 13.5v-9A1.5 1.5 0 0 1 4.5 3H6zM9 1H7v2h2zM6 5.5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0zm2.5 0a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0zm2.5 0a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0z"/>
</svg></div>
                                <div class="gift-label">Valiz</div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="gift-item h-100 p-3 rounded-3">
                                <div class="gift-icon mb-2"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-backpack-fill" viewBox="0 0 16 16">
  <path d="M5 13v-3h4v.5a.5.5 0 0 0 1 0V10h1v3z"/>
  <path d="M6 2v.341C3.67 3.165 2 5.388 2 8v5.5A2.5 2.5 0 0 0 4.5 16h7a2.5 2.5 0 0 0 2.5-2.5V8a6 6 0 0 0-4-5.659V2a2 2 0 1 0-4 0m2-1a1 1 0 0 1 1 1v.083a6 6 0 0 0-2 0V2a1 1 0 0 1 1-1m0 3a4 4 0 0 1 3.96 3.43.5.5 0 1 1-.99.14 3 3 0 0 0-5.94 0 .5.5 0 1 1-.99-.14A4 4 0 0 1 8 4M4.5 9h7a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5"/>
</svg></div>
                                <div class="gift-label">Sırt Çantası</div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="gift-item h-100 p-3 rounded-3">
                                <div class="gift-icon mb-2"><i class="bi bi-headphones"></i></div>
                                <div class="gift-label">Kulaklık</div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="gift-item h-100 p-3 rounded-3">
                                <div class="gift-icon mb-2"><i class="bi bi-person-fill"></i></div>
                                <div class="gift-label">Erkeklere İhram</div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="gift-item h-100 p-3 rounded-3">
                                <div class="gift-icon mb-2"><i class="bi bi-person-fill"></i></div>
                                <div class="gift-label">Hanımlara Eşarp</div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="gift-item h-100 p-3 rounded-3">
                                <div class="gift-icon mb-2"><i class="bi bi-book"></i></div>
                                <div class="gift-label">Umre Kitapçığı</div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="gift-item h-100 p-3 rounded-3">
                                <div class="gift-icon mb-2"><i class="bi bi-bezier"></i></div>
                                <div class="gift-label">Şakv Tespihi</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    



                                @if (!empty($urunNormalResimler) && count($urunNormalResimler) > 0)
    <!-- =============== Gallary area start =============== -->
    <div class="gallary-area gallary-style-one">
        <div class="container">
            <div class="row">
                @foreach ($urunNormalResimler as $resim)
                    @php
                        $isPdf = pathinfo(Storage::url($resim->resim_url), PATHINFO_EXTENSION) === 'pdf';
                    @endphp
                    
                    <div class="col-lg-4 col-md-4">
                        <div class="gallary-item">
                            @if($isPdf)
                                <!-- PDF için indirme butonu -->
                                <div class="pdf-container" style="background: #f5f5f5; padding: 20px; text-align: center;">
                                    <i class="bi bi-file-earmark-pdf" style="font-size: 48px; color: #d32f2f;"></i>
                                    <p style="margin-top: 10px;">PDF Katalog</p>
                                    <a href="{{ Storage::url($resim->resim_url) }}" 
                                       download 
                                       class="btn btn-primary mt-2"
                                       style="background-color: #d32f2f; border-color: #d32f2f;">
                                        Kataloğu İndir
                                    </a>
                                </div>
                            @else
                                <!-- Resim için normal gösterim -->
                                <img src="{{ Storage::url($resim->resim_url) }}" />
                                <a class="gallary-item-overlay" data-fancybox="gallery"
                                    href="{{ Storage::url($resim->resim_url) }}">
                                    <i class="bi bi-eye"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- =============== Gallary area end =============== -->
@endif


                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <!-- Related Products -->
            <div class="related-products py-5">
                <div class="text-center mb-5" data-aos="fade-up" data-aos-duration="1500" data-aos-once="true">
                    <h2 class="section-title position-relative d-inline-block pb-3">
                        Diğer Paketlerimiz
                        <span class="position-absolute bottom-0 start-50 translate-middle-x badge-color-orange"
                            style="height: 3px; width: 80px;"></span>
                    </h2>
                    <p class="text-muted">Benzer Paketlerimiz İnceleyebilirsiniz</p>
                </div>

                <div class="row g-4 justify-content-center" data-aos="fade-up" data-aos-duration="1500"
                    data-aos-once="true">
                    @foreach ($digerurunler as $urun)
                        @php
                            $urunDilVerisi = dilVerisi($urun, 'urunDiller')->first();
                            $urunAnaResim = $urun->urunResimler->where('tip', 1)->first();
                        @endphp

                        <div class="col-md-6 col-lg-4 col-xl-4">
                            <div class="card product-card h-100 border-0 shadow-sm hover-effect">
                                <div class="product-image-wrapper">
                                    <a href="{{ rota('urun-detay', ['slug' => $urunDilVerisi->slug]) }}">
                                        <img src="{{ depolamaUrl($urunAnaResim) }}"
                                            class="card-img-top product-image" alt="{{ $urunDilVerisi->baslik }}">
                                    </a>
                                </div>

                                <div class="card-body">
                                    <a href="{{ rota('urun-detay', ['slug' => $urunDilVerisi->slug]) }}"
                                        class="text-decoration-none">
                                        <h5 class="card-title product-title">{{ $urunDilVerisi->baslik }}</h5>
                                    </a>

                                    <div class="d-grid mt-3">
                                        <a href="{{ rota('urun-detay', ['slug' => $urunDilVerisi->slug]) }}"
                                            class="btn btn-outline-primary">
                                            Detayları Gör <i class="bi bi-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Main Product Styles */
        .product-detail-section {
            background-color: #f8f9fa;
        }

        .product-main-card {
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .product-image-container {
            background-color: #fff;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-product-image {
            max-height: 500px;
            width: auto;
            object-fit: contain;
        }

        .product-title {
            color: #212529;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .product-description {
            line-height: 1.8;
            color: #495057;
            text-align: center;
        }

        .product-description img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 1rem 0;
        }

        /* Related Products */
        .section-title {
            font-weight: 700;
        }

        .product-card {
            transition: all 0.3s ease;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .hover-effect:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .product-image-wrapper {
            height: 200px;
            background-color: #f5f5f5;
            overflow: hidden;
        }

        .product-image {
            object-fit: cover;
            height: 100%;
            width: 100%;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .product-title {
            color: #212529;
            transition: color 0.2s;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 3rem;
            text-align: center;
        }

        .product-title:hover {
            color: #eb7a21;
        }

        /* Responsive Adjustments */
        @media (max-width: 767.98px) {
            .product-main-card .row>div {
                width: 100%;
            }

            .main-product-image {
                max-height: 300px;
            }

            .product-image-wrapper {
                height: 150px;
            }
        }

        .wp-button-color {
            background-color: #4FCE5D !important;
            border-color: #4FCE5D !important;
        }

        .wp-button-color:hover {
            background-color: #FFFFFF !important;
            border-color: #4FCE5D !important;
            color: #4FCE5D;
        }

        .badge-color-orange {
            background-color: #eb7a21 !important;
        }

        /* Product Detail Row */
        .product-detail-row {
            margin-bottom: 2rem;
        }

        /* Image Container */
        .product-image-container {
            background: #fff;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .main-product-image {
            max-height: 500px;
            width: auto;
            object-fit: contain;
        }

        /* Meta Container */
        .product-meta-container {
            border: 1px solid #eee;
        }

        /* Category Tags */
        .category-tags .badge {
            padding: 0.5em 0.8em;
            font-size: 0.85rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
        }

        /* Price Section */
        .price-section {
            background-color: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .current-price {
            color: #28a745;
        }

        .old-price {
            position: relative;
            top: -2px;
        }

        .per-person-badge .badge {
            padding: 0.5em 0.8em;
            font-weight: 500;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .main-product-image {
                max-height: 350px;
            }

            .price-content {
                width: 100%;
                margin-bottom: 1rem !important;
            }

            .per-person-badge {
                width: 100%;
                text-align: center;
            }
        }
    </style>

    <script>
        function sendToWhatsApp() {
            const phoneNumber =
                {{ str_replace([' ', '+'], '', ayar('telefon')) }}; // WhatsApp numaranız (ülke kodu ile, + olmadan)
            const currentPageUrl = window.location
                .href; // Encode etmiyoruz (çünkü aşağıda defaultMessage zaten encode edilecek)
            const defaultMessage = "Merhaba, bu paket hakkında teklif ve bilgi almak istiyorum: " + currentPageUrl;
            const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(defaultMessage)}`;
            window.open(whatsappUrl, '_blank');
        }
    </script>

</x-layout.web>
