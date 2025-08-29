<form id="urunKdvForm" onsubmit="(return false)" class="mb-4 layout-spacing layout-top-spacing">
    <div class="row w-100">
        <div class="col-12">
            <div class="widget-content widget-content-area form-section">
                <div class="row">
                    <div class="col-12 lvvl">
                        <label>Kdv Başlık</label>
                        <input type="text" class="form-control input" name="kdvBaslik" id="kdvBaslik"
                            placeholder="Kdv Başlık" value="{{ $urunKdv->baslik ?? '' }}">
                    </div>
                    <div class="col-12 mt-2 lvvl">
                        <label>Kdv Oran</label>
                        <input type="number" class="form-control input" name="kdvOran" id="kdvOran"
                            placeholder="Kdv Oran" value="{{ $urunKdv->kdv ?? '' }}">
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
                                {{ !isset($urunKdv) || (isset($urunKdv) && $urunKdv->durum) ? 'checked' : '' }}>
                            <label class="switch-label" for="durum">Kdv Durum</label>
                        </div>
                    </div>
                    <div class="col-xxl-12 col-sm-4 col-12 mx-auto" id="urunKdvBtnCnt">
                        <button class="btn btn-success w-100" id="urunKdvBtnSbt" type="button">
                            {{ $btnText }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@isset($urunKdv)
    <script>
        const urunKdvId = {{ $urunKdv->id }};
    </script>
@endisset
