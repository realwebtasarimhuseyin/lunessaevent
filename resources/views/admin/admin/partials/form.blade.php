<form id="adminForm" onsubmit="(return false)" class="row mb-4 layout-spacing layout-top-spacing">
    <div class="col-xxl-12">
        <div class="widget-content widget-content-area form-section">
            <div class="row mb-5">
                <div class="col-xxl-6 col-md-12 mb-4 lvvl">
                    <label for="">İsim</label>
                    <input type="text" class="form-control input" name="isim" id="isim"
                        value="{{ $admin->isim ?? '' }}" placeholder="İsim">
                </div>
                <div class="col-xxl-6 col-md-12 mb-4 lvvl">
                    <label for="">Soyisim</label>
                    <input type="text" class="form-control input" name="soyisim" id="soyisim"
                        value="{{ $admin->soyisim ?? '' }}" placeholder="Soyisim">
                </div>

                <div class="col-xxl-6 col-md-12 mb-4 lvvl">
                    <label for="">Eposta</label>
                    <input type="text" class="form-control input" name="eposta" id="eposta"
                        value="{{ $admin->eposta ?? '' }}" placeholder="Eposta">
                </div>

               {{--  <div class="col-xxl-6 col-md-12 mb-4 lvvl">
                    <label for="yetki">Yetki</label>
                    <select name="yetki" class="form-select input" id="yetki">
                        <option disabled selected>Yetki Seçiniz</option>
                        <option value="010" {{ isset($admin) && $admin->super_admin ? 'selected' : '' }}>Süper Admin</option>
                        @foreach ($yetkiler as $yetki)
                            <option value="{{ $yetki->name }}" {{ rolKontrol($yetki->name) ? 'selected' : '' }}>
                                {{ $yetki->name }}</option>
                        @endforeach
                    </select>
                </div> --}}

                <div class="col-xxl-6 col-md-12 mb-4 lvvl">
                    <label for="">Şifre</label>
                    <input type="text" class="form-control input" {{ !empty($admin) ? "duzenle='true'" : '' }}
                        name="sifre" id="sifre" placeholder="Şifre">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-xxl-12 mb-4 lvvl">
                    <div class="switch form-switch-custom switch-inline form-switch-primary">
                        <input class="switch-input input" type="checkbox" role="switch" id="durum"
                            {{ !empty($admin) && $admin->durum ? 'checked' : '' }}>
                        <label class="switch-label" for="durum">Admin Durum</label>
                    </div>
                </div>
                <div class="col-xxl-12 col-sm-4 col-12 mx-auto" id="adminBtnCnt">
                    <button class="btn btn-success w-100" id="adminBtnSbt" type="button">
                        {{ $btnText }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>


@if (!empty($admin))
    <script>
        var adminId = {{ $admin->id }};
    </script>
@endif
