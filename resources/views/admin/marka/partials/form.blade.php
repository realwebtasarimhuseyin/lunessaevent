<form id="markaForm" onsubmit="(return false)" class="mb-4 layout-spacing layout-top-spacing">
    <div class="row w-100">
        <div class="col-12">
            <div class="widget-content widget-content-area form-section">
                <div class="row">
                    <div class="col-12 col-md-12 mb-4">
                        <label for="markaResim">Logo</label>
                        <div class="multiple-file-upload lvvl">
                            <input type="file" class="markaResim filepond" id="markaResim" name="markaResim" />
                        </div>
                    </div>
                    <div class="col-12 mb-4 lvvl">
                        <label for="isim">Marka İsim</label>
                        <input type="text" class="form-control input" name="isim" id="isim"
                            placeholder="Marka İsim" value="{{ $marka->isim ?? '' }}">
                    </div>
                    <div class="col-12 mb-4 lvvl">
                        <div class="switch form-switch-custom switch-inline form-switch-primary">
                            <input class="switch-input input" type="checkbox" role="switch" id="durum"
                                {{ !isset($marka) || (isset($marka) && $marka->durum) ? 'checked' : '' }}>

                            <label class="switch-label" for="durum">Durum</label>
                        </div>
                    </div>

                    <div class="col-xxl-12 col-sm-4 col-12 mx-auto" id="markaBtnCnt">
                        <button class="btn btn-success w-100" id="markaBtnSbt" type="button">
                            {{ $btnText }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@if (!empty($marka))
    <script>
        const markaId = {{ $marka->id }};
        @if ($marka->resim_url)
            const resimUrl = "{{ Storage::url($marka->resim_url) }}";
        @endif
    </script>
@endif
