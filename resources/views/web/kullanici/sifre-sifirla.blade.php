<x-layout.web>
    <x-slot:baslik>
        {{ ayar('siteBaslik') }}
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
                        <h4>Şifre Sıfırla</h4>
                    </div>
                    <div class="col-sm-6">
                        <ul class="breadcrumb float-end">
                            <li class="breadcrumb-item"><a href="{{ rota('index') }}"> Anasayfa </a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Şifre Sıfırla</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-b-space pt-0 login-bg-img">
        <div class="custom-container container login-page">
            <div class="row align-items-center">
                <div class="col-xxl-7 col-6 d-none d-lg-block">
                    <div class="login-img"><img class="img-fluid" src="{{ asset('web/icons/login.svg') }}"
                            alt=""></div>
                </div>
                <div class="col-xxl-4 col-lg-6 mx-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h4>
                               Yeni Şirenizi Giriniz
                            </h4>
                        </div>
                        <div class="login-box">
                            <form class="row g-3" id="sifreSifirlaForm" action="{{ rota('sifre-sifirla-onay') }}"
                            yonlendirme="{{ rota('giris') }}" >
                                <div class="col-12">
                                    <div class="form-floating lvvl">
                                        <input class="form-control input disabled" id="eposta" type="text" disabled
                                            name="eposta" placeholder="E-Posta" value="{{ $eposta }}">
                                        <label for="girisEposta">E-Posta</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating lvvl">
                                        <input class="form-control input" id="sifre" type="text"
                                            name="sifre" placeholder="Şişfre">
                                        <label for="sifre">Şifre</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating lvvl">
                                        <input class="form-control input" id="sifreTekrar" type="text"
                                            name="sifreTekrar" placeholder="Şifre Tekrar">
                                        <label for="sifreTekrar">Şifre Tekrar</label>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <button class="btn login btn_black sm" type="button"id="sifre-sifirla-btn">
                                        Şifreyi Sıfırla
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="other-log-in"></div>
                        <div class="sign-up-box">
                            <a href="{{ rota('giris') }}">Giriş Yap</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>





    <script>
        const eposta = "{{ $eposta }}";
        const token = "{{ $token }}";
    </script>

    @vite('resources/js/pages/web/kullanici/sifre-sifirla.js')
    <!-- End of Login Wrapper -->
</x-layout.web>
