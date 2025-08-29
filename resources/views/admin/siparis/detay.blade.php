<x-layout.admin :scrollspy="false">
    <x-slot:pageTitle>
        Sipariş Detay
    </x-slot>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/apps/invoice-preview.scss'])
        @vite(['resources/scss/dark/assets/apps/invoice-preview.scss'])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
    <div class="row invoice layout-top-spacing layout-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="doc-container">
                <div class="row">
                    <div class="col-xl-9">
                        <div class="invoice-container">
                            <div class="invoice-inbox">
                                <div id="ct" class="">
                                    <div class="invoice-00001">
                                        <div class="content-section">
                                            <div class="inv--head-section inv--detail-section">
                                                <div class="row">
                                                    <div class="col-sm-6 col-12 mr-auto">
                                                        <div class="d-flex">
                                                            <img class="company-logo"
                                                                src="{{ Storage::url(ayar('ustLogo')) }}"
                                                                style="height: 25px" alt="company">
                                                        </div>
                                                        <p class="inv-street-addr mt-3">NORTHERN</p>
                                                        <p class="inv-email-address"> {{ ayar('eposta') }} </p>
                                                        <p class="inv-email-address"> {{ ayar('telefon') }} </p>
                                                    </div>
                                                    <div class="col-sm-6 text-sm-end">
                                                        <p class="inv-list-number mt-sm-3 pb-sm-2 mt-4"><span
                                                                class="inv-title">Sipariş No : </span> <span
                                                                class="inv-number">#{{ $siparis->kod }}</span></p>
                                                        <p class="inv-created-date mt-sm-5 mt-3"><span
                                                                class="inv-title">Oluşturma Tarih : </span> <span
                                                                class="inv-date">{{ formatZaman($siparis->created_at, 'plus') }}</span>
                                                        </p>
                                                        <p class="inv-created-date mt-sm-5 mt-3"><span
                                                                class="inv-title">Ödeme Tipi : </span>
                                                            <span class="inv-date">
                                                                {{ ($siparis->odeme_tip == 'krediKarti' ? 'Kredi Kartı' : $siparis->odeme_tip == 'kapida') ? 'Kapıda Ödeme' : 'Havale/EFT' }}
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="inv--detail-section inv--customer-detail-section">
                                                <div class="row">
                                                    <div class="col-xl-8 col-lg-7 col-md-6 col-sm-4 align-self-center">
                                                        <p class="inv-to">Alıcı</p>
                                                    </div>
                                                    <div
                                                        class="col-xl-4 col-lg-5 col-md-6 col-sm-8 align-self-center order-sm-0 order-1 text-sm-end mt-sm-0 mt-5">
                                                        <h6 class=" inv-title">Gönderici</h6>
                                                    </div>
                                                    @php
                                                        $siparisBilgi = $siparis->siparisBilgi;
                                                    @endphp

                                                    <div class="col-xl-8 col-lg-7 col-md-6 col-sm-4">
                                                        <p class="inv-customer-name">
                                                            Alıcı :
                                                           
                                                            <span>{{ $siparisBilgi->isim }}</span>
                                                        </p>
                                                        <p class="inv-street-addr">
                                                            Adres :
                                                            {{ $siparisBilgi->adres }}
                                                        </p>
                                                        <p class="inv-email-address">
                                                            E-posta : {{ $siparisBilgi->eposta }}
                                                        </p>
                                                        <p class="inv-email-address">
                                                            Telefon : {{ $siparisBilgi->telefon }}
                                                        </p>
                                                       
                                                    </div>
                                                    <div
                                                        class="col-xl-4 col-lg-5 col-md-6 col-sm-8 col-12 order-sm-0 order-1 text-sm-end">
                                                        <p class="inv-customer-name">NORTHERN</p>
                                                        <p class="inv-street-addr">{{ ayar('adres') }}</p>
                                                        <p class="inv-email-address">{{ ayar('eposta') }}</p>
                                                        <p class="inv-email-address">{{ ayar('telefon') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="inv--product-table-section">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead class="">
                                                            <tr>
                                                                <th scope="col">Ürün</th>
                                                                <th class="text-end" scope="col">Adet</th>
                                                                <th class="text-end" scope="col">Birim Fiyat</th>
                                                                <th class="text-end" scope="col">Kdv</th>
                                                                <th class="text-end" scope="col">Toplam</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($siparis->siparisUrun as $siparisUrun)
                                                                <tr>
                                                                    <td>
                                                                        {{ $siparisUrun->urun_baslik }}
                                                                        <br />
                                                                        @php
                                                                            $varyantlar =
                                                                                $siparisUrun->siparisUrunVaryant;
                                                                        @endphp
                                                                        @if (!empty($varyantlar) && count($varyantlar) > 0)
                                                                            @foreach ($varyantlar as $varyant)
                                                                                {{ $varyant->urun_varyant_isim }} :
                                                                                {{ $varyant->urun_varyant_ozellik_isim }}

                                                                                <br>
                                                                            @endforeach
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-end">
                                                                        {{ $siparisUrun->adet }}

                                                                    </td>
                                                                    <td class="text-end">
                                                                        {{ formatPara($siparisUrun->tutarlar['BirimFiyat']) }}
                                                                        TL
                                                                    </td>
                                                                    <td class="text-end">
                                                                        {{ formatPara($siparisUrun->tutarlar['KdvTutar']) }}
                                                                        TL
                                                                    </td>
                                                                    <td class="text-end">
                                                                        {{ formatPara($siparisUrun->tutarlar['ToplamTutar']) }}
                                                                        TL
                                                                    </td>

                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            @php
                                                $butunFiyatlar = $siparis->butun_tutarlar;
                                            @endphp
                                            <div class="inv--total-amounts">
                                                <div class="row mt-4">
                                                    <div class="col-sm-5 col-12 order-sm-0 order-1">
                                                    </div>
                                                    <div class="col-sm-7 col-12 order-sm-1 order-0">
                                                        <div class="text-sm-end">
                                                            <div class="row">
                                                                <div class="col-sm-8 col-7">
                                                                    <p class="">Ara Toplam :</p>
                                                                </div>
                                                                <div class="col-sm-4 col-5">
                                                                    <p class="">
                                                                        {{ formatPara($butunFiyatlar['ara_toplam']) }}
                                                                        TL
                                                                    </p>
                                                                </div>
                                                                <div class="col-sm-8 col-7">
                                                                    <p class="">Kdv Toplam :</p>
                                                                </div>
                                                                <div class="col-sm-4 col-5">
                                                                    <p class="">
                                                                        {{ formatPara($butunFiyatlar['kdv_toplam']) }}
                                                                        TL</p>
                                                                </div>
                                                                @if ($siparis->indirim_tutar > 0)
                                                                    <div class="col-sm-8 col-7">
                                                                        <p class=" discount-rate">Kupon İndirim :</p>
                                                                    </div>
                                                                    <div class="col-sm-4 col-5">
                                                                        <p class="">
                                                                            {{ formatPara($siparis->indirim_tutar) }}
                                                                            TL
                                                                        </p>
                                                                    </div>
                                                                @endif

                                                                <div class="col-sm-8 col-7 d-none">
                                                                    <p class="">Kargo Tutar :</p>
                                                                </div>
                                                                <div class="col-sm-4 col-5 d-none">
                                                                    <p class="">
                                                                        {{ formatPara($siparis->kargo_tutar) }}
                                                                        TL</p>
                                                                </div>

                                                                @if ($siparis->odeme_tip == 'kapida')
                                                                    <div class="col-sm-8 col-7">
                                                                        <p class="">Kapıda Ödeme Tutar :</p>
                                                                    </div>
                                                                    <div class="col-sm-4 col-5">
                                                                        <p class="">
                                                                            {{ formatPara($siparis->kapida_odeme_tutar) }}
                                                                            TL</p>
                                                                    </div>
                                                                @endif


                                                                <div class="col-sm-8 col-7 grand-total-title mt-3">
                                                                    <h4 class="">Genel Toplam : </h4>
                                                                </div>
                                                                <div class="col-sm-4 col-5 grand-total-amount mt-3">
                                                                    <h4 class="">
                                                                        {{ formatPara($butunFiyatlar['genel_toplam']) }}
                                                                        TL</h4>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="invoice-actions-btn">
                            <div class="invoice-action-btn">
                                <div class="row">
                                    @if (yetkiKontrol('siparis-duzenle'))
                                        <div class="col-12">
                                            <div id="siparisDetayForm" onsubmit="(return false)" class="mb-4">
                                                <select class="form-select form-control-sm urun-select"
                                                    id="siparisDurum" name="siparisDurum">
                                                    <option value="" disabled> Sipariş Durumu Seçin </option>
                                                    <option value="1"
                                                        {{ $siparis->durum == '0' ? 'selected' : '' }}>
                                                        Ödeme
                                                        Başarısız </option>
                                                    <option value="1"
                                                        {{ $siparis->durum == '1' ? 'selected' : '' }}>
                                                        Ödeme
                                                        Bekleniyor </option>
                                                    <option value="2"
                                                        {{ $siparis->durum == '2' ? 'selected' : '' }}>
                                                        Ödeme Alındı
                                                    </option>
                                                    <option value="3"
                                                        {{ $siparis->durum == '3' ? 'selected' : '' }}>
                                                        Sipariş
                                                        Hazırlanıyor </option>
                                                    <option value="4"
                                                        {{ $siparis->durum == '4' ? 'selected' : '' }}>
                                                        Kargoya Verildi
                                                    </option>
                                                    <option value="5"
                                                        {{ $siparis->durum == '5' ? 'selected' : '' }}>
                                                        Teslim Edildi
                                                    </option>
                                                    <option value="6"
                                                        {{ $siparis->durum == '6' ? 'selected' : '' }}>
                                                        İptal Edildi
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- <div class="col-12">
                                        <button class="btn btn-primary w-100 _effect--ripple waves-effect waves-light"
                                            id="createCargoBtn" type="button" style="margin-top:10px;">
                                            Kargoya Gönder
                                        </button>
                                    </div>

                                    <div class="col-12">
                                        <button type="button"
                                            class="btn btn-success w-100 _effect--ripple waves-effect waves-light"
                                            id="sendInvoiceButton" style="margin-top:10px;">
                                            Fatura Gönder
                                        </button>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--     <script>
        document.getElementById('createCargoBtn').addEventListener('click', function() {
            const aliciEposta = "{{ $siparis->siparisBilgi->eposta ?? 'Yok' }}";
            var siparisNo = "{{ $siparis->kod }}";
            var kargoTakipNo = siparisNo.replace(/\D/g, '');

            const kargoBilgileri = {
                OzelKargoTakipNo: kargoTakipNo,
                KisiKurum: "{{ $siparis->siparisBilgi->isim }}",
                AliciAdresi: "{{ $siparis->siparisBilgi->adres }}",
                Il: "{{ $siparis->siparisBilgi->il }}",
                Ilce: "{{ $siparis->siparisBilgi->ilce }}",
                TelefonCep: "{{ $siparis->siparisBilgi->telefon }}",
                Eposta: aliciEposta
            };

            //console.log("Kargo Bilgileri:", kargoBilgileri);

            fetch("{{ route('realpanel.kargo.create') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(kargoBilgileri)
                })
                .then(response => response.json())
                .then(data => {
                    //console.log("API Yanıtı:", data);

                    if (data.success === true) {
                        alert(data.message || 'Kargo başarıyla gönderildi!');
                    } else {
                        alert(data.GonderiyiKargoyaGonderYeniResult ||
                            'Bir hata oluştu, lütfen tekrar deneyin.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Bir hata oluştu.');
                });

        });
    </script> 

    <!-- Fatura Gönderimi -->
    <script>
        document.getElementById('sendInvoiceButton').addEventListener('click', function() {
            var toplamAra = "{{ $butunFiyatlar['ara_toplam'] }}";
            var toplamKdvTutar = "{{ $butunFiyatlar['kdv_toplam'] }}";
            var toplamGenelTutar = "{{ $butunFiyatlar['genel_toplam'] }}";
            var siparisNo = "{{ $siparis->kod }}";

            var tamIsim = "{{ $siparisBilgi->isim }}";
            var isimParcalari = tamIsim.trim().split(" ");
            var musteriSoyisim = isimParcalari[isimParcalari.length - 1];
            var musteriIsim = isimParcalari.slice(0, -1).join(" ");

            var musteriAdres = "{{ $siparisBilgi->adres }}";
            var musteriIlce = "{{ $siparisBilgi->ilce }}";
            var musteriIl = "{{ $siparisBilgi->il }}";
            var musteriEposta = "{{ $siparisBilgi->eposta }}";
            var musteriTelefon = "{{ $siparisBilgi->telefon }}";
            var musteriTc = "{{ $siparisBilgi->tc_vergi_no }}";
            var musteriSirket = "{{ $siparisBilgi->sirket_isim }}";
            var musteriVdairesi = "{{ $siparisBilgi->vergi_dairesi }}";

            const now = new Date();
            const tarih = new Date(now.getTime() + 3 * 60 * 60 * 1000).toISOString();

            var urunler = {!! json_encode(
                $siparis->siparisUrun->map(function ($urun) {
                        return [
                            'product_title' => $urun->urun_baslik,
                            'tax_rate' => $urun->kdv_oran,
                            'quantity' => $urun->adet,
                            'unit_price' => $urun->birim_fiyat,
                            'total_price' => $urun->adet * $urun->birim_fiyat,
                        ];
                    })->values()->toArray(),
            ) !!};

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "{{ url('/realpanel/fatura-gonder') }}", true);

            xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
            xhr.setRequestHeader("Content-Type", "application/json");

            var data = {
                invoice_number: siparisNo,
                total_without_tax_amount: toplamAra,
                total_tax_amount: toplamKdvTutar,
                total_amount: toplamGenelTutar,
                user: {
                    identity_number: musteriTc,
                    tax_office: musteriVdairesi,
                    first_name: musteriIsim,
                    last_name: musteriSoyisim,
                    company: musteriSirket,
                    street: musteriAdres,
                    district: musteriIlce,
                    city: musteriIl,
                    country: "Türkiye",
                    email: musteriEposta,
                    phone: musteriTelefon
                },
                products: urunler,
                created_at: tarih
            };

            xhr.send(JSON.stringify(data));

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) { // İstek tamamlandıysa
                    if (xhr.status === 200) {
                        console.log(data);
                        alert('Fatura başarıyla gönderildi!');
                    } else {
                        var errorMessage = 'Bir hata oluştu: ' + (xhr.responseText || 'Bilinmeyen bir hata');
                        alert(errorMessage);
                        console.error(errorMessage);
                    }
                }
            };
        });
    </script>
--}}


    <x-slot:footerFiles>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->

    <script>
        const siparisId = {{ $siparis->id }};
    </script>

    @vite(['resources/js/pages/admin/siparis/detay.js'])



</x-layout.admin>
