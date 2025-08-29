<x-layout.web>

    <x-slot:baslik>
        {{ ayar('siteBaslik', $aktifDil) }} | Ödeme Onay
    </x-slot>
    <x-slot:aciklama>
        {{ ayar('metaIcerik', $aktifDil) }}
    </x-slot>
    <x-slot:anahtar>
        {{ ayar('metaAnahtar', $aktifDil) }}
    </x-slot>


    <section class="section-b-space py-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 px-0">
                    <div class="order-box-1">
                        <br>
                        <br>
                        <h4>Siparişiniz Alındı</h4>
                        <p>Siparişiniz başarıyla alındı, kısa sürede siparişiniz hazırlanacaktır!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-b-space">
        <div class="custom-container container order-success">
            <div class="row gy-4">
                <div class="col-xl-8">
                    <div class="order-items sticky">
                        <h4>Sipariş Bilgileri</h4>
                        <p>Lütfen sipariş detaylarınızı kontrol edin.</p>
                        <div class="order-table">
                            <div class="table-responsive theme-scrollbar">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Ürün</th>
                                            <th>Birim Fiyat</th>
                                            <th>KDV</th>
                                            <th>Toplam</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($siparis->siparisUrun as $siparisUrun)
                                            <tr>
                                                <td>
                                                    {{ $siparisUrun->urun_baslik }}<br>
                                                    @php $varyantlar = $siparisUrun->siparisUrunVaryant; @endphp
                                                    @if (!empty($varyantlar) && count($varyantlar) > 0)
                                                        @foreach ($varyantlar as $varyant)
                                                            {{ $varyant->urun_varyant_isim }}:
                                                            {{ $varyant->urun_varyant_ozellik_isim }}<br>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    {{ formatPara($siparisUrun->tutarlar['BirimFiyat']) }} TL</td>
                                                <td class="text-end">
                                                    {{ formatPara($siparisUrun->tutarlar['KdvTutar']) }} TL</td>
                                                <td class="text-end">
                                                    {{ formatPara($siparisUrun->tutarlar['ToplamTutar']) }} TL</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if ($siparis->odeme_tip == 'havale')
                            <div class="bank-info mt-4">
                                <h4>Banka Bilgileri</h4>
                                <p><strong>Banka Adı:</strong> {{ ayar('banka') }}</p>
                                <p><strong>Hesap Sahibi:</strong> {{ ayar('bankaHesapSahibi') }}</p>
                                <p><strong>IBAN:</strong> {{ ayar('bankaIban') }}</p>
                            </div>
                        @elseif ($siparis->odeme_tip == 'kapida')
                            <div class="bank-info mt-4">
                                <h4>Kapıda Ödeme Bilgileri</h4>
                                <p>Kapıda ödeme seçeneği ile siparişiniz kapınıza kadar getirilecektir.</p>
                                <p>Kapıda ödeme ücreti {{ formatPara(ayar('kapidaOdemeTutar')) }} TL'dir.</p>
                            </div>
                        @endif

                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="summery-box">
                        <div class="sidebar-title">
                            <div class="loader-line"></div>
                            <h4>Sipariş Detayları</h4>
                        </div>
                        @php
                            $butunFiyatlar = $siparis->butun_tutarlar;
                        @endphp
                        <div class="summery-content">
                            <ul>
                                <li>
                                    <p>Ara Toplam:</p><span> {{ formatPara($butunFiyatlar['ara_toplam']) }} TL</span>
                                </li>
                                <li>
                                    <p>KDV Toplam:</p><span> {{ formatPara($butunFiyatlar['kdv_toplam']) }} TL</span>
                                </li>
                                @if ($siparis->indirim_tutar > 0)
                                    <li>
                                        <p>Kupon İndirimi:</p><span>{{ formatPara($siparis->indirim_tutar) }} TL</span>
                                    </li>
                                @endif
                                @if ($siparis->kapida_odeme_tutar > 0)
                                <li>
                                    <p>Kupon İndirimi:</p><span>{{ formatPara($siparis->kapida_odeme_tutar) }} TL</span>
                                </li>
                            @endif
                                <li class="d-none">
                                    <p>Kargo Ücreti:</p><span> {{ formatPara($siparis->kargo_tutar) }} TL</span>
                                </li>
                            </ul>
                            <div class="d-flex align-items-center justify-content-between">
                                <h6>Genel Toplam</h6>
                                <h5>{{ formatPara($siparis->butun_tutarlar['genel_toplam']) }} TL</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>







</x-layout.web>
