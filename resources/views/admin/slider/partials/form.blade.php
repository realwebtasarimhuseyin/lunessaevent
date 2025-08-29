<form id="sliderForm" onsubmit="return false;" class="row mb-4 layout-spacing layout-top-spacing">
    <div class="col-xxl-12">
        <div class="widget-content widget-content-area form-section">

            <div class="row mb-4">
                <div class="col-xxl-12 col-md-12 mb-4">
                    <label for="sliderDosya">Slider (Resim yada Video)</label>
                    <div class="multiple-file-upload lvvl">
                        <input type="file" class="sliderDosya filepond" id="sliderDosya" name="sliderDosya" />
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
                                aria-controls="pills-{{ $dil }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
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
                            $dilVerisi = isset($slider) ? $slider->sliderDiller->where('dil', $dil)->first() : null;
                        @endphp
                        <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}"
                            id="pills-{{ $dil }}" role="tabpanel"
                            aria-labelledby="pills-{{ $dil }}-tab" tabindex="0">
                            <div class="row mb-4">
                                <div class="col-xxl-12 lvvl">
                                    <label for="baslik-{{ $dil }}">Slider Başlık</label>
                                    <input type="text" class="form-control input" name="baslik-{{ $dil }}"
                                        id="baslik-{{ $dil }}" placeholder="Slider Başlık"
                                        value="{{ $dilVerisi->baslik ?? '' }}">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-xxl-12 lvvl">
                                    <label for="altBaslik-{{ $dil }}">Slider Alt Baslik</label>
                                    <input type="text" class="form-control input"
                                        name="altBaslik-{{ $dil }}" id="altBaslik-{{ $dil }}"
                                        placeholder="Slider Alt Başlık" value="{{ $dilVerisi->alt_baslik ?? '' }}">
                                </div>
                            </div>

                            {{-- <div class="row mb-4">
                                <div class="col-xxl-12 lvvl">
                                    <label for="butonIcerik-{{ $dil }}">Slider Buton İçerik</label>
                                    <input type="text" class="form-control input"
                                        name="butonIcerik-{{ $dil }}" id="butonIcerik-{{ $dil }}"
                                        placeholder="Slider Buton İçerik" value="{{ $dilVerisi->buton_icerik ?? '' }}">
                                </div>
                            </div> --}}

                            <div class="row mb-4">
                                <div class="col-xxl-12 lvvl">
                                    <label for="butonUrl-{{ $dil }}">Slider Buton Url</label>
                                    <input type="text" class="form-control input"
                                        name="butonUrl-{{ $dil }}" id="butonUrl-{{ $dil }}"
                                        placeholder="Slider Buton Url" value="{{ $dilVerisi->buton_url ?? '' }}">
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
                            {{ !isset($slider) || (isset($slider) && $slider->durum) ? 'checked' : '' }}>
                        <label class="switch-label" for="durum">Slider Durum</label>
                    </div>
                </div>
                <div class="col-xxl-12 col-sm-4 col-12 mx-auto" id="sliderBtnCnt">
                    <button class="btn btn-success w-100" id="sliderBtnSbt" type="button">
                        {{ $btnText }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>



@isset($slider)
    <script>
        const sliderId = {{ $slider->id }};
        @if ($slider->resim_url)
            const dosyaUrl = "{{ Storage::url($slider->resim_url) }}";
        @elseif ($slider->video_url)
            const dosyaUrl = "{{ Storage::url($slider->video_url) }}";
        @else
            const dosyaUrl = null;
        @endif
    </script>
@endisset
