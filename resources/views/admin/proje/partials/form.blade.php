<form id="projeForm" onsubmit="(return false)" class="mb-4 layout-spacing layout-top-spacing">
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
                    {{-- <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-diger-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-diger" type="button" role="tab" aria-controls="pills-diger"
                            aria-selected="true">
                            Diğer
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
                                        $dilVerisi = isset($proje)
                                            ? $proje->projeDiller->where('dil', $dil)->first()
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
                                                    <label>İçerik</label>
                                                    <div id="projeIcerik-{{ $dil }}"
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
                                        $dilVerisi = isset($proje)
                                            ? $proje->projeDiller->where('dil', $dil)->first()
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


                    <div class="tab-pane fade " id="pills-resim" role="tabpanel" aria-labelledby="pills-resim-tab"
                        tabindex="0">

                        <div class="row">
                            <div class="col-6">
                                <div class="widget-content widget-content-area form-section mb-4">
                                    <label for="anaResim">Ana Görsel</label>
                                    <div class="multiple-file-upload lvvl">
                                        <input type="file" class="anaResim filepond" id="anaResim"
                                            name="anaResim" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="widget-content widget-content-area form-section mb-4">
                                    <label for="normalResimler">Görseller</label>
                                    <div class="multiple-file-upload lvvl">
                                        <input type="file" class="normalResimler filepond" id="normalResimler"
                                            name="normalResimler" />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="tab-pane fade " id="pills-diger" role="tabpanel" aria-labelledby="pills-diger-tab"
                        tabindex="0">

                        <div class="widget-content widget-content-area form-section">
                            <div class="col-12 mb-4 lvvl">
                                <label>Kategori</label>
                                <select class="form-control input" name="projeKategori" id="projeKategori">
                                    <option value="" disabled
                                        {{ isset($proje) && !empty($proje->proje_kategori_id) ? '' : 'selected' }}>
                                        Kategori Seç
                                    </option>
                                    @foreach ($projeKategoriler as $projeKategori)
                                        @php
                                            $projeKategoriDilVerisi = $projeKategori->projeKategoriDiller
                                                ->where('dil', $aktifDil)
                                                ->first();
                                        @endphp
                                        @if ($projeKategoriDilVerisi)
                                            <option value="{{ $projeKategori->id }}"
                                                {{ isset($proje) && $proje->proje_kategori_id == $projeKategori->id ? 'selected' : '' }}>
                                                {{ $projeKategoriDilVerisi->isim }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 mb-4 lvvl ilContainer">
                                <label>İl</label>
                                <select class="form-control input" name="il" id="il">
                                    <option value="" disabled {{ isset($proje) ? '' : 'selected' }}>İl Seç
                                    </option>
                                    @foreach ($iller as $il)
                                        <option value="{{ $il->id }}"
                                            {{ isset($proje) && $proje->il_id == $il->id ? 'selected' : '' }}>
                                            {{ $il->il_isim }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 mb-4 lvvl">
                                <label>Tarih</label>
                                <input type="text" class="form-control input" name="tarih" id="tarih"
                                    placeholder="Tarih" value="{{ $proje->tarih ?? '' }}" />
                            </div>

                            <div class="col-12 mb-4 lvvl">
                                <label>Tür</label>
                                <input type="text" class="form-control input" name="tur" id="tur"
                                    placeholder="Tür" value="{{ $proje->tur ?? '' }}" />
                            </div>

                            <div class="col-12 mb-4 lvvl">
                                <label>Alan</label>
                                <input type="text" class="form-control input" name="alan" id="alan"
                                    placeholder="Alan" value="{{ $proje->alan ?? '' }}" />
                            </div>


                            <div class="col-12 mb-4 lvvl">
                                <label>Aşama</label>
                                <select class="form-control input" name="asama" id="asama">
                                    <option value="" disabled {{ isset($proje) ? '' : 'selected' }}>Aşama Seç
                                    </option>

                                    <option value="1"
                                        {{ isset($proje) && $proje->asama == 1 ? 'selected' : '' }}>Devam
                                        Ediyor</option>
                                    <option value="2"
                                        {{ isset($proje) && $proje->asama == 2 ? 'selected' : '' }}>Tamamlandı
                                    </option>

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 mt-4">
        <div class="widget-content widget-content-area form-section">

            <div class="col-12 mb-4 lvvl">
                <div class="switch form-switch-custom switch-inline form-switch-primary">
                    <input class="switch-input input" type="checkbox" role="switch" id="durum"
                        {{ !isset($proje) || (isset($proje) && $proje->durum) ? 'checked' : '' }}>
                    <label class="switch-label" for="durum">Durum</label>
                </div>
            </div>

            <div class="col-xxl-12 col-sm-4 col-12 mx-auto" id="projeBtnCnt">
                <button class="btn btn-success w-100" id="projeBtnSbt" type="button">
                    {{ $btnText }}
                </button>
            </div>
        </div>
    </div>
</form>


@isset($proje)
    <script>
        const projeId = {{ $proje->id }};
        const projeIcerik = {};

        @if ($proje->projeResimler->where('tip', 1)->first())
            const anaResimUrl =
                "{{ depolamaUrl($proje->projeResimler->where('tip', 1)->first()) }}";
        @endif


        const normalResimlerUrl = {!! json_encode(
            $proje->projeResimler->where('tip', 2)->sortByDesc('id')->pluck('resim_url')->map(fn($url) => Storage::url($url))->toArray(),
        ) !!};


        @foreach ($desteklenenDil as $dil)
            @php
                $dilVerisi = $proje->projeDiller->where('dil', $dil)->first();
            @endphp
            @if ($dilVerisi)
                projeIcerik['{{ $dil }}'] = {!! json_encode($dilVerisi->icerik) !!};
            @else
                projeIcerik['{{ $dil }}'] = "";
            @endif
        @endforeach
    </script>
@endisset
