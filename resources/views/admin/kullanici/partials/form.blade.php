<form id="kullaniciForm" onsubmit="(return false)" class="row mb-4 layout-spacing layout-top-spacing">
    <div class="col-xxl-12">
        <div class="widget-content widget-content-area form-section">
            <div class="row mb-5">
                <div class="col-xxl-6 col-md-12 mb-4 lvvl">
                    <label for="">İsim Soyisim</label>
                    <input type="text" class="form-control input" name="isimSoyisim" id="isimSoyisim"
                        value="{{ $kullanici->isim_soyisim ?? '' }}" placeholder="İsim Soyisim">
                </div>


                <div class="col-xxl-6 col-md-12 mb-4 lvvl">
                    <label for="">Eposta</label>
                    <input type="text" class="form-control input" name="eposta" id="eposta"
                        value="{{ $kullanici->eposta ?? '' }}" placeholder="Eposta">
                </div>


                <div class="col-xxl-6 col-md-12 mb-4 lvvl">
                    <label for="">Telefon</label>
                    <input type="text" class="form-control input" name="telefon" id="telefon"
                        value="{{ $kullanici->telefon ?? '' }}" placeholder="Telefon">
                </div>


                <div class="col-xxl-6 col-md-12 mb-4 lvvl">
                    <label for="">Şifre</label>
                    <input type="text" class="form-control input" {{ !empty($kullanici) ? "duzenle='true'" : '' }}
                        name="sifre" id="sifre" placeholder="Şifre">
                </div>
            </div>
            
            <div class="mt-3">
                <div class="table-responsive">
                    <table class="table table-bordered" id="kategori-indirim-tablo">
                        <thead>
                            <tr>
                                <th scope="col">İndirim Yapılabilir Kategori</th>
                                <th scope="col">İndirim Yüzdesi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($indirimKategoriler as $indirimKategori)
                                @php
                                    $urunKategoriDilVerisi = $indirimKategori->urunKategoriDiller
                                        ->where('dil', $aktifDil)
                                        ->first();

                                    $kullaniciIndirimKontrol = !empty($kullaniciIndirimler)
                                        ? $kullaniciIndirimler->where('urun_kategori_id', $indirimKategori->id)->first()
                                        : null;

                                @endphp

                                <tr kategori-id="{{ $indirimKategori->id }}">
                                    <td> {{ $urunKategoriDilVerisi->isim }} </td>
                                    <td class="text-center">
                                        <input type="text" value="{{$kullaniciIndirimKontrol ? $kullaniciIndirimKontrol->deger : ''  }}" class="form-control indirimYuzde">
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>


            <div class="row mb-4">
                <div class="col-xxl-12 mb-4 lvvl">
                    <div class="switch form-switch-custom switch-inline form-switch-primary">
                        <input class="switch-input input" type="checkbox" role="switch" id="durum"
                            {{ !empty($kullanici) && $kullanici->durum ? 'checked' : '' }}>
                        <label class="switch-label" for="durum">Kullanıcı Durum</label>
                    </div>
                </div>
                <div class="col-xxl-12 col-sm-4 col-12 mx-auto" id="kullaniciBtnCnt">
                    <button class="btn btn-success w-100" id="kullaniciBtnSbt" type="button">
                        {{ $btnText }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>


@if (!empty($kullanici))
    <script>
        var kullaniciId = {{ $kullanici->id }};
    </script>
@endif
