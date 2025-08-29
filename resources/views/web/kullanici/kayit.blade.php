<x-layout.web>

    <x-slot:baslik>
        {{ ayar('siteBaslik') }} | Kayıt Ol
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
                        <h4>Kayıt</h4>
                    </div>
                    <div class="col-sm-6">
                        <ul class="breadcrumb float-end">
                            <li class="breadcrumb-item"><a href="{{rota('index')}}"> Anasayfa </a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Kayıt</a></li>
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
                                Kayıt Ol
                            </h4>
                        </div>
                        <div class="login-box">
                            <form class="row g-3" id="kayitForm">
                                <div class="col-12">
                                    <div class="form-floating lvvl">
                                        <input class="form-control input" id="kayitIsimSoyisim" type="text"
                                               name="kayitIsimSoyisim"
                                               placeholder="İsim Soyisim">
                                        <label for="kayitIsimSoyisim">İsim Soyisim</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating lvvl">
                                        <input class="form-control input" id="kayitEposta" type="text"
                                               name="kayitEposta"
                                               placeholder="E-Posta">
                                        <label for="kayitEposta">E-Posta</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating lvvl">
                                        <input class="form-control input" id="kayitTelefon" name="kayitTelefon"
                                               type="text"
                                               placeholder="Telefon">
                                        <label for="kayitTelefon">Telefon</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating lvvl">
                                        <input class="form-control input" id="kayitSifre" name="kayitSifre"
                                               type="password"
                                               placeholder="Şifre">
                                        <label for="kayitSifre">Şifre</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating lvvl">
                                        <input class="form-control input" id="kayitSifreTekrar" name="kayitSifreTekrar"
                                               type="password"
                                               placeholder="Şifre Tekrar">
                                        <label for="kayitSifreTekrar">Şifre Tekrar</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating lvvl">
                                        <p class="text-secondary-2">
                                            Kişisel verileriniz, bu web sitesindeki kullanıcı deneyiminizi geliştirmek,
                                            hesabınıza erişimi sağlamak ve
                                            <a href="{{ rota('gizlilik-politikasi') }}" class="underline">
                                                gizlilik politikamızda
                                            </a>
                                            belirtilen diğer amaçlarla işlenmektedir.
                                        </p>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <button class="btn login btn_black sm" type="button" id="kayit-btn">
                                        Kayıt Ol
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="other-log-in"></div>
                        <div class="sign-up-box">
                            <p>Zaten bir hesabın var mı ? </p><a href="{{rota('giris')}}">Giriş Yap</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @vite('resources/js/pages/web/kullanici/kayit.js')

</x-layout.web>
