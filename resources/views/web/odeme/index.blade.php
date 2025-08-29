<x-layout.web>

    <x-slot:baslik>
        {{ ayar('siteBaslik', $aktifDil) }} | {{ __('global.odeme') }}
    </x-slot>
    <x-slot:aciklama>
        {{ ayar('metaIcerik', $aktifDil) }}
    </x-slot>
    <x-slot:anahtar>
        {{ ayar('metaAnahtar', $aktifDil) }}
    </x-slot>



    <section class="section-b-space pt-0">
        <div class="heading-banner">
            <div class="custom-container container">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4>Ödeme</h4>
                    </div>
                    <div class="col-sm-6">
                        <ul class="breadcrumb float-end">
                            <li class="breadcrumb-item"><a href="{{ rota('index') }}"> Anasayfa </a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Ödeme</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-b-space pt-0">
        <div class="custom-container container">
            <div class="row" id="siparisForm">
                <div class="col-xxl-9 col-lg-8">
                    <div class="left-sidebar-checkout sticky">
                        <div class="address-option">
                            <h5 class="title">Sipariş Bilgileri</h5>
                            <form class="row">
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="siparisSirketIsim">Şirket İsmi</label>
                                        <input type="text" class="form-control" placeholder="Şirket İsmi"
                                            id="siparisSirketIsim" name="siparisSirketIsim">
                                    </div>
                                </div> --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="siparisIsim">İsim Soyisim</label>
                                        <input type="text" class="form-control" placeholder="İsim Soyisim *"
                                            id="siparisIsim" name="siparisIsim">
                                    </div>
                                </div>
                                {{--  <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="siparisTcVergiNo">TC/Vergi No</label>
                                        <input type="text" class="form-control" placeholder="Tc/Vergi No *"
                                            id="siparisTcVergiNo" name="siparisTcVergiNo">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="siparisVergiDairesi">Vergi Dairesi</label>
                                        <input type="text" class="form-control" placeholder="Vergi Dairesi"
                                            id="siparisVergiDairesi" name="siparisVergiDairesi">
                                    </div>
                                </div> --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="siparisEposta">E-Posta</label>
                                        <input type="text" class="form-control" placeholder="E-Posta *"
                                            id="siparisEposta" name="siparisEposta">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="siparisTelefon">Telefon</label>
                                        <input type="text" class="form-control" placeholder="Telefon *"
                                            id="siparisTelefon" name="siparisTelefon">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="siparisIl">Şehir</label>
                                        <input type="text" class="form-control" placeholder="Şehir *" id="siparisIl"
                                            name="siparisIl">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="siparisIlce">İlçe</label>
                                        <input type="text" class="form-control" placeholder="İlçe *" id="siparisIlce"
                                            name="siparisIlce">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="siparisAdres">Adres *</label>
                                        <textarea placeholder="Adres *" id="siparisAdres" class="form-control" name="siparisAdres"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="siparisIlce">Posta Kodu *</label>
                                        <input type="text" placeholder="Posta Kodu *" id="siparisPostaKodu"
                                            class="form-control" name="siparisPostaKodu">
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="address-option">
                            <div class="wrap">
                                <h5 class="title">Ödeme Seçenekleri:</h5>
                                <form class="form-payment">
                                    <div class="accordion" id="payment-box">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <label class="accordion-button  payment-option"
                                                    data-bs-toggle="collapse" data-bs-target="#credit-card-payment">
                                                    <input type="radio" name="payment" class="tf-check-rounded"
                                                        checked value="krediKarti" id="credit-card-method">
                                                    <span class="text-title ms-2">Banka/Kredi Kartı</span>
                                                </label>
                                            </h2>
                                            <div id="credit-card-payment" class="accordion-collapse collapse show"
                                                data-bs-parent="#payment-box">
                                                <div class="accordion-body">
                                                    <img src="{{ asset('web/images/iyzico_ile_ode.png') }}"
                                                        style="height: 50px" alt="">
                                                    <div class="input-payment-box d-none">
                                                        <div class="ip-card">
                                                            <input type="text" placeholder="XXXX XXXX XXXX XXXX"
                                                                id="kartNo">
                                                            <div class="list-card">
                                                                <img height="20" width="50"
                                                                    src="{{ asset('web/images/iyzico_ile_ode.png') }}"
                                                                    alt="card">
                                                            </div>
                                                        </div>
                                                        <div class="grid-2">
                                                            <input type="text" id="kartSonTarih"
                                                                name="kartSonTarih" placeholder="MM/YY">
                                                            <input type="text" id="kartCvv" name="kartCvv"
                                                                placeholder="CVV">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <label class="accordion-button collapsed payment-option"
                                                    data-bs-toggle="collapse" data-bs-target="#havale-payment">
                                                    <input type="radio" name="payment" class="tf-check-rounded"
                                                        value="havale" id="havale-method">
                                                    <span class="text-title ms-2">Havale/EFT ile Ödeme</span>
                                                </label>
                                            </h2>
                                            <div id="havale-payment" class="accordion-collapse collapse "
                                                data-bs-parent="#payment-box">
                                                <div class="accordion-body">
                                                    <p class="text-secondary">
                                                        Ödemenizi doğrudan banka hesabımıza yapın. Lütfen ödeme
                                                        referansı olarak Sipariş Kodunuzu kullanın.
                                                    </p>
                                                    <div class="bank-details">
                                                        <div
                                                            class="d-flex justify-content-between align-items-center mb-2">
                                                            <strong>Banka Adı:</strong>
                                                            <span>{{ ayar('banka') }}</span>
                                                        </div>
                                                        <div
                                                            class="d-flex justify-content-between align-items-center mb-2">
                                                            <strong>Hesap Sahibi:</strong>
                                                            <span>{{ ayar('bankaHesapSahibi') }}</span>
                                                        </div>
                                                        <div
                                                            class="d-flex justify-content-between align-items-center mb-2">
                                                            <strong>IBAN:</strong>
                                                            <span>{{ ayar('bankaIban') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <label class="accordion-button collapsed payment-option"
                                                    data-bs-toggle="collapse" data-bs-target="#kapida-payment">
                                                    <input type="radio" name="payment" class="tf-check-rounded"
                                                        value="kapida" id="kapida-method">
                                                    <span class="text-title ms-2">Kapıda Ödeme</span>
                                                </label>
                                            </h2>

                                            
                                            <div id="kapida-payment" class="accordion-collapse collapse"
                                                 data-bs-parent="#payment-box">
                                                <div class="accordion-body">
                                                    <p class="text-muted">Siparişinizi teslim alırken sadece nakit ile
                                                        ödeme yapabilirsiniz.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-xxl-3 col-lg-4">
                    <div class="right-sidebar-checkout">
                        <h4>Sipariş Özeti</h4>
                        <div class="cart-listing">
                            <ul>

                                @foreach ($sepetUrunler as $sepetUrun)
                                    <li><img src="{{ $sepetUrun['ana_resim'] }}"
                                            style="height: 50px; aspect-ratio:1;" alt="">
                                        <div>
                                            <h6> {{ $sepetUrun['urun_baslik'] }} </h6>
                                            <div class="variant text-caption-1 text-secondary">
                                                @foreach ($sepetUrun['varyantlar'] as $varyant)
                                                    <div>
                                                        <span class="size">
                                                            {{ $varyant['ana_varyant_isim'] }}
                                                        </span>
                                                        /
                                                        <span class="color">
                                                            {{ $varyant['urun_varyant_ozellik_isim'] }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <p>{{ $sepetUrun['adet'] }} x {{ formatPara($sepetUrun['birim_fiyat']) }} TL
                                        </p>
                                    </li>
                                @endforeach

                            </ul>
                            <div class="summary-total">
                                <ul>


                                    <li>
                                        <p>Ara Toplam</p><span class="sepetAraToplamTutar">
                                            {{ formatPara($araToplam) }} TL</span>
                                    </li>
                                    <li>
                                        <p>Kdv Tutar</p><span class="sepetKdvToplamTutar">
                                            {{ formatPara($kdvToplam) }} TL</span>
                                    </li>
                                    <li id="siparisKapidaOdemeTutar" class="d-none">
                                        <p>Kapıda Ödeme Tutarı</p>
                                        <span class="">
                                            {{ formatPara(ayar('kapidaOdemeTutar')) }} TL</span>

                                    </li>
                                    <li id="indirimTutarCnt" class="{{ $kuponTutar > 0 ?: 'd-none' }}">
                                        <p>İndirim Tutar</p><span class="sepetIndirimTutar">
                                            {{ formatPara($kuponTutar) }} TL</span>
                                    </li>
                                    <li class="d-none">
                                        <p>Kargo Tutar</p><span class="sepetKargoTutar"> {{ formatPara($kargoTutar) }}
                                            TL</span>
                                    </li>


                                </ul>

                            </div>
                            <div class="total">
                                <h6>Toplam : </h6>
                                <h6 class="sepetGenelToplamTutar">{{ formatPara($sepetToplam) }} TL </h6>
                            </div>
                            <div class="order-button">
                                <a class="btn btn_black sm w-100 rounded" href="javascript:void(0);" id="odeme-btn">
                                    Siparişi Tamala
                                </a>
                            </div>
                            <div class="mt-3">
                                Ödeme yapan kişi, Mesafeli Satış Sözleşmesi ve Ön Bilgilendirme Formu’nu elektronik
                                ortamda okuyup anladığını, içeriğini kabul ettiğini ve bu sözleşmeleri onayladığını
                                beyan eder. Yapılan ödeme ile birlikte ilgili ürün veya hizmete ilişkin tüm şartlar,
                                iade ve cayma hakları hakkında bilgilendirildiğini kabul eder.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="odemeIframeAlani" class="d-none mt-5">
                <iframe id="iyziIframe" class="w-100" style="height: 700px;" src=""
                    frameborder="0"></iframe>
            </div>
        </div>
    </section>


    <script>
        const kapidaOdemeTutar = {{ ayar('kapidaOdemeTutar') }};
        const toplamTutar = {{ $sepetToplam }};
    </script>

    @vite('resources/js/pages/web/odeme.js')

</x-layout.web>
