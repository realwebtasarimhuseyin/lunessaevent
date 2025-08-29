<form id="projeKategoriForm" onsubmit="(return false)" class="mb-4 layout-spacing layout-top-spacing">

    <div class="row w-100">
        <div class="col-12">
            <div class="widget-content widget-content-area form-section mb-4">
                <label for="kategoriResim">Kategori Görsel</label>
                <div class="multiple-file-upload lvvl">
                    <input type="file" class="kategoriResim filepond" id="kategoriResim" name="kategoriResim" />
                </div>
            </div>
        </div>

        <div class="col-12">
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
                            $dilVerisi = isset($projeKategori)
                                ? $projeKategori->projeKategoriDiller->where('dil', $dil)->first()
                                : null;
                        @endphp
                        <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}"
                            id="pills-{{ $dil }}" role="tabpanel"
                            aria-labelledby="pills-{{ $dil }}-tab" tabindex="0">
                            <div class="widget-content widget-content-area form-section">
                                <div class="row">
                                    <div class="col-sm-12 lvvl">
                                        <label>Kategori</label>
                                        <input type="text" class="form-control input" name="isim-{{ $dil }}"
                                            id="isim-{{ $dil }}" placeholder="Kategori İsim"
                                            value="{{ $dilVerisi->isim ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-12 mt-4">
            <div class="widget-content widget-content-area form-section">
                <div class="row">
                    <div class="col-auto mb-4 lvvl">
                        <div class="switch form-switch-custom switch-inline form-switch-primary">
                            <input class="switch-input input" type="checkbox" role="switch" id="durum"
                                {{ !isset($projeKategori) || (isset($projeKategori) && $projeKategori->durum) ? 'checked' : '' }}>
                            <label class="switch-label" for="durum">Kategori Durum</label>
                        </div>
                    </div>
                    <div class="col-xxl-12 col-sm-4 col-12 mx-auto" id="projeKategoriBtnCnt">
                        <button class="btn btn-success w-100" id="projeKategoriBtnSbt" type="button">
                            {{ $btnText }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


@isset($projeKategori)
    <script>
        const projeKategoriId = {{ $projeKategori->id }};
        @if ($projeKategori->resim_url)
            const projeKategoriResimUrl = "{{ Storage::url($projeKategori->resim_url) }}";
        @endif
    </script>
@endisset
