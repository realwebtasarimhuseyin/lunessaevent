<x-layout.web>
    <x-slot:baslik>
        {{ ayar('siteBaslik') }} | {{ __('global.hesabim') }}
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
                        <h4>Hesabım</h4>
                    </div>
                    <div class="col-sm-6">
                        <ul class="breadcrumb float-end">
                            <li class="breadcrumb-item"> <a href="{{ rota('index') }}"> Anasayfa </a></li>
                            <li class="breadcrumb-item active"> <a href="javascript:void(0);"> Hesabım </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-b-space pt-0">
        <div class="custom-container container user-dashboard-section">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    <div class="left-dashboard-show">
                        <button class="btn btn_black sm rounded bg-primary">Menüyü Göster</button>
                    </div>
                    <div class="dashboard-left-sidebar sticky">
                        <div class="profile-box">
                            <div class="profile-bg-img"></div>
                            <div class="dashboard-left-sidebar-close"><i class="fa-solid fa-xmark"></i></div>
                            <div class="profile-contain">

                                <div class="profile-name">
                                    <h4> {{ auth()->guard('web')->user()->isim_soyisim }}</h4>
                                    <h6>{{ auth()->guard('web')->user()->eposta }}</h6>
                                    <span data-bs-toggle="modal" data-bs-target="#edit-box" title=""
                                        tabindex="0">Bilgileri Düzenle</span>
                                </div>
                            </div>
                        </div>
                        <ul class="nav flex-column nav-pills dashboard-tab" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            <li>
                                <button class="nav-link active" id="dashboard-tab" data-bs-toggle="pill"
                                    data-bs-target="#dashboard" role="tab" aria-controls="dashboard"
                                    aria-selected="true"><i class="iconsax" data-icon="home-1"></i> Hesap
                                    Bilgileri</button>
                            </li>

                            <li>
                                <button class="nav-link" id="order-tab" data-bs-toggle="pill" data-bs-target="#order"
                                    role="tab" aria-controls="order" aria-selected="false"><i class="iconsax"
                                        data-icon="receipt-square"></i> Siparişler</button>
                            </li>


                        </ul>
                        <div class="logout-button">
                            <a href="{{ rota('cikis') }}" class="btn btn_black sm">
                                <i class="iconsax me-1" data-icon="logout-1"></i>
                                Çıkış
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="dashboard" role="tabpanel">
                            <div class="dashboard-right-box">
                                <div class="my-dashboard-tab">
                                    <div class="dashboard-items"></div>

                                    <div class="sidebar-title">
                                        <div class="loader-line"></div>
                                        <h4>Kontrol Panelim</h4>
                                    </div>

                                    <div class="dashboard-user-name">
                                        <h6>Merhaba, <b>{{ auth()->guard('web')->user()->isim_soyisim }}</b></h6>
                                        <p>
                                            Kontrol paneliniz, işletmenize dair önemli verileri ve analizleri sunar.
                                            Satış istatistikleri, müşteri etkileşimleri ve diğer önemli metrikleri
                                            buradan takip edebilirsiniz.
                                        </p>
                                    </div>

                                    <div class="total-box">
                                        <div class="row gy-4">
                                            <div class="col-xl-4">
                                                <div class="totle-contain">
                                                    <div class="wallet-point">
                                                        <img src="{{ asset('web/icons/wallet.svg') }}" alt="">
                                                        <img class="img-1" src="{{ asset('web/icons/wallet.svg') }}"
                                                            alt="">
                                                    </div>
                                                    <div class="totle-detail">
                                                        <h6>Toplam Harcama</h6>
                                                        <h4> {{ $siparisBilgiler['toplamHarcama'] }} </h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="totle-contain">
                                                    <div class="wallet-point">
                                                        <img src="{{ asset('web/icons/coin.svg') }}" alt="">
                                                        <img class="img-1" src="{{ asset('web/icons/coin.svg') }}"
                                                            alt="">
                                                    </div>
                                                    <div class="totle-detail">
                                                        <h6>Toplam Kupon İndirimi</h6>
                                                        <h4> {{ $siparisBilgiler['toplamIndirim'] }} </h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="totle-contain">
                                                    <div class="wallet-point">
                                                        <img src="{{ asset('web/icons/order.svg') }}" alt="">
                                                        <img class="img-1" src="{{ asset('web/icons/order.svg') }}"
                                                            alt="">
                                                    </div>
                                                    <div class="totle-detail">
                                                        <h6>Toplam Sipariş</h6>
                                                        <h4> {{ $siparisBilgiler['toplamSiparis'] }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-about">
                                        <div class="row">
                                            <div class="col-xl-7">
                                                <div class="sidebar-title">
                                                    <div class="loader-line"></div>
                                                    <h5>Profil Bilgileri</h5>
                                                </div>
                                                <ul class="profile-information">
                                                    <li>
                                                        <h6>İsim Soyisim:</h6>
                                                        <p> {{ auth()->guard('web')->user()->isim_soyisim }} </p>
                                                    </li>
                                                    <li>
                                                        <h6>Telefon:</h6>
                                                        <p>{{ auth()->guard('web')->user()->telefon }}</p>
                                                    </li>
                                                    <li>
                                                        <h6>E-Posta:</h6>
                                                        <p>{{ auth()->guard('web')->user()->eposta }}</p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-xl-5">
                                                <div class="profile-image d-none d-xl-block">
                                                    <img class="img-fluid"
                                                        src="{{ asset('web/images/dashboard.png') }}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>





                        <div class="tab-pane fade" id="order" role="tabpanel" aria-labelledby="order-tab">
                            <div class="dashboard-right-box">
                                <div class="order">
                                    <div class="sidebar-title">
                                        <div class="loader-line"></div>
                                        <h4>Sipariş Geçmişin</h4>
                                    </div>
                                    <div class="row gy-4">
                                        @foreach ($siparisler as $siparis)
                                            <div class="col-12">
                                                <div class="order-box">
                                                    <div class="order-container">
                                                        <div class="order-icon">
                                                            <i class="iconsax" data-icon="box"></i>
                                                            <div class="couplet"><i class="fa-solid fa-check"></i>
                                                            </div>
                                                        </div>
                                                        <div class="order-detail">
                                                            <h5>{{ $siparis->durumText() }}</h5> {{-- Sipariş durumu --}}
                                                            <p>{{ formatZaman($siparis->created_at, 'plus') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="product-order-detail">
                                                        <div class="order-wrap">
                                                            <h5>Sipariş Numarası: #{{ $siparis->kod }}</h5>

                                                            @php $siparisBilgi = $siparis->siparisBilgi; @endphp

                                                            <p>Alıcı:
                                                                @if ($siparisBilgi->sirket_isim)
                                                                    <span>{{ $siparisBilgi->sirket_isim }}</span> -
                                                                @endif
                                                                <span>{{ $siparisBilgi->isim }}</span>
                                                            </p>
                                                            <p>Adres: {{ $siparisBilgi->adres }}</p>
                                                            <p>E-posta: {{ $siparisBilgi->eposta }}</p>
                                                            <p>Telefon: {{ $siparisBilgi->telefon }}</p>
                                                            <p>TC/Vergi No: {{ $siparisBilgi->tc_vergi_no }}</p>
                                                            <p>Vergi Dairesi: {{ $siparisBilgi->vergi_dairesi }}</p>

                                                        </div>

                                                        <hr>
                                                        <br>
                                                        <div class="sidebar-title">
                                                            <div class="loader-line"></div>
                                                            <h5>Sipariş İçeriği</h5>
                                                        </div>
                                                        @foreach ($siparis->siparisUrun as $siparisUrun)
                                                            <div class="product-box">
                                                                <div class="order-wrap">
                                                                    <h5>{{ $siparisUrun->urun_baslik }}</h5>
                                                                    <ul>
                                                                        <li>
                                                                            <p>{{ $siparisUrun->adet }} Adet -
                                                                                {{ formatPara($siparisUrun->tutarlar['BirimFiyat'] + $siparisUrun->tutarlar['KdvTutar']) }}
                                                                                TL
                                                                            </p>

                                                                        </li>
                                                                        <li>
                                                                            <div>
                                                                                @php $varyantlar = $siparisUrun->siparisUrunVaryant; @endphp
                                                                                @if (!empty($varyantlar) && count($varyantlar) > 0)
                                                                                    @foreach ($varyantlar as $varyant)
                                                                                        <p>{{ $varyant->urun_varyant_isim }}:
                                                                                            {{ $varyant->urun_varyant_ozellik_isim }}
                                                                                        </p>
                                                                                    @endforeach
                                                                                @endif
                                                                            </div>

                                                                        </li>
                                                                    </ul>


                                                                </div>
                                                            </div>

                                                            @if (!$loop->last)
                                                                <hr>
                                                            @endif
                                                        @endforeach
                                                        <br>

                                                    </div>

                                                    <div class="return-box">

                                                        <p><strong>Ara Toplam:
                                                                {{ formatPara($siparis->butun_tutarlar['ara_toplam']) }}
                                                                TL</strong></p>
                                                        <p><strong>Kupon İndirim:
                                                                {{ formatPara($siparis->indirim_tutar) }}
                                                                TL</strong></p>
                                                        <p class="d-none"><strong>Kargo Tutar:
                                                                {{ formatPara($siparis->kargo_tutar) }} TL</strong>
                                                        </p>
                                                        <p><strong>Kdv Toplam:
                                                                {{ formatPara($siparis->butun_tutarlar['kdv_toplam']) }}
                                                                TL</strong></p>
                                                        <p><strong>Toplam Tutar:
                                                                {{ formatPara($siparis->butun_tutarlar['genel_toplam']) }}
                                                                TL</strong></p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
    </section>


    <div class="reviews-modal modal theme-modal fade" id="edit-box" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Profili Düzenle</h4>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="row g-3" id="profilForm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">İsim Soyisim</label>
                                <input class="form-control" type="text" id="profilIsimSoyisim" name="profilIsimSoyisim"
                                    value="{{ auth()->guard('web')->user()->isim_soyisim ?? '' }}" placeholder="İsim Soyisim">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">E-Posta</label>
                                <input class="form-control" type="email" id="profilEposta" name="profilEposta"
                                    value="{{ auth()->guard('web')->user()->eposta ?? '' }}" placeholder="E-Posta">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Telefon</label>
                                <input class="form-control" type="text" id="profilTelefon" name="profilTelefon"
                                    value="{{ auth()->guard('web')->user()->telefon ?? '' }}" placeholder="Telefon">
                            </div>
                        </div>
             
                        <hr>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Yeni Şifre</label>
                                <input class="form-control" type="password" id="profilSifre" name="profilSifre"
                                    placeholder="Yeni Şifre">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Yeni Şifreyi Tekrarı</label>
                                <input class="form-control" type="password" id="profilSifreTekrar" name="profilSifreTekrar"
                                    placeholder="Yeni Şifreyi Tekrarı">
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-submit w-100" type="submit" id="profil-duzenle-btn"
                                data-bs-dismiss="modal" aria-label="Close">Düzenle</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    



    <!-- my-account -->
    {{--     <section class="flat-spacing">
        <div class="container">
            <div class="my-account-wrap">

                <div class="my-account-content">
                    <div class="account-details">


                        <form id="profilForm" class="form-account-details form-has-password">
                            <div class="account-info">
                                <h5 class="title">Hesap Bilgileri</h5>
                                <div class="cols mb_20">
                                    <fieldset class="">
                                        <input class=""id="profilIsimSoyisim" name="profilIsimSoyisim"
                                            type="text"
                                            value="{{ auth()->guard('web')->user()->isim_soyisim ?? '' }}"
                                            placeholder="İsim Soyisim">
                                    </fieldset>

                                </div>
                                <div class="cols mb_20">
                                    <fieldset class="">
                                        <input class=""id="profilEposta" name="profilEposta" type="text"
                                            value="{{ auth()->guard('web')->user()->eposta ?? '' }}"
                                            placeholder="E-Posta">
                                    </fieldset>
                                    <fieldset class="">
                                        <input class="" id="profilTelefon" name="profilTelefon" type="email"
                                            value="{{ auth()->guard('web')->user()->telefon ?? '' }}"
                                            placeholder="Telefon">
                                    </fieldset>
                                </div>

                            </div>
                            <div class="account-password">
                                <h5 class="title">Şifre Değişikliği</h5>

                                <fieldset class="position-relative password-item mb_20">
                                    <input class="input-password" type="password" id="profilSifre"
                                        name="profilSifre" placeholder="Yeni Şifre *">
                                    <span class="toggle-password unshow">
                                        <i class="icon-eye-hide-line"></i>
                                    </span>
                                </fieldset>
                                <fieldset class="position-relative password-item">
                                    <input class="input-password" type="password" id="profilSifreTekrar"
                                        name="profilSifreTekrar" placeholder="Yeni Şifreyi Tekrarı *">

                                    <span class="toggle-password unshow">
                                        <i class="icon-eye-hide-line"></i>
                                    </span>
                                </fieldset>
                            </div>
                            <div class="button-submit">
                                <button class="tf-btn btn-fill" type="button" id="profil-duzenle-btn">
                                    <span class="text text-button">Düzenle</span>
                                </button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    @vite('resources/js/pages/web/kullanici/profil.js')
</x-layout.web>
