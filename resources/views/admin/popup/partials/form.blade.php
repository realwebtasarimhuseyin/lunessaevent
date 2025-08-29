<form id="popupForm" onsubmit="(return false)" class="row mb-4 layout-spacing layout-top-spacing">
    <div class="col-xxl-12 mb-4">
        <div class="widget-content widget-content-area form-section">
            <div class="row">
                <div class="col-12 lvvl">
                    <label for="">Popup Resim</label>
                    <input type="file" class="popupResim filepond" id="popupResim" name="popupResim" />
                </div>
            </div>

            <div class="row">
                <div class="col-12 lvvl">
                    <label for="">Popup Tarih Aralığı</label>
                    <input type="text" class="form-control input" name="tarih" id="tarih"
                        placeholder="Popup Tarih Aralığı">
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 mb-4">
        <div class="simple-pill">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                @foreach ($desteklenenDil as $dil)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link{{ $loop->first ? ' active' : '' }}" id="pills-{{ $dil }}-tab"
                            data-bs-toggle="pill" data-bs-target="#pills-{{ $dil }}" type="button"
                            role="tab" aria-controls="pills-{{ $dil }}" aria-selected="true">
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
                        $dilVerisi = isset($popup) ? $popup->popupDiller->where('dil', $dil)->first() : null;
                    @endphp
                    <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}" id="pills-{{ $dil }}"
                        role="tabpanel" aria-labelledby="pills-{{ $dil }}-tab" tabindex="0">
                        <div class="widget-content widget-content-area form-section">

                            <div class="row">
                                <div class="col-12 mb-4 lvvl">
                                    <label>Popup Başlık</label>
                                    <input type="text" class="form-control input"
                                        name="popupBaslik-{{ $dil }}" id="popupBaslik-{{ $dil }}"
                                        placeholder="Popup Başlık" value="{{ $dilVerisi->baslik ?? '' }}">
                                </div>
                                <div class="col-12 lvvl">
                                    <label>Popup İçerik</label>
                                    <textarea class="form-control input" name="popupIcerik-{{ $dil }}" id="popupIcerik-{{ $dil }}"
                                        placeholder="Popup İçerik" cols="10" rows="5">{{ $dilVerisi->icerik ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="row mb-4">
            <div class="col-12">
                <div class="widget-content widget-content-area form-section">
                    <div class="col-xxl-12 mb-4 lvvl">
                        <div class="switch form-switch-custom switch-inline form-switch-primary">
                            <input class="switch-input input" type="checkbox" role="switch" id="durum"
                                {{ !isset($popup) || (isset($popup) && $popup->durum) ? 'checked' : '' }}>
                            <label class="switch-label" for="durum">Popup Durum</label>
                        </div>
                    </div>
                    <div class="col-xxl-12 col-sm-4 col-12 mx-auto" id="popupBtnCnt">
                        <button class="btn btn-success w-100" id="popupBtnSbt" type="button">
                            {{ $btnText }}
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>


<script>
    let fBaslangic = "";
    let fBitis = "";
    @isset($popup)
        fBaslangic = "{{ formatZaman($popup->baslangic_tarih) }}";
        fBitis = "{{ formatZaman($popup->bitis_tarih) }}";
        const popupResimUrl = "{{ $popup->resim_url ? Storage::url($popup->resim_url) : '' }}";
        const popupId = {{ $popup->id }};
    @endisset
</script>
