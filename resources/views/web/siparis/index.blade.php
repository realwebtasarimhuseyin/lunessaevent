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

    @php
        $siparisBilgiler = $siparis->siparisBilgi;
        $siparisUrunler = $siparis->siparisUrun;
    @endphp

    {{--     <!-- page-title -->
    <div class="tf-page-title style-2" style="background-image: url({{ asset('web/images/titlebg.png') }})">
        <div class="container-full">
            <div class="heading text-center">Hesabım</div>
        </div>
    </div>
    <!-- /page-title -->

    <!-- page-cart -->
    <section class="flat-spacing-11">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">

                    <ul class="nav my-account-nav" role="tablist">
                        <li>
                            <a href="{{ route('hesabim') }}" class="my-account-nav-item">
                                {{ __('global.hesapBilgileri') }}
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('hesabim') }}#orders" class="my-account-nav-item active">
                                Siparişler
                            </a>
                        </li>

                        <li>
                            <a class="my-account-nav-item" href="{{ route('cikis') }}">
                                Çıkış
                            </a>
                        </li>
                    </ul> <!-- end of dashboard-list -->
                </div>
                <div class="col-lg-9">
                    <div class="wd-form-order">
                        <div class="order-head">
                            <div class="content">
                                <div class="badge">
                                    {{ $siparis->durum ? 'Ödeme Bekleniyor' : ($siparis->durum == 2 ? 'Ödeme Alındı' : ($siparis->durum == 3 ? 'Sipariş Hazırlanıyor' : ($siparis->durum == 4 ? 'Kargoya Verildi' : 'İptal Edildi'))) }}
                                </div>
                                <h6 class="mt-8 fw-5">Sipariş No : #{{ $siparis->kod }}</h6>
                            </div>
                        </div>
                        <div class="tf-grid-layout md-col-2 gap-15">
                            <div class="item">
                                <div class="text-2 text_black-2">Müşteri İsmi</div>
                                <div class="text-2 mt_4 fw-6">
                                    {{ $siparisBilgiler->isim . ' ' . $siparisBilgiler->soyisim }}
                                </div>
                            </div>
                            <div class="item">
                            </div>
                            <div class="item">
                                <div class="text-2 text_black-2">Sipariş Tarih</div>
                                <div class="text-2 mt_4 fw-6">
                                    {{ formatZaman($siparis->created_at, 'plus') }}
                                </div>
                            </div>
                            <div class="item">
                                <div class="text-2 text_black-2">Adres</div>
                                {{ $siparisBilgiler->adres . ' ' . $siparisBilgiler->ilce . '/' . $siparisBilgiler->il }}
                            </div>
                        </div>
                        <div class="widget-tabs style-has-border widget-order-tab">
                            <ul class="widget-menu-tab">
                                <li class="item-title active">
                                    <span class="inner">Sipariş Bilgisi</span>
                                </li>
                            </ul>
                            <div class="widget-content-tab">
                                <div class="widget-content-inner active">
                                    @foreach ($siparisUrunler as $siparisUrun)
                                        @php
                                            $urun = $siparisUrun->urun;
                                            $dilVerisi = $urun->urunDiller->where('dil', $aktifDil)->first();
                                            $anaResim = $urun->urunResimler->where('ana_resim', true)->first()
                                                ->resim_url;

                                            $varyantlar = $siparisUrun->siparisUrunVaryant;
                                        @endphp



                                        <div class="order-head">
                                            <figure class="img-product">
                                                <img src="{{ Storage::url($anaResim) }}" alt="product">
                                            </figure>
                                            <div class="content">
                                                <div class="text-2 fw-6">{{ $dilVerisi->baslik }}</div>
                                                <div class="mt_4"><span class="fw-6">Birim Fiyat :</span>
                                                    {{ $siparisUrun->birim_fiyat }} TL
                                                </div>

                                                @if (!empty($varyantlar) && count($varyantlar) > 0)
                                                    @foreach ($varyantlar as $varyant)
                                                        @php
                                                            $urunVaryant = $varyant->varyant->urunVaryantDiller
                                                                ->where('dil', $aktifDil)
                                                                ->first()->isim;

                                                            $urunVaryantOzellik = $varyant->varyantOzellik->urunVaryantOzellikDiller
                                                                ->where('dil', $aktifDil)
                                                                ->first()->isim;
                                                        @endphp

                                                        <div class="">
                                                            <span class="fw-6"> {{ $urunVaryant }} : </span>
                                                            {{ $urunVaryantOzellik }}
                                                        </div>
                                                        <br>
                                                    @endforeach
                                                @endif
                                            </div>
                                          <div class="d-flex" style="flex: 1 0 auto; justify-content: end;">
                                                <a href="{{ route('musteri-siparis-urun-detay', ['kod' => $siparis->kod, 'urunSlug' => $aniDefteri->slug]) }}"
                                                    class="tf-btn btn-fill justify-content-center fw-6 fs-16 animate-hover-btn">
                                                    Yönet
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach

                                    <br><br>

                                    @php
                                        $araToplam = $siparis->butun_tutarlar['ara_toplam'];
                                        $kdvToplam = $siparis->butun_tutarlar['kdv_toplam'];
                                        $genelToplam = $siparis->butun_tutarlar['genel_toplam'];
                                        $indirimToplam = $siparis->indirim_tutar;
                                    @endphp

                                    <ul>

                                        <li class="d-flex justify-content-between text-2">
                                            <span>Toplam Tutar</span>
                                            <span class="fw-6">{{ formatPara($araToplam) }} TL </span>
                                        </li>
                                        <li class="d-flex justify-content-between text-2">
                                            <span>Kdv Tutar</span>
                                            <span class="fw-6">{{ formatPara($kdvToplam) }} TL</span>

                                        </li>
                                        <li class="d-flex justify-content-between text-2 mt_4 pb_8 line">
                                            <span>İndirim Tutar</span>
                                            <span class="fw-6">{{ formatPara($indirimToplam) }} TL</span>

                                        </li>
                                        <li class="d-flex justify-content-between text-2 mt_8">
                                            <span>Sipariş Genel Turar</span>
                                            <span class="fw-6">
                                                {{ formatPara($genelToplam) }} TL
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- page-cart --> --}}


    <div class="page-title">
        <div class="container">
            <h3 class="heading text-center">Hesabım</h3>
            <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                <li><a class="link" href="{{ rota('hesabim.index') }}">Hesabım</a></li>

                <li><i class="icon-arrRight"></i></li>
                <li>Siparişler</li>
            </ul>
        </div>
    </div>

    <!-- my-account -->
    <section class="flat-spacing">
        <div class="container">
            <div class="my-account-wrap">
                <div class="wrap-sidebar-account">
                    <div class="sidebar-account">
                        <div class="account-avatar">

                            <h6 class="mb_4"> {{ auth()->guard('web')->user()->isim_soyisim }} </h6>
                            <div class="body-text-1">{{ auth()->guard('web')->user()->eposta }}</div>

                        </div>
                        <ul class="my-account-nav">
                            <li>
                                <a href="{{ rota('hesabim.index') }}" class="my-account-nav-item">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21"
                                            stroke="#181818" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z"
                                            stroke="#181818" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    Hesap Bilgileri
                                </a>
                            </li>
                            <li>
                                <span class="my-account-nav-item active">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16.5078 10.8734V6.36686C16.5078 5.17166 16.033 4.02541 15.1879 3.18028C14.3428 2.33514 13.1965 1.86035 12.0013 1.86035C10.8061 1.86035 9.65985 2.33514 8.81472 3.18028C7.96958 4.02541 7.49479 5.17166 7.49479 6.36686V10.8734M4.11491 8.62012H19.8877L21.0143 22.1396H2.98828L4.11491 8.62012Z"
                                            stroke="#181818" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    Şiparişler
                                </span>
                            </li>
                            <li>
                                <a href="{{ rota('cikis') }}" class="my-account-nav-item">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9"
                                            stroke="#181818" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M16 17L21 12L16 7" stroke="#181818" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M21 12H9" stroke="#181818" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    Çıkış
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="my-account-content">
                    <div class="account-order-details">
                        <div class="wd-form-order">
                            <div class="order-head">
                                <div class="content">
                                    <div class="badge">
                                        {{ $siparis->durum ? 'Ödeme Bekleniyor' : ($siparis->durum == 2 ? 'Ödeme Alındı' : ($siparis->durum == 3 ? 'Sipariş Hazırlanıyor' : ($siparis->durum == 4 ? 'Kargoya Verildi' : ($siparis->durum == 5 ? 'Teslim Edildi' : 'İptal Edildi')))) }}
                                    </div>
                                    <h6 class="mt-8 fw-5">Sipariş Kod : #{{ $siparis->kod }}</h6>
                                </div>
                            </div>
                            <div class="tf-grid-layout md-col-2 gap-15  border-bottom border-3 pb-3">
                                <div class="item">
                                    <div class="text-2 text_black-2">İsim Soyisim</div>
                                    <div class="text-2 mt_4 fw-6">{{ $siparisBilgiler->isim }}</div>
                                </div>

                                <div class="item">
                                    <div class="text-2 text_black-2">Tarih</div>
                                    <div class="text-2 mt_4 fw-6"> {{ formatZaman($siparis->created_at) }} </div>
                                </div>

                                <div class="item">
                                    <div class="text-2 text_black-2">Adres</div>
                                    <div class="text-2 mt_4 fw-6">{{ $siparisBilgiler->adres }}</div>
                                </div>
                            </div>
                            <div class="widget-tabs style-3 widget-order-tab">

                                <div class="widget-content-tab">

                                    <div class="widget-content-inner active">
                                        @foreach ($siparisUrunler as $siparisUrun)
                                            @php
                                                $urun = $siparisUrun->urun;
                                                $dilVerisi = $urun->urunDiller->where('dil', $aktifDil)->first();
                                                $anaResim = depolamaUrl($urun->urunResimler->where('tip', 1)->first());

                                                $varyantlar = $siparisUrun->siparisUrunVaryant;
                                            @endphp


                                            <div class="order-head">
                                                <figure class="img-product">
                                                    <img src="{{ $anaResim }}" alt="product">
                                                </figure>
                                                <div class="content">
                                                    <div class="text-2 fw-6 border-bottom"> {{ $dilVerisi->baslik }} </div>

                                                    <div class="mt_4">
                                                        <span class="fw-6"> Birim Fiyat : </span>
                                                        {{ $siparisUrun->birim_fiyat }} TL
                                                    </div>
                                                    @php
                                                        $varyantlar = $siparisUrun->siparisUrunVaryant;
                                                    @endphp
                                                    @if (!empty($varyantlar) && count($varyantlar) > 0)
                                                        @foreach ($varyantlar as $varyant)
                                                            <div class="mt_4">
                                                                <span class="fw-6"> {{ $varyant->urun_varyant_isim }}
                                                                    : </span>
                                                                {{ $varyant->urun_varyant_ozellik_isim }}

                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach

                                        @php
                                            $araToplam = $siparis->butun_tutarlar['ara_toplam'];
                                            $kdvToplam = $siparis->butun_tutarlar['kdv_toplam'];
                                            $genelToplam = $siparis->butun_tutarlar['genel_toplam'];
                                            $indirimToplam = $siparis->indirim_tutar;
                                            $kargoTutar = $siparis->kargo_tutar;
                                        @endphp

                                        <ul>
                                            <li class="d-flex justify-content-between text-2">
                                                <span>Ara Toplam</span>
                                                <span class="fw-6">{{ formatPara($araToplam) }} TL </span>
                                            </li>
                                            <li class="d-flex justify-content-between text-2">
                                                <span>Kdv Tutar</span>
                                                <span class="fw-6">{{ formatPara($kdvToplam) }} TL</span>

                                            </li>
                                            <li class="d-flex justify-content-between text-2">
                                                <span>İndirim Tutar</span>
                                                <span class="fw-6">{{ formatPara($indirimToplam) }} TL</span>
                                            </li>
                                            <li class="d-flex justify-content-between text-2">
                                                <span>Kargo Tutar</span>
                                                <span class="fw-6">{{ formatPara($kargoTutar) }} TL</span>
                                            </li>
                                            <li class="d-flex justify-content-between text-2 mt_8">
                                                <span>Sipariş Genel Turar</span>
                                                <span class="fw-6">
                                                    {{ formatPara($genelToplam) }} TL
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



</x-layout.web>
