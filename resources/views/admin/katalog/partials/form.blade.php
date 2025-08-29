<form id="katalogForm" onsubmit="(return false)" class="mb-4 layout-spacing layout-top-spacing">
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
                        <button class="nav-link" id="pills-resim-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-resim" type="button" role="tab" aria-controls="pills-resim"
                            aria-selected="true">
                            Resim
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-dosya-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-dosya" type="button" role="tab" aria-controls="pills-dosya"
                            aria-selected="true">
                            Dosya
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
                                        $dilVerisi = isset($katalog)
                                            ? $katalog->katalogDiller->where('dil', $dil)->first()
                                            : null;
                                    @endphp
                                    <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}"
                                        id="pills-{{ $dil }}" role="tabpanel"
                                        aria-labelledby="pills-{{ $dil }}-tab" tabindex="0">
                                        <div class="widget-content widget-content-area form-section mb-4">
                                            <div class="row mb-4">
                                                <div class="col-sm-12 lvvl">
                                                    <label>Başlık</label>
                                                    <input type="text" class="form-control input"
                                                        name="baslik-{{ $dil }}"
                                                        id="baslik-{{ $dil }}" placeholder="Başlık"
                                                        value="{{ $dilVerisi->baslik ?? '' }}">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- <div class="widget-content widget-content-area form-section">
                            <div class="row">
                                <div class="col-12 mb-4 lvvl">
                                    <label>Kategori</label>
                                    <select class="form-control input" name="katalogKategori" id="katalogKategori">
                                        <option value="" disabled
                                            {{ isset($katalog) && !empty($katalog->katalog_kategori_id) ? '' : 'selected' }}>
                                            Kategori Seç
                                        </option>
                                        @foreach ($katalogKategoriler as $katalogKategori)
                                            @php
                                                $katalogKategoriDilVerisi = $katalogKategori->katalogKategoriDiller
                                                    ->where('dil', $aktifDil)
                                                    ->first();
                                            @endphp
                                            @if ($katalogKategoriDilVerisi)
                                                <option value="{{ $katalogKategori->id }}"
                                                    {{ isset($katalog) && $katalog->katalog_kategori_id == $katalogKategori->id ? 'selected' : '' }}>
                                                    {{ $katalogKategoriDilVerisi->isim }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div> --}}

                    </div>

                    <div class="tab-pane fade " id="pills-resim" role="tabpanel" aria-labelledby="pills-resim-tab"
                        tabindex="0">
                        <div class="row">
                            <div class="col-12">
                                <div class="widget-content widget-content-area form-section mb-4">
                                    <label for="anaResim">Görsel</label>
                                    <div class="multiple-file-upload lvvl">
                                        <input type="file" class="anaResim filepond" id="anaResim"
                                            name="anaResim" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="pills-dosya" role="tabpanel" aria-labelledby="pills-dosya-tab"
                        tabindex="0">
                        <div class="row">
                            <div class="col-12">
                                <div class="widget-content widget-content-area form-section mb-4">
                                    <label for="katalogDosya">Dosya</label>
                                    <div class="multiple-file-upload lvvl">
                                        <input type="file" class="katalogDosya filepond" id="katalogDosya"
                                            name="katalogDosya" />
                                    </div>
                                </div>
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
                        {{ !isset($katalog) || (isset($katalog) && $katalog->durum) ? 'checked' : '' }}>
                    <label class="switch-label" for="durum">Durum</label>
                </div>
            </div>

            <div class="col-xxl-12 col-sm-4 col-12 mx-auto" id="katalogBtnCnt">
                <button class="btn btn-success w-100" id="katalogBtnSbt" type="button">
                    {{ $btnText }}
                </button>
            </div>
        </div>
    </div>
</form>


@isset($katalog)
    <script>
        const katalogId = {{ $katalog->id }};

        const anaResimUrl = "{{ depolamaUrl($katalog) }}";
        const katalogDosyaUrl = "{{ Storage::url($katalog->dosya_url) }}";
    </script>
@endisset
