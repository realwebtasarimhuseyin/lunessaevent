<form id="urunForm" onsubmit="(return false)" class="mb-4 layout-spacing layout-top-spacing">
    <div class="row w-100">
        <div class="col-12">

            <div class="simple-pill">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-genel-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-genel" type="button" role="tab" aria-controls="pills-genel"
                            aria-selected="true">
                            Genel
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-seo-tab" data-bs-toggle="pill" data-bs-target="#pills-seo"
                            type="button" role="tab" aria-controls="pills-seo" aria-selected="true">
                            SEO
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-resim-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-resim" type="button" role="tab" aria-controls="pills-resim"
                            aria-selected="true">
                            Resim
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-kategori-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-kategori" type="button" role="tab"
                            aria-controls="pills-kategori" aria-selected="true">
                            Kategori
                        </button>
                    </li>
                    {{--   <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-varyant-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-varyant" type="button" role="tab" aria-controls="pills-varyant"
                            aria-selected="true">
                            Varyant
                        </button>
                    </li> --}}
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-fiyat-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-fiyat" type="button" role="tab" aria-controls="pills-fiyat"
                            aria-selected="true">
                            Fiyat
                        </button>
                    </li>
                    {{--  <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-stok-tab" data-bs-toggle="pill" data-bs-target="#pills-stok"
                            type="button" role="tab" aria-controls="pills-stok" aria-selected="true">
                            Stok
                        </button>
                    </li> --}}
                    {{--  <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-vitrin-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-vitrin" type="button" role="tab" aria-controls="pills-vitrin"
                            aria-selected="true">
                            Vitrin
                        </button>
                    </li> --}}
                    {{-- <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-marka-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-marka" type="button" role="tab" aria-controls="pills-marka"
                            aria-selected="true">
                            Marka
                        </button>
                    </li> --}}
                </ul>
                <div class="tab-content" id="pills-tabContent">

                    <div class="tab-pane fade show active" id="pills-genel" role="tabpanel"
                        aria-labelledby="pills-genel-tab" tabindex="0">

                        <div class="simple-pill">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                @foreach ($desteklenenDil as $dil)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link{{ $loop->first ? ' active' : '' }}"
                                            id="pills-{{ $dil }}-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-{{ $dil }}" type="button" role="tab"
                                            aria-controls="pills-{{ $dil }}" aria-selected="true">
                                            <img src="{{ Vite::asset("resources/images/1x1/$dil.svg") }}"
                                                class="rounded-circle w-1-5rem" alt="flag">
                                            {{ $tamDil($dil) }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                @foreach ($desteklenenDil as $dil)
                                    @php
                                        $dilVerisi = isset($urun)
                                            ? $urun->urunDiller->where('dil', $dil)->first()
                                            : null;
                                    @endphp
                                    <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}"
                                        id="pills-{{ $dil }}" role="tabpanel"
                                        aria-labelledby="pills-{{ $dil }}-tab" tabindex="0">
                                        <div class="widget-content widget-content-area form-section">
                                            <div class="row mb-4">
                                                <div class="col-sm-12 lvvl">
                                                    <label>Başlık</label>
                                                    <input type="text" class="form-control input"
                                                        name="baslik-{{ $dil }}"
                                                        id="baslik-{{ $dil }}" placeholder="Başlık"
                                                        value="{{ $dilVerisi->baslik ?? '' }}">
                                                </div>
                                            </div>

                                            <div class="row mb-4">
                                                <div class="col-sm-12 lvvl">
                                                    <label>Açıklama</label>
                                                    <div id="urunIcerik-{{ $dil }}"
                                                        name="icerik-{{ $dil }}" class="input"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-seo" role="tabpanel" aria-labelledby="pills-seo-tab"
                        tabindex="0">
                        <div class="simple-pill">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                @foreach ($desteklenenDil as $dil)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link{{ $loop->first ? ' active' : '' }}"
                                            id="pills-{{ $dil }}-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-{{ $dil }}" type="button"
                                            role="tab" aria-controls="pills-{{ $dil }}"
                                            aria-selected="true">
                                            <img src="{{ Vite::asset("resources/images/1x1/$dil.svg") }}"
                                                class="rounded-circle w-1-5rem" alt="flag">
                                            {{ $tamDil($dil) }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                @foreach ($desteklenenDil as $dil)
                                    @php
                                        $dilVerisi = isset($urun)
                                            ? $urun->urunDiller->where('dil', $dil)->first()
                                            : null;
                                    @endphp
                                    <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}"
                                        id="pills-{{ $dil }}" role="tabpanel"
                                        aria-labelledby="pills-{{ $dil }}-tab" tabindex="0">
                                        <div class="widget-content widget-content-area form-section my-4">
                                            <h5 class="mb-4">SEO Ayarları</h5>
                                            <div class="row mb-4">
                                                <div class="col-xxl-12 mb-4 lvvl">
                                                    <label>Meta Başlık</label>
                                                    <input type="text" class="form-control input"
                                                        name="metaBaslik-{{ $dil }}"
                                                        id="metaBaslik-{{ $dil }}" placeholder="Meta Başlık"
                                                        value="{{ $dilVerisi->meta_baslik ?? '' }}">
                                                </div>
                                                <div class="col-xxl-12 mb-4 lvvl">
                                                    <label>Meta Anahtar</label>
                                                    <input type="text" class="form-control input"
                                                        name="metaAnahtar-{{ $dil }}"
                                                        id="metaAnahtar-{{ $dil }}"
                                                        placeholder="Meta Anahtar"
                                                        value="{{ $dilVerisi->meta_anahtar ?? '' }}">
                                                </div>
                                                <div class="col-xxl-12 lvvl">
                                                    <label for="metaIcerik">Meta Açıklama</label>
                                                    <textarea class="form-control input" name="metaIcerik-{{ $dil }}" id="metaIcerik-{{ $dil }}"
                                                        cols="10" rows="5">{{ $dilVerisi->meta_icerik ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-resim" role="tabpanel" aria-labelledby="pills-resim-tab"
                        tabindex="0">
                        <div class="widget-content widget-content-area form-section my-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="anaResim">Ana Görsel</label>
                                    <div class="multiple-file-upload lvvl">
                                        <input type="file" class="anaResim filepond" id="anaResim"
                                            name="anaResim" />
                                    </div>
                                </div>
                              <div class="col-md-6">
                                    <label for="normalResimler">Görseller</label>
                                    <div class="multiple-file-upload lvvl">
                                        <input type="file" class="normalResimler filepond" id="normalResimler"
                                            name="normalResimler" />
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-kategori" role="tabpanel"
                        aria-labelledby="pills-kategori-tab" tabindex="0">
                        <div class="widget-content widget-content-area form-section mb-4">
                            <h4 class="mb-4">Kategori</h4>
                            <div class="row">
                                <div class="col-12 lvvl mb-4">
                                    <label>Kategori</label>
                                    <select class="form-select input" name="urunKategori" id="urunKategori">
                                        {{-- <option value="" disabled selected>Ürün Kategori Seç</option> --}}
                                        <option value="1" selected>Ürün Kategori Seç</option>
                                        @foreach ($kategoriler as $kategori)
                                            <option value="{{ $kategori->id }}"
                                                {{ isset($urun) && $urun->urun_kategori_id == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->isim }}</option>
                                        @endforeach
                                    </select>
                                </div>

                           <div class="col-12 lvvl ">
                                    <label>Alt Kategori</label>
                                    <select class="form-select input" name="urunAltKategori" id="urunAltKategori">
                                        <option value="" disabled selected>Ürün Alt Kategori Seç</option>
                                       
                                        @isset($urun)
                                            @php
                                                $urunAltKategoriler = App\Models\UrunAltKategori::where(
                                                    'urun_kategori_id',
                                                    $urun->urun_kategori_id,
                                                )->get();
                                            @endphp
                                            @foreach ($urunAltKategoriler as $urunAltKategori)
                                                <option value="{{ $urunAltKategori->id }}"
                                                    {{ !empty($urun->urun_alt_kategori_id) && $urun->urun_alt_kategori_id == $urunAltKategori->id ? 'selected' : '' }}>

                                                    {{ $urunAltKategori->urunAltKategoriDiller->where('dil', 'tr')->first()->isim }}

                                                </option>
                                            @endforeach
                                        @endisset

                                    </select>
                                </div> 
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-varyant" role="tabpanel"
                        aria-labelledby="pills-varyant-tab" tabindex="0">

                        <div class="widget-content widget-content-area form-section mb-4">

                            <h4>Ürün Varyant Kombinasyonları</h4>
                            <p>Kullanılacak Varyantları Seç</p>
                            <div id="varyant-secim">
                                @foreach ($varyantlar as $varyant => $deger)
                                    <div class="form-check form-check-primary form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                            onchange="guncelleSecilenVaryantlar()"
                                            id="varyant-secim-{{ $deger['id'] }}" value="{{ $varyant }}"
                                            @if (!empty($seciliVaryantIdler) && in_array($deger['id'], $seciliVaryantIdler)) checked @endif>
                                        <label class="form-check-label" for="varyant-secim-{{ $deger['id'] }}">
                                            {{ $varyant }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <br>

                            <h4>Kombinasyonlar</h4>
                            <div class="mb-3">
                                <button onclick="satirEkle()" id="kombinasyon-ekle" class="btn btn-warning"
                                    type="button">
                                    Yeni Kombinasyon Ekle
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="varyant-kombinasyon-tablo">
                                    <thead>
                                        <tr>
                                            <th style="width: 30%;">Varyantlar</th>
                                            <th style="width: 20%;">Fiyat</th>
                                            <th style="width: 20%;">Stok Kodu</th>
                                            <th style="width: 15%;">Stok Adeti</th>
                                            <th style="width: 15%;">İşlem</th>
                                        </tr>
                                    </thead>
                                    <tbody id="kombinasyon-tablo-body">
                                        @if (!empty($kombinasyonlar) && count($kombinasyonlar) > 0)
                                            @foreach ($kombinasyonlar as $kombinasyon)
                                                <tr class="kombinasyon-satiri" draggable="true">
                                                    <td>
                                                        <div class="varyant-grup-container">
                                                            @foreach ($seciliVaryantIdler as $varyantId)
                                                                @php
                                                                    $urunVaryant = App\Models\UrunVaryant::find(
                                                                        $varyantId,
                                                                    );
                                                                    $varyantDilVerisi = $urunVaryant
                                                                        ?->urunVaryantDiller()
                                                                        ->where('dil', 'tr')
                                                                        ->first();
                                                                    $urunVaryantOzellikler =
                                                                        $urunVaryant?->urunVaryantOzellik ?? [];
                                                                @endphp

                                                                @if ($urunVaryant && $varyantDilVerisi)
                                                                    <div class="varyant-grup">
                                                                        <label>{{ $varyantDilVerisi->isim }}</label>
                                                                        <select
                                                                            data-varyant="{{ $varyantDilVerisi->isim }}"
                                                                            class="form-select">
                                                                            @foreach ($urunVaryantOzellikler as $urunVaryantOzellik)
                                                                                @php
                                                                                    $varyantOzellikDil = $urunVaryantOzellik->urunVaryantOzellikDiller
                                                                                        ->where('dil', 'tr')
                                                                                        ->first();
                                                                                @endphp

                                                                                @if ($varyantOzellikDil)
                                                                                    <option
                                                                                        value="{{ $urunVaryantOzellik->id }}"
                                                                                        {{ in_array($urunVaryantOzellik->id, $kombinasyon->urun_varyantlar ?? []) ? 'selected' : '' }}>
                                                                                        {{ $varyantOzellikDil->isim }}
                                                                                    </option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <input type="text" placeholder="Fiyat"
                                                            value="{{ isset($kombinasyon->birim_fiyat) ? str_replace('.', ',', $kombinasyon->birim_fiyat) : '' }}"
                                                            class="fiyat-input form-control masked-input-sayi">
                                                    </td>

                                                    <td>
                                                        <input type="text" placeholder="Stok Kodu"
                                                            value="{{ $kombinasyon->stok_kod }}"
                                                            class="stok-kodu-input form-control">
                                                    </td>
                                                    <td>
                                                        <input type="text" placeholder="Stok Adeti"
                                                            value="{{ $kombinasyon->stok_adet }}"
                                                            class="stok-adeti-input form-control masked-input-sayi">
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-danger">Sil</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif



                                    </tbody>
                                </table>
                            </div>

                            <style>
                                #varyant-kombinasyon-tablo input {
                                    min-width: 150px;
                                }

                                #varyant-kombinasyon-tablo select {
                                    min-width: max-content;
                                }

                                .varyant-grup-container {
                                    display: flex;
                                    flex-direction: row;
                                    flex-wrap: wrap;
                                    gap: .2rem
                                }

                                .varyant-grup {
                                    margin-bottom: 10px;
                                    display: flex;
                                    flex-direction: column;
                                }
                            </style>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-stok" role="tabpanel" aria-labelledby="pills-stok-tab"
                        tabindex="0">
                        <div class="widget-content widget-content-area form-section mb-4">
                            <h5 class="mb-4">Stok Bilgileri</h5>
                            <div class="row">
                                <div class="col-md-6 lvvl">
                                    <label>Stok (Adet)</label>
                                    <input type="text" class="form-control input masked-input-sayi" min="0"
                                        name="stokAdet" id="stokAdet" placeholder="Stok (Adet)" value="0">
                                </div>
                                <div class="col-md-6 lvvl">
                                    <label>Stok Kod (SKU)</label>
                                    <input type="text" class="form-control input " min="0" name="stokKod"
                                        id="stokKod" placeholder="Stok Kod (SKU)" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-fiyat" role="tabpanel" aria-labelledby="pills-fiyat-tab"
                        tabindex="0">
                        <div class="widget-content widget-content-area form-section">
                            <h5 class="mb-4">Fiyat Bilgileri</h5>
                            <div class="row">

                                <select hidden class="form-select input" name="kdvDurum" id="kdvDurum">
                                    <option value="0"
                                        {{ isset($urun) && $urun->kdv_durum == 0 ? 'selected' : '' }}>
                                        Hariç
                                    </option>

                                    <option value="1"
                                        {{ isset($urun) && $urun->kdv_durum == 1 ? 'selected' : '' }}>
                                        Dahil
                                    </option>
                                </select>

                                <div class="col-12 lvvl mb-4">
                                    <label>Birim Fiyat</label>
                                    <input type="text" class="form-control input masked-input-sayi" min="0"
                                        name="birimFiyat" id="birimFiyat" placeholder="Birim Fiyat" value="0">
                                </div>

                                <select class="form-select input" hidden name="kdvOran" id="kdvOran">
                                    <option value="0" selected>
                                        0
                                    </option>
                                    @foreach ($kdvler as $kdv)
                                        <option value="{{ $kdv->id }}"
                                            {{ isset($urun) && $urun->kdv_id == $kdv->id ? 'selected' : '' }}>
                                            {{ $kdv->baslik }}
                                        </option>
                                    @endforeach
                                </select>

                                <input type="text" hidden class="form-control input masked-input-indirim"
                                    min="0" name="indirimYuzde" id="indirimYuzde"
                                    placeholder="İndirim (Yüzde)" value="0">

                                <input type="text" hidden class="form-control input masked-input-sayi"
                                    min="0" name="indirimTutar" id="indirimTutar"
                                    placeholder="İndirim (Tutar)" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-vitrin" role="tabpanel" aria-labelledby="pills-vitrin-tab"
                        tabindex="0">
                        <div class="widget-content widget-content-area form-section mb-4">
                            <h5 class="mb-4">Vitrin</h5>
                            <div class="row">
                                <div class="col-12 lvvl mb-2">
                                    <div class="switch form-switch-custom switch-inline form-switch-primary">
                                        <input class="switch-input input" type="checkbox" role="switch"
                                            id="ozelAlan1" {{ isset($urun) && $urun->ozel_alan_1 ? 'checked' : '' }}>
                                        <label class="switch-label" for="ozelAlan1">Öne Çıkan</label>
                                    </div>
                                </div>

                                <div class="col-12 lvvl">
                                    <div class="switch form-switch-custom switch-inline form-switch-primary">
                                        <input class="switch-input input" type="checkbox" role="switch"
                                            id="ozelAlan2" {{ isset($urun) && $urun->ozel_alan_2 ? 'checked' : '' }}>
                                        <label class="switch-label" for="ozelAlan2">Yeni Gelen</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="tab-pane fade" id="pills-marka" role="tabpanel" aria-labelledby="pills-marka-tab"
                        tabindex="0">
                        <div class="widget-content widget-content-area form-section mb-4">
                            <h5 class="mb-4">Marka Bilgileri</h5>
                            <div class="row">
                                <div class="col-12 lvvl mb-4">
                                    <label>Markalar</label>
                                    <select class="form-select input" name="marka" id="marka">
                                        <option disabled selected value="">Marka Seç</option>
                                        @foreach ($markalar as $marka)
                                            <option value="{{ $marka->id }}"
                                                {{ isset($urun) && $urun->marka_id == $marka->id ? 'selected' : '' }}>
                                                {{ $marka->isim }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="col-12 mt-4">
            <div class="widget-content widget-content-area form-section mt-4">
                <div class="col-12 mb-4 lvvl">
                    <div class="switch form-switch-custom switch-inline form-switch-primary">
                        <input class="switch-input input" type="checkbox" role="switch" id="durum"
                            {{ !isset($urun) || (isset($urun) && $urun->durum) ? 'checked' : '' }}>
                        <label class="switch-label" for="durum">Durum</label>
                    </div>
                </div>

                <div class="col-xxl-12 col-sm-4 col-12 mx-auto" id="urunBtnCnt">
                    <button class="btn btn-success w-100" id="urunBtnSbt" type="button">
                        {{ $btnText }}
                    </button>
                </div>
            </div>
        </div>

    </div>
</form>

<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: left;
    }

    tr.dragging {
        opacity: 0.5;
        background-color: #f0f0f0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        transform: scale(1.02);
    }

    tr.placeholder {
        background-color: #e0e0e0;
        border: 2px dashed #999;
    }
</style>


<script>
    const varyantlar = @json($varyantlar);

    let secilenVaryantlar = [];

    function guncelleSecilenVaryantlar() {
        secilenVaryantlar = $('#varyant-secim input:checked').map((_, cb) => cb.value).get();
        satirlariGuncelle();
    }

    function satirEkle() {
        if (secilenVaryantlar.length === 0) {
            return alert("Lütfen önce kullanılacak varyantları seçin!");
        }

        const tbody = $('#kombinasyon-tablo-body');
        const satir = $('<tr>', {
            draggable: 'true',
            class: 'kombinasyon-satiri'
        });

        const varyantHucresi = $('<td>');
        const varyantGrup = $('<div>', {
            class: 'varyant-grup-container'
        });

        $.each(secilenVaryantlar, (_, varyant) => {
            const grupDiv = $('<div>', {
                class: 'varyant-grup'
            });

            const label = $('<label>').text(`${varyant}`);

            const select = $('<select>', {
                'data-varyant': varyant,
                'class': 'form-select'
            }).html(
                varyantlar[varyant].ozellikler.map(opt =>
                    `<option value="${opt.id}">${opt.isim}</option>`)
                .join('')
            );

            grupDiv.append(label).append(select);
            varyantGrup.append(grupDiv);
        });

        varyantHucresi.append(varyantGrup);
        satir.append(varyantHucresi);

        satir.append(inputHucresiOlustur('text', 'Fiyat', 'fiyat-input form-control masked-input-sayi'));
        satir.append(inputHucresiOlustur('text', 'Stok Kodu', 'stok-kodu-input form-control'));
        satir.append(inputHucresiOlustur('text', 'Stok Adeti', 'stok-adeti-input form-control masked-input-sayi'));

        const silBtn = $('<button>', {
            'class': 'btn btn-danger'
        }).text('Sil').on('click', () => satir.remove());
        satir.append($('<td>').append(silBtn));

        tbody.append(satir);
    }


    function inputHucresiOlustur(tip, yerTutucu, sinifAdi) {
        return $('<td>').append(
            $('<input>', {
                type: tip,
                placeholder: yerTutucu,
                class: sinifAdi
            })
        );
    }

    function satirlariGuncelle() {
        $('.kombinasyon-satiri').each(function() {
            const satir = $(this);
            const mevcutVaryantlar = satir.find('select').map((_, select) => $(select).data(
                'varyant')).get();

            mevcutVaryantlar.forEach(varyant => {
                if (!secilenVaryantlar.includes(varyant)) {
                    satir.find(`[data-varyant='${varyant}']`).parent().remove();
                }
            });

            secilenVaryantlar.forEach(varyant => {
                if (!mevcutVaryantlar.includes(varyant)) {
                    const grupDiv = $('<div>', {
                        class: 'varyant-grup'
                    });
                    const label = $('<label>').text(`${varyant}`);
                    const select = $('<select>', {
                        'data-varyant': varyant,
                        'class': 'form-select'
                    }).html(
                        varyantlar[varyant].ozellikler.map(opt =>
                            `<option value="${opt.id}">${opt.isim}</option>`).join('')
                    );

                    grupDiv.append(label).append(select);
                    satir.children().first().find('.varyant-grup-container').append(
                        grupDiv); // Add to grid container
                }
            });
        });
    }

    function kombinasyonlariKaydet() {
        const kombinasyonlar = $('.kombinasyon-satiri').map(function() {
            const satir = $(this);
            const kombinasyon = {
                varyantlar: {}
            };

            satir.find('select').each(function() {
                const select = $(this);
                const varyantAdi = select.data('varyant');
                kombinasyon.varyantlar[varyantAdi] = {
                    id: select.val(),
                    isim: select.find('option:selected').text()
                };
            });

            kombinasyon.fiyat = satir.find('.fiyat-input').val();
            kombinasyon.stokKodu = satir.find('.stok-kodu-input').val();
            kombinasyon.stokAdeti = satir.find('.stok-adeti-input').val();

            return kombinasyon;
        }).get();

        console.log(kombinasyonlar);
    }


    const table = document.getElementById("varyant-kombinasyon-tablo");
    let dragSrcRow = null;

    table.addEventListener("dragstart", (e) => {
        dragSrcRow = e.target;
        e.dataTransfer.effectAllowed = "move";
        e.target.classList.add("dragging");
    });

    table.addEventListener("dragover", (e) => {
        e.preventDefault();
        const targetRow = e.target.closest("tr");
        if (targetRow && targetRow !== dragSrcRow) {
            const boundingRect = targetRow.getBoundingClientRect();
            const offset = e.clientY - boundingRect.top;
            if (offset > boundingRect.height / 2) {
                targetRow.after(dragSrcRow);
            } else {
                targetRow.before(dragSrcRow);
            }
        }
    });

    table.addEventListener("dragend", () => {
        dragSrcRow.classList.remove("dragging");
        /*  updateRowNumbers(); */
    });

    function updateRowNumbers() {
        const rows = table.querySelectorAll("tr");
        rows.forEach((row, index) => {
            row.cells[0].textContent = index + 1;
        });
    }
</script>



@isset($urun)
    <script>
        const urunId = {{ $urun->id }};
        const urunIcerik = {};

        @if (
            !empty($urun->urunResimler->where('tip', 1)->first()) &&
                !empty($urun->urunResimler->where('tip', 1)->first()->resim_url))
            const anaResimUrl =
                "{{ $urun->urunResimler->where('tip', 1)->first() ? Storage::url($urun->urunResimler->where('tip', 1)->first()->resim_url) : '' }}";
        @endif


        const normalResimlerUrl = {!! json_encode(
            $urun->urunResimler()->where('tip', 2)->orderByDesc('id')->pluck('resim_url')->map(fn($url) => Storage::url($url))->toArray(),
        ) !!};



        @foreach ($desteklenenDil as $dil)
            @php
                $dilVerisi = $urun->urunDiller->where('dil', $dil)->first();
            @endphp

            @if ($dilVerisi)
                urunIcerik['{{ $dil }}'] = {!! json_encode($dilVerisi->icerik) !!};
            @else
                urunIcerik['{{ $dil }}'] = "";
            @endif
        @endforeach
    </script>
@endisset
