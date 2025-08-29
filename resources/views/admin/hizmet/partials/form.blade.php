<form id="hizmetForm" onsubmit="(return false)" class="row layout-spacing layout-top-spacing">
    <div class="row w-100">
        <div class="col-12">
            <div class="widget-content widget-content-area form-section mb-4">
                <div class="row">
                    <div class="col-12">
                        <label for="hizmetResim">Hizmet Resim</label>
                        <div class="multiple-file-upload lvvl">
                            <input type="file" class="hizmetResim filepond" id="hizmetResim" name="filepond" />
                        </div>
                    </div>

{{-- 
                    <div class="col-12">
                        <label>Kategori</label>
                        <select class="form-select input" name="hizmetKategori" id="hizmetKategori">
                            <option value="" disabled selected>Hizmet Kategori Seç</option>
                            @foreach ($hizmetKategoriler as $hizmetKategori)
                                @php
                                    $hizmetKategoriDilVerisi = $hizmetKategori->hizmetKategoriDiller
                                        ->where('dil', $aktifDil)
                                        ->first();
                                @endphp
                                <option value="{{ $hizmetKategori->id }}"
                                    {{ isset($hizmet) && $hizmet->hizmet_kategori_id == $hizmetKategori->id ? 'selected' : '' }}>
                                    {{ $hizmetKategoriDilVerisi->isim }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                </div>
            </div>

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
                            $dilVerisi = isset($hizmet) ? $hizmet->hizmetDiller->where('dil', $dil)->first() : null;
                        @endphp

                        <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}"
                            id="pills-{{ $dil }}" role="tabpanel"
                            aria-labelledby="pills-{{ $dil }}-tab" tabindex="0">
                            <div class="widget-content widget-content-area form-section  mb-4">
                                <div class="row mb-4">
                                    <div class="col-xxl-12 lvvl">
                                        <label for="baslik">Hizmet Başlık</label>
                                        <input type="text" class="form-control input"
                                            name="baslik-{{ $dil }}" id="baslik-{{ $dil }}"
                                            placeholder="Hizmet Başlık" value="{{ $dilVerisi->baslik ?? '' }}">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-xxl-12 lvvl">
                                        <label for="kisaIcerik-{{ $dil }}">Hizmet Kısa İçerik</label>
                                        <textarea type="text" class="form-control input" name="kisaIcerik-{{ $dil }}"
                                            id="kisaIcerik-{{ $dil }}" placeholder="Hizmet Kısa İçerik">{{ $dilVerisi->kisa_icerik ?? '' }}</textarea>
                                    </div>
                                </div>

                                 <div class="row mb-4">
                                    <div class="col-sm-12 lvvl">
                                        <label>İçerik</label>
                                        <div id="hizmetIcerik-{{ $dil }}"
                                            name="icerik-{{ $dil }}" class="input"></div>
                                    </div>
                                </div>

                            </div>

                            <div class="widget-content widget-content-area form-section my-4">
                                <h5 class="mb-4">SEO Ayarları</h5>
                                <div class="row mb-4">
                                    <div class="col-xxl-12 mb-4 lvvl">
                                        <label>Meta Başlık</label>
                                        <input type="text" class="form-control input"
                                            name="metaBaslik-{{ $dil }}" id="metaBaslik-{{ $dil }}"
                                            placeholder="Meta Başlık" value="{{ $dilVerisi->meta_baslik ?? '' }}">
                                    </div>
                                    <div class="col-xxl-12 mb-4 lvvl">
                                        <label>Meta Anahtar</label>
                                        <input type="text" class="form-control input"
                                            name="metaAnahtar-{{ $dil }}"
                                            id="metaAnahtar-{{ $dil }}" placeholder="Meta Anahtar"
                                            value="{{ $dilVerisi->meta_anahtar ?? '' }}">
                                    </div>
                                    <div class="col-xxl-12 lvvl">
                                        <label for="metaIcerik">Meta Açıklama</label>
                                        <textarea class="form-control input" name="metaIcerik-{{ $dil }}" id="metaIcerik-{{ $dil }}"
                                            cols="10" rows="5">{{ $dilVerisi->meta_icerik ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="widget-content widget-content-area form-section mb-4">
                <div class="row">
                    <div class="col-xxl-12 mb-4 lvvl">
                        <div class="switch form-switch-custom switch-inline form-switch-primary">
                            <input class="switch-input input" type="checkbox" role="switch" id="durum" checked>
                            <label class="switch-label" for="durum">Hizmet Durum</label>
                        </div>
                    </div>
                    <div class="col-xxl-12 col-sm-4 col-12 mx-auto" id="hizmetBtnCnt">
                        <button class="btn btn-success w-100" id="hizmetBtnSbt" type="button">
                            {{ $btnText }}
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</form>



@isset($hizmet)
    <script>
        const hizmetId = {{ $hizmet->id }};
        const hizmetIcerik = {};

        const hizmetResimUrl = "{{ Storage::url($hizmet->resim_url) }}";

        @foreach ($desteklenenDil as $dil)
            @php
                $dilVerisi = $hizmet->hizmetDiller->where('dil', $dil)->first();
            @endphp

            @if ($dilVerisi)
                hizmetIcerik['{{ $dil }}'] = {!! json_encode($dilVerisi->icerik) !!};
            @else
                hizmetIcerik['{{ $dil }}'] = "";
            @endif
        @endforeach
    </script>
@endisset
