<form id="duyuruForm" onsubmit="(return false)" class="row mb-4 layout-spacing layout-top-spacing">
    <div class="col-xxl-12">
        <div class="widget-content widget-content-area form-section">
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
                            $dilVerisi = isset($duyuru) ? $duyuru->duyuruDiller->where('dil', $dil)->first() : null;
                        @endphp
                        <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}"
                            id="pills-{{ $dil }}" role="tabpanel"
                            aria-labelledby="pills-{{ $dil }}-tab" tabindex="0">
                            <div class="row mb-4">
                                <div class="col-xxl-12 lvvl">
                                    <label for="icerik">Duyuru İçerik</label>
                                    <input id="icerik-{{ $dil }}" name="icerik-{{ $dil }}"
                                        class="form-control input" value="{{ $dilVerisi->icerik ?? '' }}" />
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
                            {{ !isset($duyuru) || (isset($duyuru) && $duyuru->durum) ? 'checked' : '' }}>
                        <label class="switch-label" for="durum">Duyuru Durum</label>
                    </div>
                </div>
                <div class="col-xxl-12 col-sm-4 col-12 mx-auto" id="duyuruBtnCnt">
                    <button class="btn btn-success w-100" id="duyuruBtnSbt" type="button">
                        {{ $btnText }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>



@isset($duyuru)
    <script>
        const duyuruId = {{ $duyuru->id }};
    </script>
@endisset
