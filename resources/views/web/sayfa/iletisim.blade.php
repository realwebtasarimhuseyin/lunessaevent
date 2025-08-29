<x-layout.web>
    <x-slot:baslik>
        {{ ayar('siteBaslik') }} | {{ $sayfaBaslik }}
    </x-slot>
    <x-slot:aciklama>
        {{ ayar('metaIcerik') }}
    </x-slot>
    <x-slot:anahtar>
        {{ ayar('metaAnahtar') }}
    </x-slot>

    <!-- Hero/Breadcrumb Section -->
    <section class="hero-banner bg-success position-relative text-white"
        style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ Storage::url(ayar('reklamBanner2Resim-tr')) }}') no-repeat center center; background-size: cover;">
        <div class="container py-5">
            <div class="row py-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-3">İletişim</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="{{ rota('index') }}" class="text-white">Anasayfa</a>
                            </li>
                            <li class="breadcrumb-item active text-white" aria-current="page">İletişim</li>
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
    <!-- =========  Contact Section Start =========== -->
    <section class="contact-section py-5 my-5 bg-light">
        <div class="container">
            <div class="row g-4 align-items-stretch">
                <!-- Contact Form Column -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 p-md-5">
                            <div class="section-header mb-4">
                                <span class="badge bg-success bg-opacity-10 text-white mb-3 badge-success-size">
                                    <i class="fas fa-paper-plane me-2"></i> Bize Ulaşın
                                </span>
                                <h2 class="fw-bold mb-3">İletişime Geç</h2>
                                <p class="text-muted">Sorularınız veya görüşleriniz için formu doldurabilirsiniz.</p>
                            </div>

                            <form id="iletisimForm">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="iletisimIsimSoyisim"
                                                name="iletisimIsimSoyisim" placeholder="Ad Soyad">
                                            <label for="iletisimIsimSoyisim">Ad Soyad</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="iletisimEposta"
                                                name="iletisimEposta" placeholder="E-Posta">
                                            <label for="iletisimEposta">E-Posta</label>

                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="tel" class="form-control" id="iletisimTelefon"
                                                name="iletisimTelefon" placeholder="Telefon">
                                            <label for="iletisimTelefon">Telefon</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="iletisimMesaj" name="iletisimMesaj" placeholder="Mesajınız" style="height: 150px"></textarea>
                                            <label for="iletisimMesaj">Mesajınız</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success btn-lg w-100 py-3"
                                            id="iletisim-btn">
                                            <i class="fas fa-paper-plane me-2"></i> Gönder
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <hr class="my-4">

                            <div class="contact-info">
                                <h5 class="fw-bold mb-3"><i class="fas fa-info-circle text-success me-2"></i> İletişim
                                    Bilgileri:</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-3">
                                        <a href="tel:{{ str_replace([' ', '+'], '', ayar('telefon')) }}"
                                            class="text-decoration-none">
                                            <i class="fas fa-phone text-success me-2"></i>
                                            <span>{{ ayar('telefon') }}</span>
                                        </a>
                                        <br>
                                       <a href="tel:+902324899272" class="text-decoration-none">
                                            <i class="fas fa-phone text-success me-2"></i>
                                            <span>(232) 489 92 72</span>
                                        </a>
                                    </li>
                                    
                                   
                                    <li class="mb-3">
                                        <i class="fas fa-map-marker-alt text-success me-2"></i>
                                        <span>{{ ayar('adres') }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <a href="mailto:{{ ayar('eposta') }}" class="text-decoration-none">
                                            <i class="fas fa-envelope text-success me-2"></i>
                                            <span>{{ ayar('eposta') }}</span>
                                        </a>
                                    </li>
                                </ul>

                            <style>
                             .my-socials-clean {
                                text-align: center;
                                margin: 36px 0 0 0;
                                padding: 22px 0 18px 0;
                                background: #fff;
                                border-radius: 22px;
                                box-shadow: 0 4px 24px 0 rgba(0,0,0,0.06);
                                max-width: 420px;
                                margin-left: auto;
                                margin-right: auto;
                            }
                            .my-socials-title {
                                font-size: 1.13rem;
                                font-weight: 600;
                                color: #00896b;
                                margin-bottom: 20px;
                                letter-spacing: .03em;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                gap: 7px;
                            }
                            .my-socials-list {
                                display: flex;
                                justify-content: center;
                                gap: 22px;
                            }
                            .my-socials-icon {
                                width: 54px;
                                height: 54px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                border-radius: 50%;
                                font-size: 2.2rem;
                                background: #f6f8fa;
                                color: #414141;
                                box-shadow: 0 2px 14px rgba(0,0,0,0.08);
                                transition: all 0.32s cubic-bezier(.41,2.1,.66,1.1);
                                border: 2.5px solid #f6f8fa;
                                cursor: pointer;
                                position: relative;
                            }
                            .my-socials-icon.facebook:hover   { background: #1877f3; color: #fff; border-color: #1877f3; }
                            .my-socials-icon.instagram:hover  { background: #e1306c; color: #fff; border-color: #e1306c; }
                            .my-socials-icon.youtube:hover    { background: #ff0000; color: #fff; border-color: #ff0000; }
                            .my-socials-icon.whatsapp:hover   { background: #25d366; color: #fff; border-color: #25d366; }
                            
                            .my-socials-icon:hover {
                                transform: translateY(-5px) scale(1.12) rotate(-5deg);
                                box-shadow: 0 8px 26px rgba(0,0,0,0.14), 0 3px 9px rgba(80,80,80,0.10);
                            }
                            
                            </style>

                            <!-- SOSYAL MEDYA BURAYA -->
                             <div class="my-socials-clean">
                                <div class="my-socials-list">
                                    <a href="{{ ayar('facebook') }}" target="_blank" class="my-socials-icon facebook" title="Facebook">
                                        <i class="bx bxl-facebook"></i>
                                    </a>
                                    <a href="{{ ayar('instagram') }}" target="_blank" class="my-socials-icon instagram" title="Instagram">
                                        <i class="bx bxl-instagram-alt"></i>
                                    </a>
                                    <a href="{{ ayar('youtube') }}" target="_blank" class="my-socials-icon youtube" title="YouTube">
                                        <i class="bx bxl-youtube"></i>
                                    </a>
                                    <a href="https://api.whatsapp.com/send?phone={{ str_replace([' ', '+'], '', ayar('telefon')) }}" target="_blank" class="my-socials-icon whatsapp" title="WhatsApp">
                                        <i class="bx bxl-whatsapp-square"></i>
                                    </a>
                                </div>
                            </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Contact Form Column -->

                <!-- Map Column -->
                <div class="col-lg-6">
                    <div class="card border-0 h-100 overflow-hidden">
                        <div class="ratio ratio-1x1 h-100">
                            <iframe src="{{ ayar('iframeLink') }}" class="w-100 h-100" style="border:0;"
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
                <!-- End Map Column -->
            </div>
        </div>
    </section>
    <!-- =========  Contact Section End =========== -->


    <!-- Form Validation Script -->
    <script>
        // Form validation
        (function() {
            'use strict'

            var form = document.getElementById('iletisimForm');

            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })()
    </script>



    @vite('resources/js/pages/web/iletisim.js')

</x-layout.web>
