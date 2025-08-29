<form id="kuponForm" onsubmit="(return false)" class="row mb-4 layout-spacing layout-top-spacing">
    <div class="col-xxl-12">
        <div class="widget-content widget-content-area form-section">
            <div class="row mb-4">
                <div class="col-12 lvvl">
                    <label for="">Kupon Kod</label>

                    <div class="input-group mb-2">
                        <input type="text" class="form-control input" name="kod" id="kod"
                            placeholder="Kupon Kod" value="{{ $kupon->kod ?? '' }}"
                            @isset($kupon) {{ 'disabled' }} @endisset>
                        @empty($kupon)
                            <button class="btn btn-success" type="button" onclick="generateCouponCode()">Üret</button>
                        @endisset
                    </div>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-xxl-6 col-md-12 mb-4 lvvl">
                    <label for="">Kupon Geçerlilik Tarih</label>
                    <input type="text" class="form-control input" name="tarih" id="tarih"
                        placeholder="Kupon Geçerlilik Tarih">
                </div>
                <div class="col-xxl-6 col-md-12 mb-4 lvvl">
                    <label for="">Kupon Adet</label>
                    <input type="number" class="form-control input" name="adet" id="adet"
                        placeholder="Kupon Adet" value="{{ $kupon->adet ?? '' }}">
                </div>
                <div class="col-xxl-6 col-md-12 mb-4 lvvl">
                    <label for="">Kupon Tutar</label>
                    <input type="number" class="form-control input" name="tutar" id="tutar"
                        placeholder="Kupon Tutar" value="{{ $kupon->tutar ?? '' }}">
                </div>
                <div class="col-xxl-6 col-md-12 mb-4 lvvl">
                    <label for="">Kupon Yüzde</label>
                    <input type="number" class="form-control input" name="yuzde" id="yuzde"
                        placeholder="Kupon Yüzde" value="{{ $kupon->yuzde ?? '' }}">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-xxl-12 mb-4 lvvl">
                    <div class="switch form-switch-custom switch-inline form-switch-primary">
                        <input class="switch-input input" type="checkbox" role="switch" id="durum" checked>
                        <label class="switch-label" for="durum">Kupon Durum</label>
                    </div>
                </div>
                <div class="col-xxl-12 col-sm-4 col-12 mx-auto" id="kuponBtnCnt">
                    <button class="btn btn-success w-100" id="kuponBtnSbt" type="button">
                        {{ $btnText }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>


<script>
    function generateCouponCode() {
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        const minLength = 10;
        const maxLength = 20;

        const couponLength = Math.floor(Math.random() * (maxLength - minLength + 1)) + minLength;

        let couponCode = '';
        for (let i = 0; i < couponLength; i++) {
            const randomIndex = Math.floor(Math.random() * characters.length);
            couponCode += characters[randomIndex];
        }

        return $("#kod").val(couponCode);
    }

    let fBaslangic = "";
    let fBitis = "";
    @isset($kupon)
        fBaslangic = "{{ formatZaman($kupon->baslangic_tarih) }}";
        fBitis = "{{ formatZaman($kupon->bitis_tarih) }}";
        const kuponId = {{ $kupon->id }}
    @endisset
</script>
