<x-layout.web>
    <x-slot:baslik>
        {{ ayar('siteBaslik') }} | Sipariş
    </x-slot>
    <x-slot:aciklama>
        {{ ayar('metaIcerik') }}
    </x-slot>
    <x-slot:anahtar>
        {{ ayar('metaAnahtar') }}
    </x-slot>



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
                    <div class="account-orders">
                        <div class="wrap-account-order">
                            <table>
                                <thead>
                                    <tr>

                                        <th class="fw-6">SİPARİŞ NUMARASI</th>
                                        <th class="fw-6">TARİH</th>
                                        <th class="fw-6">DURUM</th>
                                        <th class="fw-6">TOPLAM</th>
                                        <th class="fw-6"></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($siparisler as $siparis)
                                        <tr class="tf-order-item">
                                            <td>
                                                #{{ $siparis->kod }}
                                            </td>
                                            <td>
                                                {{ formatZaman($siparis->created_at) }}
                                            </td>
                                            <td>
                                                {{ $siparis->durum ? 'Ödeme Bekleniyor' : ($siparis->durum == 2 ? 'Ödeme Alındı' : ($siparis->durum == 3 ? 'Sipariş Hazırlanıyor' : ($siparis->durum == 4 ? 'Kargoya Verildi' : ($siparis->durum == 5 ? 'Teslim Edildi' : 'İptal Edildi')))) }}
                                            </td>
                                            <td>
                                                {{ formatPara($siparis->butun_tutarlar['genel_toplam']) }}
                                                TL
                                            </td>
                                            <td>
                                                <a href="{{ rota('hesabim.musteri-siparis-detay', ['kod' => $siparis->kod]) }}"
                                                    class="tf-btn btn-fill radius-4 py-2">
                                                    <span class="text">Detay</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layout.web>
