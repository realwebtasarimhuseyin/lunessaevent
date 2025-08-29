<form id="dovizYonetimForm" onsubmit="(return false)" class="mb-4 layout-spacing layout-top-spacing">
    <div class="row w-100">
        <div class="col-12">
            <div class="widget-content widget-content-area form-section mt-4">
                <div>
                    <h4 class="text-center">
                        1 EURO = {{ formatPara(getDovizKuru('EURTRY')) }} TL
                    </h4>
                </div>
                <div class="row">
                    <div class="col-12 mb-4 lvvl">
                        <label>Kaynak</label>
                        <select name="kaynak" id="kaynak" class="form-select">
                            <option value="tcmb" {{ $dovizYonetim->kaynak == 'tcmb' ? 'selected' : '' }}>
                                T.C. Merkez Bankası
                            </option>
                            
                        </select>
                    </div>

                    <div class="col-12 mb-4 lvvl">
                        <label>Birim</label>
                        <input type="text" class="form-control input" name="birim" id="birim"
                            placeholder="Birim"
                            value="{{ isset($dovizYonetim->birim) ? str_replace('.', ',', $dovizYonetim->birim) : '' }}">
                    </div>

                    <div class="col-12 mb-4 lvvl">
                        <label>Yüzde</label>
                        <input type="text" class="form-control input" name="yuzde" id="yuzde"
                            placeholder="Yuzde"
                            value="{{ isset($dovizYonetim->yuzde) ? str_replace('.', ',', $dovizYonetim->yuzde) : '' }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mt-4">
            <div class="widget-content widget-content-area form-section">
                <div class="row">
                    <div class="col-12 mx-auto" id="dovizYonetimBtnCnt">
                        <button class="btn btn-success w-100" id="dovizYonetimBtnSbt" type="button">
                            {{ $btnText }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<script>
    var slug = "{{ $dovizYonetim->doviz_slug }}";
</script>
