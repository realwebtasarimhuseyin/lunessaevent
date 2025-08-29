<form id="urunOzellikForm" onsubmit="(return false)" class="mb-4 layout-spacing layout-top-spacing">
    <div class="row w-100">
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
                            if (isset($urunOzellik)) {
                                $dilVerisi = $urunOzellik->urunOzellikDiller->where('dil', $dil)->first();
                            }
                        @endphp
                        <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}"
                            id="pills-{{ $dil }}" role="tabpanel"
                            aria-labelledby="pills-{{ $dil }}-tab" tabindex="0">
                            <div class="widget-content widget-content-area form-section">
                                <div class="row">
                                    <div class="col-sm-12 lvvl">
                                        <label>Ozellik</label>
                                        <input type="text" class="form-control input" name="isim-{{ $dil }}"
                                            id="isim-{{ $dil }}"
                                            @isset($urunOzellik)
                                                value="{{ $dilVerisi->isim }}"
                                            @endisset
                                            placeholder="Ozellik İsim">
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
                    <div class="col-xxl-12 mb-4 lvvl">
                        <div class="switch form-switch-custom switch-inline form-switch-primary">
                            <input class="switch-input input" type="checkbox" role="switch" id="durum"
                                {{ !isset($urunOzellik) || (isset($urunOzellik) && $urunOzellik->durum) ? 'checked' : '' }}>
                            <label class="switch-label" for="durum">Ozellik Durum</label>
                        </div>
                    </div>
                    <div class="col-xxl-12 col-sm-4 col-12 mx-auto" id="urunOzellikBtnCnt">
                        <button class="btn btn-success w-100" id="urunOzellikBtnSbt" type="button">
                            {{ $btnText }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@isset($urunOzellik)
    <script>
        const urunOzellikId = {{ $urunOzellik->id }};
    </script>
@endisset
