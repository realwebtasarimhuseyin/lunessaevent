<form id="sayfaYonetimForm" onsubmit="(return false)" class="mb-4 layout-spacing layout-top-spacing">
    <div class="row w-100">
        <div class="col-12">
            <h3>{{ getSayfaBasligi($sayfaYonetim->slug) }}</h3>
        </div>
        @if ($sayfaYonetim->resim_izin)
            <div class="col-12">
                <div class="widget-content widget-content-area form-section">
                    <label for="sayfaYonetimResim">Görsel</label>
                    <div class="multiple-file-upload lvvl">
                        <input type="file" class="sayfaYonetimResim filepond" id="sayfaYonetimResim"
                            name="sayfaYonetimResim" />
                    </div>
                </div>
            </div>
        @endif


        <div class="col-12 mt-4">
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
                                        $dilVerisi = isset($sayfaYonetim)
                                            ? $sayfaYonetim->sayfaYonetimDiller->where('dil', $dil)->first()
                                            : null;
                                    @endphp

                                    <div class="col-xxl-12 mb-4 lvvl">
                                        <label> Başlık</label>
                                        <input type="text" class="form-control input"
                                            name="sayfaIcerikBaslik-{{ $dil }}" id="sayfaIcerikBaslik-{{ $dil }}"
                                            placeholder="Başlık" value="{{ $dilVerisi->baslik ?? '' }}">
                                    </div>

                                    <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}"
                                        id="pills-{{ $dil }}" role="tabpanel"
                                        aria-labelledby="pills-{{ $dil }}-tab" tabindex="0">
                                        <div class="widget-content widget-content-area form-section">
                                            <div class="row mb-4">
                                                <div class="col-sm-12 lvvl">
                                                    <label>İçerik</label>
                                                    <div id="sayfaYonetimIcerik-{{ $dil }}"
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
                                        $dilVerisi = isset($sayfaYonetim)
                                            ? $sayfaYonetim->sayfaYonetimDiller->where('dil', $dil)->first()
                                            : null;
                                    @endphp
                                    <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}"
                                        id="pills-{{ $dil }}" role="tabpanel"
                                        aria-labelledby="pills-{{ $dil }}-tab" tabindex="0">

                                        <div class="widget-content widget-content-area form-section mt-4">
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
                </div>
            </div>
        </div>

        <div class="col-12 mt-4">
            <div class="widget-content widget-content-area form-section">
                <div class="row">
                    <div class="col-xxl-12 mb-4 lvvl">
                        <div class="switch form-switch-custom switch-inline form-switch-primary">
                            <input class="switch-input input" type="checkbox" role="switch" id="durum"
                                {{ !isset($sayfaYonetim) || (isset($sayfaYonetim) && $sayfaYonetim->durum) ? 'checked' : '' }}>
                            <label class="switch-label" for="durum">Durum</label>
                        </div>
                    </div>

                    <div class="col-xxl-12 col-sm-4 col-12 mx-auto" id="sayfaYonetimBtnCnt">
                        <button class="btn btn-success w-100" id="sayfaYonetimBtnSbt" type="button">
                            {{ $btnText }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    var sayfaYonetimIcerik = {};
    @if ($sayfaYonetim->resim_izin && $sayfaYonetim->resim_url)
        const resimUrl = "{{ Storage::url($sayfaYonetim->resim_url) }}";
    @endif

    @if (!empty($sayfaYonetim->sayfaYonetimDiller))
        @foreach ($desteklenenDil as $dil)
            @php
                $dilVerisi = $sayfaYonetim->sayfaYonetimDiller->where('dil', $dil)->first();
            @endphp

            @if ($dilVerisi)
                sayfaYonetimIcerik['{{ $dil }}'] = {!! json_encode($dilVerisi->icerik) !!};
            @else
                sayfaYonetimIcerik['{{ $dil }}'] = "";
            @endif
        @endforeach
    @endif

    var slug = "{{ $sayfaYonetim->slug }}";
</script>
