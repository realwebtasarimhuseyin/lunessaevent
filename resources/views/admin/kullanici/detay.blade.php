<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        Kullanıcı Detay
    </x-slot>

    <x-slot:headerFiles>
        <link rel="stylesheet" href="{{ asset('admin/plugins/tagify/tagify.css') }}">

        @vite(['resources/scss/light/assets/forms/switches.scss'])
        @vite(['resources/scss/light/plugins/tagify/custom-tagify.scss'])
        @vite(['resources/scss/light/form.scss'])

        @vite(['resources/scss/dark/assets/forms/switches.scss'])
        @vite(['resources/scss/dark/plugins/tagify/custom-tagify.scss'])
        @vite(['resources/scss/dark/form.scss'])
    </x-slot>

    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('realpanel.kullanici.index') }}">Kullanıcı</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detay</li>
            </ol>
        </nav>
    </div>

    <div class="row mb-4 layout-spacing layout-top-spacing">
        <div class="col-12">
            <div class="widget-content widget-content-area form-section">
                <div class="row">
                    <div class="col-xxl-6 col-md-12">
                        <label for="">İsim</label>
                        <p> {{ $kullanici->isim ?? '' }} </p>
                    </div>

                    <div class="col-xxl-6 col-md-12 mb-4">
                        <label for="">Soyisim</label>
                        <p> {{ $kullanici->soyisim ?? '' }} </p>
                    </div>

                    <div class="col-xxl-6 col-md-12 mb-4">
                        <label for="">Eposta</label>
                        <p> {{ $kullanici->eposta ?? '' }} </p>
                    </div>

                    <div class="col-xxl-6 col-md-12 mb-4">
                        <label for="">Telefon</label>
                        <p> {{ $kullanici->telefon ?? '' }} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="simple-pill">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-favori-tab" data-bs-toggle="pill" data-bs-target="#pills-favori"
                            type="button" role="tab" aria-controls="pills-favori" aria-selected="true">
                            Favori
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-sepet-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-sepet" type="button" role="tab" aria-controls="pills-sepet"
                            aria-selected="true">
                            Sepet
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-favori" role="tabpanel"
                        aria-labelledby="pills-favori-tab" tabindex="0">
                        <div class="widget-content widget-content-area form-section">
                            <div class="row mb-4">
                                <table id="kullaniciFavoriDataTable" class="table dt-table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 100px; max-width:100px; min-width:100px;">Eklenme Tarih
                                            </th>
                                            <th>Ürün İsim</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kullanici->favori as $favori)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($favori->created_at)->format('d.m.Y H:i') }}
                                                </td>
                                                <td>{{ $favori->urun->urunDiller->where('dil', $aktifDil)->first()->baslik }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-sepet" role="tabpanel" aria-labelledby="pills-sepet-tab"
                        tabindex="0">
                        <div class="widget-content widget-content-area form-section">
                            <div class="row mb-4">
                                <table id="kullaniciSepetDataTable" class="table dt-table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 100px; max-width:100px; min-width:100px;">Eklenme Tarih
                                            </th>
                                            <th>Ürün İsim</th>
                                            <th>Adet</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kullanici->sepet as $sepet)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($sepet->created_at)->format('d.m.Y H:i') }}
                                                </td>
                                                <td>{{ $sepet->urun->urunDiller->where('dil', $aktifDil)->first()->baslik }}
                                                </td>
                                                <td>{{ $sepet->adet }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot:footerFiles>
    </x-slot>

</x-layout.admin>
