<form id="ekipForm" onsubmit="(return false)" class="mb-4 layout-spacing layout-top-spacing">
    <div class="row w-100">
        <div class="col-12">
            <div class="widget-content widget-content-area form-section">
                <div class="row">
                    <div class="col-12 col-md-12 mb-4">
                        <label for="product-images">Görsel</label>
                        <div class="multiple-file-upload lvvl">
                            <input type="file" class="ekipResim filepond" id="ekipResim" name="ekipResim" />
                        </div>
                    </div>
                    <div class="col-12 mb-4 lvvl">
                        <label for="isim">Başlık</label>
                        <input type="text" class="form-control input" name="isim" id="isim"
                            placeholder="Başlık" value="{{ $ekip->isim ?? '' }}">
                    </div>
                    <div class="col-12 mb-4 lvvl">
                        <label for="isim">Açıklama</label>
                        <input type="text" class="form-control input" name="unvan" id="unvan"
                            placeholder="Açıklama" value="{{ $ekip->unvan ?? '' }}">
                    </div>
                    <div class="col-12 mb-4 lvvl">
                        <div class="switch form-switch-custom switch-inline form-switch-primary">
                            <input class="switch-input input" type="checkbox" role="switch" id="durum"
                                {{ !isset($ekip) || (isset($ekip) && $ekip->durum) ? 'checked' : '' }}>
                            <label class="switch-label" for="durum">Durum</label>
                        </div>
                    </div>

                    <div class="col-xxl-12 col-sm-4 col-12 mx-auto" id="ekipBtnCnt">
                        <button class="btn btn-success w-100" id="ekipBtnSbt" type="button">
                            {{ $btnText }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@isset($ekip)
    <script>
        const ekipId = {{ $ekip->id }};
        const resimUrl = "{{ Storage::url($ekip->resim_url) }}";
    </script>
@endisset
