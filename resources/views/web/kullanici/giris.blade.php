<x-layout.web>

    <x-slot:baslik>
        {{ ayar('siteBaslik') }} | {{ __('global.giris') }}
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
                        <h4>Giriş</h4>
                    </div>
                    <div class="col-sm-6">
                        <ul class="breadcrumb float-end">
                            <li class="breadcrumb-item"><a href="{{rota('index')}}"> Anasayfa </a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Giriş</a></li>
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
                    <div class="login-img"><img class="img-fluid" src="{{asset('web/icons/login.svg')}}" alt=""></div>
                </div>
                <div class="col-xxl-4 col-lg-6 mx-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h4>
                                Giriş Yap
                            </h4>
                        </div>
                        <div class="login-box">
                            <form class="row g-3" id="girisForm">
                                <div class="col-12">
                                    <div class="form-floating lvvl">
                                        <input class="form-control input" id="girisEposta" type="text" name="girisEposta"
                                               placeholder="E-Posta">
                                        <label for="girisEposta">E-Posta</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating lvvl">
                                        <input class="form-control input" id="girisSifre" name="girisSifre" type="password"
                                               placeholder="Şifre">
                                        <label for="girisSifre">Şifre</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="forgot-box">
                                        <div>
                                            <input class="custom-checkbox me-2" id="girisBeniHatirla" type="checkbox"
                                                   name="text">
                                            <label for="girisBeniHatirla">Beni Hatırla !</label>
                                        </div>
                                        <a href="{{rota('sifre-sifirla')}}">Şifremi Unuttum?</a>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn login btn_black sm" type="button" id="giris-btn">Giriş
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="other-log-in"></div>
                        <div class="sign-up-box">
                            <p>Hesabın Yok mu ? </p><a href="{{rota('kayit')}}">Kayıt Ol</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @vite('resources/js/pages/web/kullanici/giris.js')

</x-layout.web>
