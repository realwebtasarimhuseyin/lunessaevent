<form id="yorumForm" onsubmit="(return false)" class="row mb-4 layout-spacing layout-top-spacing">
    <div class="col-xxl-12">
        <div class="row mb-4">
            <div class="col-xxl-12 col-md-12 mb-4">
                <label for="product-images">Kişi Profil</label>
                <div class="multiple-file-upload lvvl">
                    <input type="file" class="file-upload-multiple" id="product-images" name="filepond" />
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-xxl-12 lvvl">
                <label for="baslik">Kişi İsim</label>
                <input type="text" class="form-control input" name="kisiIsim" id="kisiIsim" placeholder="Kişi İsim"
                    value="{{ $yorum->kisi_isim ?? '' }}">
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-xxl-12 lvvl">
                <label for="baslik">Kişi Ünvan</label>
                <input type="text" class="form-control input" name="kisiUnvan" id="kisiUnvan"
                    placeholder="Kişi Ünvan" value="{{ $yorum->kisi_unvan ?? '' }}">
            </div>
        </div>
        <div class="widget-content widget-content-area form-section mb-4">
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
                            $dilVerisi = isset($yorum) ? $yorum->yorumDiller->where('dil', $dil)->first() : null;
                        @endphp
                        <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}"
                            id="pills-{{ $dil }}" role="tabpanel"
                            aria-labelledby="pills-{{ $dil }}-tab" tabindex="0">

                            <div class="row mb-4">
                                <div class="col-xxl-12 lvvl">
                                    <label for="icerik">Yorum İçerik</label>
                                     <div id="icerik-{{ $dil }}" name="icerik-{{ $dil }}"
                                        class="input"></div> 
                                         
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area form-section">
            <div class="row mb-4">
                <div class="col-xxl-12 mb-4 lvvl">
                    <div class="switch form-switch-custom switch-inline form-switch-primary">
                        <input class="switch-input input" type="checkbox" role="switch" id="durum" checked>
                        <label class="switch-label" for="durum">Yorum Durum</label>
                    </div>
                </div>
                <div class="col-xxl-12 col-sm-4 col-12 mx-auto" id="yorumBtnCnt">
                    <button class="btn btn-success w-100" id="yorumBtnSbt" type="button">
                        {{ $btnText }}
                    </button>
                </div>
            </div>
        </div>

    </div>
</form>

@isset($yorum)
    <script>
        const yorumId = {{ $yorum->id }};
        const yorumIcerik = {};
        const resimUrl = "{{ Storage::url($yorum->resim_url) }}";

        @foreach ($desteklenenDil as $dil)
            @php
                $dilVerisi = $yorum->yorumDiller->where('dil', $dil)->first();
            @endphp

            @if ($dilVerisi)
                yorumIcerik['{{ $dil }}'] = {!! json_encode($dilVerisi->icerik) !!};
            @else
                yorumIcerik['{{ $dil }}'] = "";
            @endif
        @endforeach
    </script>
@endisset
