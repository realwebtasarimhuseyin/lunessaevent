<form id="galeriForm" onsubmit="(return false)" class="row mb-4 layout-spacing layout-top-spacing">
    <div class="col-xxl-12">
        <div class="widget-content widget-content-area form-section">
            <div class="row mb-4">
                <div class="col-xxl-12 col-md-12 mb-4">
                    <label for="product-images">Galeri</label>
                    <div class="multiple-file-upload lvvl">
                        <input type="file" class="galeriDosya filepond" id="galeriDosya" name="galeriDosya" />
                    </div>
                </div>
            </div>
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
                            $dilVerisi = isset($galeri) ? $galeri->galeriDiller->where('dil', $dil)->first() : null;
                        @endphp
                        <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}"
                            id="pills-{{ $dil }}" role="tabpanel"
                            aria-labelledby="pills-{{ $dil }}-tab" tabindex="0">
                            <div class="row mb-4">
                                <div class="col-xxl-12 lvvl">
                                    <label for="baslik">Galeri Başlık</label>
                                    <input type="text" class="form-control input" name="baslik-{{ $dil }}"
                                        id="baslik-{{ $dil }}" placeholder="Galeri Başlık"
                                        value="{{ $dilVerisi->baslik ?? '' }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-xxl-12 mb-4 lvvl">
                    <div class="switch form-switch-custom switch-inline form-switch-primary">
                        <input class="switch-input input" type="checkbox" role="switch" id="durum"
                            {{ !isset($galeri) || (isset($galeri) && $galeri->durum) ? 'checked' : '' }}>
                        <label class="switch-label" for="durum">Galeri Durum</label>
                    </div>
                </div>
                <div class="col-xxl-12 col-sm-4 col-12 mx-auto" id="galeriBtnCnt">
                    <button class="btn btn-success w-100" id="galeriBtnSbt" type="button">
                        {{ $btnText }}
                    </button>
                </div>
            </div>

        </div>
    </div>
</form>


@isset($galeri)
    <script>
        const galeriId = {{ $galeri->id }};
        @if ($galeri->resim_url)
            const dosyaUrl = "{{ Storage::url($galeri->resim_url) }}";
        @elseif ($galeri->video_url)
            const dosyaUrl = "{{ Storage::url($galeri->video_url) }}";
        @endif
    </script>
@endisset
