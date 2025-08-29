<x-layout.web>

    <x-slot:baslik>
        {{ ayar('siteBaslik') }} | {{ __('global.sepet') }}
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
                        <h4>Sepet</h4>
                    </div>
                    <div class="col-sm-6">
                        <ul class="breadcrumb float-end">
                            <li class="breadcrumb-item"><a href="{{rota('index')}}"> Anasayfa </a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Sepet</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-b-space pt-0">
        <div class="custom-container container">
            <div class="row g-4">

                <div class="col-xxl-9 col-xl-8">
                    <div class="cart-table">
                        <div class="table-title">
                            <h5>Sepet</h5>
                        </div>
                        <div class="table-responsive theme-scrollbar">
                            <table class="table" id="cart-table">
                                <thead>
                                <tr>
                                    <th>ÜRÜN</th>
                                    <th>FİYAT</th>
                                    <th>ADET</th>
                                    <th>TOPLAM</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>


                                @if (!empty($sepet['urunler']) && count($sepet['urunler']) > 0)
                                    @foreach ($sepet['urunler'] as $key => $sepetUrun)

                                        <tr sepet-id="{{ $sepetUrun['sepet_id'] }}">
                                            <td>
                                                <div class="cart-box">
                                                    <a href="{{ $sepetUrun['slug'] }}">
                                                        <img
                                                                src="{{ $sepetUrun['ana_resim'] }}"
                                                                alt="{{ $sepetUrun['urun_baslik'] }}">
                                                    </a>
                                                    <div>
                                                        <a href="{{ $sepetUrun['slug'] }}">
                                                            <h5> {{ $sepetUrun['urun_baslik'] }}</h5>
                                                        </a>

                                                        @foreach ($sepetUrun['varyantlar'] as $varyant)
                                                            <p>{{ $varyant['ana_varyant_isim'] }}:
                                                                <span> {{ $varyant['urun_varyant_ozellik_isim'] }} </span>
                                                            </p>

                                                        @endforeach

                                                    </div>
                                                </div>
                                            </td>
                                            <td> {{ formatPara($sepetUrun['birim_fiyat']) }} TL</td>
                                            <td>
                                                <div class="quantity">
                                                    <button class="minus" type="button"><i
                                                                class="fa-solid fa-minus"></i>
                                                    </button>
                                                    <input type="number" class="sepetUrunAdet"
                                                           value="{{ $sepetUrun['adet'] }}" min="1">
                                                    <button class="plus" type="button"><i class="fa-solid fa-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class=" sepet-toplam-sutun">   {{ formatPara($sepetUrun['birim_fiyat'] * $sepetUrun['adet']) }}
                                                TL
                                            </td>
                                            <td>
                                                <a class="deleteButton sepetten-cikar-btn" href="javascript:void(0)">
                                                    <i class="iconsax" data-icon="trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr col-span="5">
                                        <td>
                                            Sepetinizde Ürün Yok
                                        </td>
                                    </tr>
                                @endif

                                </tbody>


                            </table>
                        </div>
                    </div>
                </div>


                <div class="col-xxl-3 col-xl-4">
                    <div class="cart-items">

                        <div class="cart-body">
                            <h6>Sepet Özeti</h6>
                            <ul>
                                <li>
                                    <p> Ara Toplam </p><span class="sepetAraToplamTutar">{{ formatPara($sepet['ara_toplam']) }} TL</span>
                                </li>
                                <li>
                                    <p> Kdv Tutar </p><span class="sepetAraToplamTutar">{{ formatPara($sepet['kdv_toplam']) }} TL</span>
                                </li>
                                <li class="d-none" id="indirimTutarCnt">
                                    <p>İndirim Tutar</p><span class="sepetIndirimTutar">{{ formatPara($sepet['kupon_tutar']) }} TL</span>
                                </li>
                                <li>
                                    <p> Kargo Tutar </p><span class="sepetKargoTutar">{{ formatPara($sepet['kargo_tutar']) }} TL</span>
                                </li>

                            </ul>
                        </div>

                        <div class="cart-bottom">
                            <h6>Toplam <span> {{ formatPara($sepet['sepet_toplam']) }} TL</span></h6>
                        </div>

                        <div class="coupon-box">
                            <h6>Kupon</h6>
                            <ul>
                                <li>
                                    <span>
                                        <input type="text" laceholder="Kuponu Giriniz..." id="kupon">
                                        <i class="iconsax me-1" data-icon="tag-2"> </i>
                                    </span>
                                    <button class="btn">Uygula</button>
                                </li>
                            </ul>
                        </div>
                        <a class="btn btn_black w-100 rounded sm" href="{{rota('odeme')}}">Ödeme</a>
                    </div>
                </div>


            </div>
        </div>
    </section>


</x-layout.web>
