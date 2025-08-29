<form id="ayarForm" onsubmit="(return false)" class="mb-4 layout-spacing layout-top-spacing">
    <div class="row w-100">
        <div class="col-12">
            <div class="simple-pill">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-genel-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-genel" type="button" role="tab" aria-controls="pills-genel"
                            aria-selected="true">
                            Genel
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-iletisim-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-iletisim" type="button" role="tab"
                            aria-controls="pills-iletisim" aria-selected="true">
                            İletişim Bilgileri
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-mail-tab" data-bs-toggle="pill" data-bs-target="#pills-mail"
                            type="button" role="tab" aria-controls="pills-mail" aria-selected="true">
                            SMTP Mail
                        </button>
                    </li>

                   <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-banner-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-banner" type="button" role="tab" aria-controls="pills-banner"
                            aria-selected="true">
                            Banner
                        </button>
                    </li> 

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-sosyal-medya-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-sosyal-medya" type="button" role="tab"
                            aria-controls="pills-sosyal-medya" aria-selected="true">
                            Sosyal Medya
                        </button>
                    </li>

                    {{-- <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-script-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-script" type="button" role="tab" aria-controls="pills-script"
                            aria-selected="true">
                            Script Kod
                        </button>
                    </li> --}}

                    {{-- <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-banka-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-banka" type="button" role="tab" aria-controls="pills-banka"
                            aria-selected="true">
                            Banka
                        </button>
                    </li> --}}

                    {{-- <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-kargo-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-kargo" type="button" role="tab" aria-controls="pills-kargo"
                            aria-selected="true">
                            Kargo
                        </button>
                    </li> --}}

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-sitemap-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-sitemap" type="button" role="tab" aria-controls="pills-sitemap"
                            aria-selected="true">
                            Site Map
                        </button>
                    </li>
                    {{-- 
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-duyuru-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-duyuru" type="button" role="tab"
                            aria-controls="pills-duyuru" aria-selected="true">
                            Duyuru
                        </button>
                    </li> --}}
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-genel" role="tabpanel"
                        aria-labelledby="pills-genel-tab" tabindex="0">
                        <div class="simple-pill mb-4">
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
                                    <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}"
                                        id="pills-{{ $dil }}" role="tabpanel"
                                        aria-labelledby="pills-{{ $dil }}-tab" tabindex="0">
                                        <div class="widget-content widget-content-area form-section">
                                            <div class="row mb-3">
                                                <div class="col-sm-12 lvvl mb-4">
                                                    <label>Site Başlık ({{ $tamDil($dil) }})</label>
                                                    <input type="text" class="form-control input"
                                                        name="siteBaslik-{{ $dil }}"
                                                        id="siteBaslik-{{ $dil }}"
                                                        value="{{ ayar('siteBaslik', $dil) }}"
                                                        placeholder="Site Başlık ({{ $tamDil($dil) }})">
                                                </div>
                                                <div class="col-sm-12 lvvl mb-4">
                                                    <label>Site Açıklama ({{ $tamDil($dil) }})</label>
                                                    <textarea class="form-control input" name="siteAciklama-{{ $dil }}" id="siteAciklama-{{ $dil }}"
                                                        placeholder="Site Açıklama ({{ $tamDil($dil) }})" rows="5">{{ ayar('siteAciklama', $dil) }}</textarea>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <h4>Seo Ayarları ({{ $tamDil($dil) }})</h4>
                                                </div>
                                                <div class="col-xxl-12 mb-4 lvvl">
                                                    <label>Meta Başlık</label>
                                                    <input type="text" class="form-control input"
                                                        name="metaBaslik-{{ $dil }}"
                                                        id="metaBaslik-{{ $dil }}"
                                                        value="{{ ayar('metaBaslik', $dil) }}"
                                                        placeholder="Meta Başlık">
                                                </div>
                                                <div class="col-xxl-12 mb-4 lvvl">
                                                    <label>Meta Anahtar</label>
                                                    <input type="text" class="form-control input"
                                                        name="metaAnahtar-{{ $dil }}"
                                                        id="metaAnahtar-{{ $dil }}"
                                                        value="{{ ayar('metaAnahtar', $dil) }}"
                                                        placeholder="Meta Anahtar">
                                                </div>
                                                <div class="col-xxl-12 lvvl">
                                                    <label for="metaIcerik">Meta Açıklama</label>
                                                    <textarea class="form-control input" name="metaIcerik-{{ $dil }}" id="metaIcerik-{{ $dil }}"
                                                        cols="10" rows="5">{{ ayar('metaIcerik', $dil) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="widget-content widget-content-area form-section">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <h3>Logolar</h3>
                                </div>
                                <div class="col-lg-4 col-12">
                                    <label for="ustLogo-image">
                                        <h5>Üst Logo</h5>
                                    </label>
                                    <div class="multiple-file-upload lvvl">
                                        <input type="file" class="file-upload-multiple" id="ustLogo-image"
                                            name="filepond" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-12">
                                    <label for="altLogo-image">
                                        <h5>Alt Logo</h5>
                                    </label>
                                    <div class="multiple-file-upload lvvl">
                                        <input type="file" class="file-upload-multiple" id="altLogo-image"
                                            name="filepond" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-12">
                                    <label for="favicon-image">
                                        <h5>Favicon</h5>
                                    </label>
                                    <div class="multiple-file-upload lvvl">
                                        <input type="file" class="file-upload-multiple" id="favicon-image"
                                            name="filepond" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-iletisim" role="tabpanel"
                        aria-labelledby="pills-iletisim-tab" tabindex="0">
                        <div class="widget-content widget-content-area form-section">
                            <div class="row">
                                <div class="col-md-6 col-12 mb-4 lvvl">
                                    <label for="eposta">E-Posta</label>
                                    <input type="text" class="form-control input" id="eposta" name="eposta"
                                        value="{{ ayar('eposta') }}">
                                </div>
                                <div class="col-md-6 col-12 mb-4 lvvl">
                                    <label for="telefon">Telefon Numarası</label>
                                    <input type="text" class="form-control input" id="telefon" name="telefon"
                                        value="{{ ayar('telefon') }}">
                                </div>

                                <div class="col-12 mb-4 lvvl">
                                    <label for="adres">Adres</label>
                                    <textarea class="form-control input" name="adres" id="adres" rows="5" placeholder="Adres">{{ ayar('adres') }}</textarea>
                                </div>

                                <div class="col-12 mb-4 lvvl">
                                    <label for="iframeLink">İframe Link</label>
                                    <textarea class="form-control input" name="iframeLink" id="iframeLink" rows="5" placeholder="İframe Link">{{ ayar('iframeLink') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-mail" role="tabpanel" aria-labelledby="pills-mail-tab"
                        tabindex="0">
                        <div class="widget-content widget-content-area form-section">
                            <div class="row">
                                <div class="col-12 mb-4 lvvl">
                                    <label for="smtpHost">SMTP Sunucu Adresi</label>
                                    <input type="text" class="form-control input" id="smtpSunucuAdresi"
                                        name="smtpSunucuAdresi" value="{{ ayar('smtpSunucuAdresi') }}">
                                </div>
                                <div class="col-12 mb-4 lvvl">
                                    <label for="smtpPort">SMTP Portu</label>
                                    <input type="number" class="form-control input" id="smtpPort" name="smtpPort"
                                        value="{{ ayar('smtpPort') }}">
                                </div>
                                <div class="col-12 mb-4 lvvl">
                                    <label for="smtpUser">SMTP Kullanıcı Adı</label>
                                    <input type="text" class="form-control input" id="smtpKullaniciAdi"
                                        name="smtpKullaniciAdi" value="{{ ayar('smtpKullaniciAdi') }}">
                                </div>
                                <div class="col-12 mb-4 lvvl">
                                    <label for="smtpPassword">SMTP Şifresi</label>
                                    <input type="password" class="form-control input" id="smtpSifresi"
                                        name="smtpSifresi" value="{{ ayar('smtpSifresi') }}">
                                </div>
                                <div class="col-12 mb-4 lvvl">
                                    <label for="smtpSecure">Güvenlik Protokolü</label>
                                    <select class="form-control input" id="guvenlikProtokolu"
                                        name="guvenlikProtokolu">
                                        <option value="tls"
                                            @if (ayar('guvenlikProtokolu') == 'tls') {{ 'selected' }} @endif>TLS</option>
                                        <option value="ssl"
                                            @if (ayar('guvenlikProtokolu') == 'ssl') {{ 'selected' }} @endif>SSL</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-4 lvvl">
                                    <label for="fromName">Gönderen Adı</label>
                                    <input type="text" class="form-control input" id="gonderenAdi"
                                        name="gonderenAdi" value="{{ ayar('gonderenAdi') }}">
                                </div>
                                <div class="col-12 mb-4 lvvl">
                                    <label for="fromEmail">Gönderen E-posta Adresi</label>
                                    <input type="email" class="form-control input" id="gonderenEpostaAdresi"
                                        name="gonderenEpostaAdresi" value="{{ ayar('gonderenEpostaAdresi') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-banner" role="tabpanel" aria-labelledby="pills-banner-tab"
                        tabindex="0">
                        <div class="simple-pill mb-4">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                @foreach ($desteklenenDil as $dil)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link{{ $loop->first ? ' active' : '' }}"
                                            data-bs-toggle="pill" data-bs-target="#pills-banner-{{ $dil }}"
                                            type="button" role="tab"
                                            aria-controls="pills-banner-{{ $dil }}" aria-selected="true">
                                            <img src="{{ Vite::asset("resources/images/1x1/$dil.svg") }}"
                                                class="rounded-circle w-1-5rem" alt="flag">
                                            {{ $tamDil($dil) }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="widget-content widget-content-area form-section">
                                <div class="tab-content" id="pills-tabContent">
                                    @foreach ($desteklenenDil as $dil)
                                        <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}"
                                            id="pills-banner-{{ $dil }}" role="tabpanel"
                                            aria-labelledby="pills-{{ $dil }}-tab" tabindex="0">
                                            <div class="row">
                                                <div class="col-12 mt-4 mb-4">
                                                    <h4>Reklam Banner 1</h4>
                                                </div>
                                                <div class="col-12 mb-4">
                                                    <div class="multiple-file-upload lvvl mb-4">
                                                        <input type="file" class="file-upload-multiple"
                                                            id="reklamBanner1-{{ $dil }}"
                                                            name="reklamBanner1-{{ $dil }}" />
                                                    </div>

                                                   {{--  <label for="reklamBanner1Baslik">Reklam Banner 1 Başlık
                                                        ({{ $tamDil($dil) }})
                                                    </label>
                                                    <input type="text" class="form-control input"
                                                        id="reklamBanner1Baslik-{{ $dil }}"
                                                        name="reklamBanner1Baslik-{{ $dil }}"
                                                        value="{{ ayar('reklamBanner1Baslik', $dil) }}">

                                                    <label for="reklamBanner1AltBaslik" class="mt-3">Reklam Banner 1
                                                        Alt Başlık ({{ $tamDil($dil) }})</label>
                                                    <input type="text" class="form-control input"
                                                        id="reklamBanner1AltBaslik-{{ $dil }}"
                                                        name="reklamBanner1AltBaslik-{{ $dil }}"
                                                        value="{{ ayar('reklamBanner1AltBaslik', $dil) }}">

                                                    <label for="reklamBanner1ButonIcerik" class="mt-3">Reklam Banner
                                                        1 Buton İçerik ({{ $tamDil($dil) }})</label>
                                                    <input type="text" class="form-control input"
                                                        id="reklamBanner1ButonIcerik-{{ $dil }}"
                                                        name="reklamBanner1ButonIcerik-{{ $dil }}"
                                                        value="{{ ayar('reklamBanner1ButonIcerik', $dil) }}">

                                                    <label for="reklamBanner1Link" class="mt-3">Reklam Banner 1 Link
                                                        ({{ $tamDil($dil) }})</label>
                                                    <input type="text" class="form-control input"
                                                        id="reklamBanner1Link-{{ $dil }}"
                                                        name="reklamBanner1Link-{{ $dil }}"
                                                        value="{{ ayar('reklamBanner1Link', $dil) }}"> --}}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 mt-4 mb-4">
                                                    <h4>Reklam Banner 2</h4>
                                                </div>
                                                <div class="col-12 mb-4">
                                                    <div class="multiple-file-upload lvvl mb-4">
                                                        <input type="file" class="file-upload-multiple"
                                                            id="reklamBanner2-{{ $dil }}"
                                                            name="reklamBanner2-{{ $dil }}" />
                                                    </div>

                                                   {{--  <label for="reklamBanner2Baslik">Reklam Banner 2 Başlık
                                                        ({{ $tamDil($dil) }})</label>
                                                    <input type="text" class="form-control input"
                                                        id="reklamBanner2Baslik-{{ $dil }}"
                                                        name="reklamBanner2Baslik-{{ $dil }}"
                                                        value="{{ ayar('reklamBanner2Baslik', $dil) }}">

                                                    <label for="reklamBanner2AltBaslik" class="mt-3">Reklam Banner 2
                                                        Alt Başlık ({{ $tamDil($dil) }})</label>
                                                    <input type="text" class="form-control input"
                                                        id="reklamBanner2AltBaslik-{{ $dil }}"
                                                        name="reklamBanner2AltBaslik-{{ $dil }}"
                                                        value="{{ ayar('reklamBanner2AltBaslik', $dil) }}">

                                                    <label for="reklamBanner2ButonIcerik" class="mt-3">Reklam Banner
                                                        2 Buton İçerik ({{ $tamDil($dil) }})</label>
                                                    <input type="text" class="form-control input"
                                                        id="reklamBanner2ButonIcerik-{{ $dil }}"
                                                        name="reklamBanner2ButonIcerik-{{ $dil }}"
                                                        value="{{ ayar('reklamBanner2ButonIcerik', $dil) }}">

                                                    <label for="reklamBanner2Link" class="mt-3">Reklam Banner 2 Link
                                                        ({{ $tamDil($dil) }})</label>
                                                    <input type="text" class="form-control input"
                                                        id="reklamBanner2Link-{{ $dil }}"
                                                        name="reklamBanner2Link-{{ $dil }}"
                                                        value="{{ ayar('reklamBanner2Link', $dil) }}"> --}}
                                                </div>
                                            </div>

                                         <div class="row">
                                                <div class="col-12 mt-4 mb-4">
                                                    <h4>Reklam Banner 3</h4>
                                                </div>
                                                <div class="col-12 mb-4">
                                                    <div class="multiple-file-upload lvvl mb-4">
                                                        <input type="file" class="file-upload-multiple"
                                                            id="reklamBanner3-{{ $dil }}"
                                                            name="reklamBanner3-{{ $dil }}" />
                                                    </div>

                                                    <!--<label for="reklamBanner3Baslik">Reklam Banner 3 Başlık-->
                                                    <!--    ({{ $tamDil($dil) }})</label>-->
                                                    <!--<input type="text" class="form-control input"-->
                                                    <!--    id="reklamBanner3Baslik-{{ $dil }}"-->
                                                    <!--    name="reklamBanner3Baslik-{{ $dil }}"-->
                                                    <!--    value="{{ ayar('reklamBanner3Baslik', $dil) }}">-->

                                                    <!--<label for="reklamBanner3Link" class="mt-3">Reklam Banner 3 Link-->
                                                    <!--    ({{ $tamDil($dil) }})</label>-->
                                                    <!--<input type="text" class="form-control input"-->
                                                    <!--    id="reklamBanner3Link-{{ $dil }}"-->
                                                    <!--    name="reklamBanner3Link-{{ $dil }}"-->
                                                    <!--    value="{{ ayar('reklamBanner3Link', $dil) }}">-->
                                                </div>
                                            </div>
 {{--   
                                            <div class="row">
                                                <div class="col-12 mt-4 mb-4">
                                                    <h4>Reklam Banner 4</h4>
                                                </div>
                                                <div class="col-12 mb-4">
                                                    <div class="multiple-file-upload lvvl mb-4">
                                                        <input type="file" class="file-upload-multiple"
                                                            id="reklamBanner4-{{ $dil }}"
                                                            name="reklamBanner4-{{ $dil }}" />
                                                    </div>

                                                    <label for="reklamBanner4Link" class="mt-3">Reklam Banner 4 Link
                                                        ({{ $tamDil($dil) }})</label>
                                                    <input type="text" class="form-control input"
                                                        id="reklamBanner4Link-{{ $dil }}"
                                                        name="reklamBanner4Link-{{ $dil }}"
                                                        value="{{ ayar('reklamBanner4Link', $dil) }}">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 mt-4 mb-4">
                                                    <h4>Reklam Banner 5</h4>
                                                </div>
                                                <div class="col-12 mb-4">
                                                    <div class="multiple-file-upload lvvl mb-4">
                                                        <input type="file" class="file-upload-multiple"
                                                            id="reklamBanner5-{{ $dil }}"
                                                            name="reklamBanner5-{{ $dil }}" />
                                                    </div>

                                                    <label for="reklamBanner5Baslik">Reklam Banner 5 Başlık
                                                        ({{ $tamDil($dil) }})</label>
                                                    <input type="text" class="form-control input"
                                                        id="reklamBanner5Baslik-{{ $dil }}"
                                                        name="reklamBanner5Baslik-{{ $dil }}"
                                                        value="{{ ayar('reklamBanner5Baslik', $dil) }}">

                                                    <label for="reklamBanner5AltBaslik" class="mt-3">Reklam Banner 5
                                                        Alt Başlık ({{ $tamDil($dil) }})</label>
                                                    <input type="text" class="form-control input"
                                                        id="reklamBanner5AltBaslik-{{ $dil }}"
                                                        name="reklamBanner5AltBaslik-{{ $dil }}"
                                                        value="{{ ayar('reklamBanner5AltBaslik', $dil) }}">

                                                    <label for="reklamBanner5ButonIcerik" class="mt-3">Reklam Banner
                                                        5 Buton İçerik ({{ $tamDil($dil) }})</label>
                                                    <input type="text" class="form-control input"
                                                        id="reklamBanner5ButonIcerik-{{ $dil }}"
                                                        name="reklamBanner5ButonIcerik-{{ $dil }}"
                                                        value="{{ ayar('reklamBanner5ButonIcerik', $dil) }}">

                                                    <label for="reklamBanner5Link" class="mt-3">Reklam Banner 5 Link
                                                        ({{ $tamDil($dil) }})</label>
                                                    <input type="text" class="form-control input"
                                                        id="reklamBanner5Link-{{ $dil }}"
                                                        name="reklamBanner5Link-{{ $dil }}"
                                                        value="{{ ayar('reklamBanner5Link', $dil) }}">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 mt-4 mb-4">
                                                    <h4>Reklam Banner 6</h4>
                                                </div>
                                                <div class="col-12 mb-4">
                                                    <div class="multiple-file-upload lvvl mb-4">
                                                        <input type="file" class="file-upload-multiple"
                                                            id="reklamBanner6-{{ $dil }}"
                                                            name="reklamBanner6-{{ $dil }}" />
                                                    </div>

                                                    <label for="reklamBanner6Baslik">Reklam Banner 6 Başlık
                                                        ({{ $tamDil($dil) }})</label>
                                                    <input type="text" class="form-control input"
                                                        id="reklamBanner6Baslik-{{ $dil }}"
                                                        name="reklamBanner6Baslik-{{ $dil }}"
                                                        value="{{ ayar('reklamBanner6Baslik', $dil) }}">

                                                    <label for="reklamBanner6AltBaslik" class="mt-3">Reklam Banner 6
                                                        Alt Başlık ({{ $tamDil($dil) }})</label>
                                                    <input type="text" class="form-control input"
                                                        id="reklamBanner6AltBaslik-{{ $dil }}"
                                                        name="reklamBanner6AltBaslik-{{ $dil }}"
                                                        value="{{ ayar('reklamBanner6AltBaslik', $dil) }}">

                                                    <label for="reklamBanner6ButonIcerik" class="mt-3">Reklam
                                                        Banner 6 Buton İçerik ({{ $tamDil($dil) }})</label>
                                                    <input type="text" class="form-control input"
                                                        id="reklamBanner6ButonIcerik-{{ $dil }}"
                                                        name="reklamBanner6ButonIcerik-{{ $dil }}"
                                                        value="{{ ayar('reklamBanner6ButonIcerik', $dil) }}">

                                                    <label for="reklamBanner6Link" class="mt-3">Reklam Banner 6 Link
                                                        ({{ $tamDil($dil) }})</label>
                                                    <input type="text" class="form-control input"
                                                        id="reklamBanner6Link-{{ $dil }}"
                                                        name="reklamBanner6Link-{{ $dil }}"
                                                        value="{{ ayar('reklamBanner6Link', $dil) }}">
                                                </div>
                                            </div>

 --}}
{{-- 
                                            <div class="row">
                                                <div class="col-12 mt-4 mb-4">
                                                    <h4>E-Bülten Banner</h4>
                                                </div>
                                                <div class="col-12 mb-4">
                                                    <div class="multiple-file-upload lvvl mb-4">
                                                        <input type="file" class="file-upload-multiple"
                                                            id="reklamBanner7-{{ $dil }}"
                                                            name="reklamBanner6-{{ $dil }}" />
                                                    </div>
                                                </div>
                                            </div> --}}

                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-sosyal-medya" role="tabpanel"
                        aria-labelledby="pills-sosyal-medya-tab" tabindex="0">
                        <div class="widget-content widget-content-area form-section">
                            <div class="row">
                                <div class="col-md-6 col-12 mb-4 lvvl">
                                    <label for="facebook">Facebook</label>
                                    <input type="text" class="form-control input" id="facebook" name="facebook"
                                        value="{{ ayar('facebook') }}">
                                </div>
                                <div class="col-md-6 col-12 mb-4 lvvl">
                                    <label for="twitter">Twitter</label>
                                    <input type="text" class="form-control input" id="twitter" name="twitter"
                                        value="{{ ayar('twitter') }}">
                                </div>
                                <div class="col-md-6 col-12 mb-4 lvvl">
                                    <label for="instagram">İnstagram</label>
                                    <input type="text" class="form-control input" id="instagram" name="instagram"
                                        value="{{ ayar('instagram') }}">
                                </div>
                                {{-- <div class="col-md-6 col-12 mb-4 lvvl">
                                    <label for="pinterest">Pinterest</label>
                                    <input type="text" class="form-control input" id="pinterest" name="pinterest"
                                        value="{{ ayar('pinterest') }}">
                                </div> --}}
                                <div class="col-md-6 col-12 mb-4 lvvl">
                                    <label for="youtube">Youtube</label>
                                    <input type="text" class="form-control input" id="youtube" name="youtube"
                                        value="{{ ayar('youtube') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-script" role="tabpanel" aria-labelledby="pills-script-tab"
                        tabindex="0">
                        <div class="widget-content widget-content-area form-section">
                            <div class="row">
                                <div class="col-md-6 col-12 mb-4 lvvl">
                                    <label for="scriptKod">Script Kod</label>

                                    <textarea id="scriptKod" name="scriptKod" class="form-control input">{{ ayar('scriptKod') }}</textarea>
                                </div>

                                <div class="col-md-6 col-12 mb-4 lvvl">
                                    <label for="scriptKodBody">Script Kod Body</label>

                                    <textarea id="scriptKodBody" name="scriptKodBody" class="form-control input">{{ ayar('scriptKodBody') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-banka" role="tabpanel" aria-labelledby="pills-banka-tab"
                        tabindex="0">
                        <div class="widget-content widget-content-area form-section">
                            <div class="row">

                                <div class="col-md-6 col-12 mb-4 lvvl">
                                    <label for="banka">Banka</label>
                                    <input type="text" class="form-control input" id="banka" name="banka"
                                        value="{{ ayar('banka') }}">
                                </div>
                                <div class="col-md-6 col-12 mb-4 lvvl">
                                    <label for="bankaHesapSahibi">Banka Hesap Sahibi</label>
                                    <input type="text" class="form-control input" id="bankaHesapSahibi"
                                        name="bankaHesapSahibi" value="{{ ayar('bankaHesapSahibi') }}">
                                </div>
                                <div class="col-md-6 col-12 mb-4 lvvl">
                                    <label for="bankaIban">Banka Hesap No (IBAN)</label>
                                    <input type="text" class="form-control input" id="bankaIban" name="bankaIban"
                                        value="{{ ayar('bankaIban') }}">
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-kargo" role="tabpanel" aria-labelledby="pills-kargo-tab"
                        tabindex="0">
                        <div class="widget-content widget-content-area form-section">
                            <div class="row">

                                <div class="col-md-6 col-12 mb-4 lvvl">
                                    <label for="sepetMinKargoTutari">Sepet Min. Kargo Tutarı</label>
                                    <input type="text" class="form-control input" id="sepetMinKargoTutari"
                                        name="sepetMinKargoTutari" value="{{ ayar('sepetMinKargoTutari') }}">
                                </div>
                                <div class="col-md-6 col-12 mb-4 lvvl">
                                    <label for="kargoTutari">Kargo Tutarı</label>
                                    <input type="text" class="form-control input" id="kargoTutari"
                                        name="kargoTutari" value="{{ ayar('kargoTutari') }}">
                                </div>

                                <div class="col-md-6 col-12 mb-4 lvvl">
                                    <label for="ortalamaKargoSuresi">Ortalama Kargo Süresi</label>
                                    <input type="text" class="form-control input" id="ortalamaKargoSuresi"
                                        name="ortalamaKargoSuresi" value="{{ ayar('ortalamaKargoSuresi') }}">
                                </div>

                                <div class="col-md-6 col-12 mb-4 lvvl">
                                    <label for="kapidaOdemeTutar">Kapıda Ödeme Tutar</label>
                                    <input type="text" class="form-control input" id="kapidaOdemeTutar"
                                        name="kapidaOdemeTutar" value="{{ ayar('kapidaOdemeTutar') }}">
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-sitemap" role="tabpanel" aria-labelledby="pills-script-tab"
                        tabindex="0">
                        <div class="widget-content widget-content-area form-section">
                            <div class="row">
                                <div class="col-12 mb-4 lvvl">
                                    <label>Site Map</label>
                                    <div class="mb-4 fs-4">
                                        Site Map Link : <a href="{{ env('APP_URL') }}/sitemap.xml" target="_blank">
                                            {{ env('APP_URL') }}/sitemap.xml </a>
                                    </div>
                                    <div class="gap-2">
                                        <button type="button" class="btn btn-ptimary" id="siteMapGuncelle">
                                            Site Map Güncelle
                                        </button>
                                        <a href="{{ route('realpanel.sitemap.indir') }}" target="_blank"
                                            class="btn btn-ptimary" id="siteMapIndir">
                                            Site Map İndir
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-duyuru" role="tabpanel" aria-labelledby="pills-banka-tab"
                        tabindex="0">
                        <div class="widget-content widget-content-area form-section">
                            <div class="row">

                                <div class="col-md-6 col-12 mb-4 lvvl">
                                    <label for="duyuruIcerik">Duyuru</label>
                                    <input type="text" class="form-control input" id="duyuruIcerik"
                                        name="duyuruIcerik" value="{{ ayar('duyuruIcerik') }}">
                                </div>
                                <div class="col-md-6 col-12 mb-4 lvvl">
                                    <label for="duyuruButonIcerik">Duyuru Buton İçerik</label>
                                    <input type="text" class="form-control input" id="duyuruButonIcerik"
                                        name="duyuruButonIcerik" value="{{ ayar('duyuruButonIcerik') }}">
                                </div>
                                <div class="col-md-6 col-12 mb-4 lvvl">
                                    <label for="duyuruLink">Duyuru Link</label>
                                    <input type="text" class="form-control input" id="duyuruLink"
                                        name="duyuruLink" value="{{ ayar('duyuruLink') }}">
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-12 mt-4">
            <div class="widget-content widget-content-area form-section">
                <div class="row">
                    <div class="col-xxl-12 col-sm-4 col-12 mx-auto" id="ayarBtnCnt">
                        <button class="btn btn-success w-100" id="ayarBtnSbt" type="button">
                            {{ $btnText }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<script>
    @if (ayar('ustLogo') !== '')
        const ustLogo = "{{ Storage::url(ayar('ustLogo')) . '?v=' . time() }}";
    @endif

    @if (ayar('altLogo') !== '')
        const altLogo = "{{ Storage::url(ayar('altLogo')) . '?v=' . time() }}";
    @endif

    @if (ayar('favicon') !== '')
        const favicon = "{{ Storage::url(ayar('favicon')) . '?v=' . time() }}";
    @endif


    let reklamBanner1ResimUrl = {};
    let reklamBanner2ResimUrl = {};
    let reklamBanner3ResimUrl = {};
    let reklamBanner4ResimUrl = {};
    let reklamBanner5ResimUrl = {};
    let reklamBanner6ResimUrl = {};
    let reklamBanner7ResimUrl = {};


    @foreach ($desteklenenDil as $dil)

        @if (ayar('reklamBanner1Resim-' . $dil) !== '')
            reklamBanner1ResimUrl['{{ $dil }}'] =
                "{{ Storage::url(ayar('reklamBanner1Resim-' . $dil)) . '?v=' . time() }}";
        @endif

        @if (ayar('reklamBanner2Resim-' . $dil) !== '')
            reklamBanner2ResimUrl['{{ $dil }}'] =
                "{{ Storage::url(ayar('reklamBanner2Resim-' . $dil)) . '?v=' . time() }}";
        @endif

        @if (ayar('reklamBanner3Resim-' . $dil) !== '')
            reklamBanner3ResimUrl['{{ $dil }}'] =
                "{{ Storage::url(ayar('reklamBanner3Resim-' . $dil)) . '?v=' . time() }}";
        @endif

        @if (ayar('reklamBanner4Resim-' . $dil) !== '')
            reklamBanner4ResimUrl['{{ $dil }}'] =
                "{{ Storage::url(ayar('reklamBanner4Resim-' . $dil)) . '?v=' . time() }}";
        @endif

        @if (ayar('reklamBanner5Resim-' . $dil) !== '')
            reklamBanner5ResimUrl['{{ $dil }}'] =
                "{{ Storage::url(ayar('reklamBanner5Resim-' . $dil)) . '?v=' . time() }}";
        @endif

        @if (ayar('reklamBanner6Resim-' . $dil) !== '')
            reklamBanner6ResimUrl['{{ $dil }}'] =
                "{{ Storage::url(ayar('reklamBanner6Resim-' . $dil)) . '?v=' . time() }}";
        @endif

        @if (ayar('reklamBanner7Resim-' . $dil) !== '')
            reklamBanner7ResimUrl['{{ $dil }}'] =
                "{{ Storage::url(ayar('reklamBanner7Resim-' . $dil)) . '?v=' . time() }}";
        @endif
    @endforeach
</script>
