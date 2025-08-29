<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        Ürün Liste
    </x-slot>

    <x-slot:headerFiles>
        <link rel="stylesheet" href="{{ asset('admin/plugins/table/datatable/datatables.css') }}">
        @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss', 'resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
        <link rel="stylesheet" href="{{ asset('admin/plugins/tomSelect/tom-select.default.min.css') }}">

        @vite(['resources/scss/light/plugins/tomSelect/custom-tomSelect.scss', 'resources/scss/dark/plugins/tomSelect/custom-tomSelect.scss'])

    </x-slot>

    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Ürün</li>
                <li class="breadcrumb-item active" aria-current="page">Liste</li>
            </ol>
        </nav>
    </div>

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <div class="row justify-content-between align-content-center p-3">

                    <div class="col-md-auto col-12">
                        <input type="text" placeholder="Tabloda Ara" name="tablo-ara"
                            class="form-control tablo-filtre tablo-ara">
                    </div>

                    <div class="col-md-auto col-12">
                        <div class="d-md-flex gap-md-2">

                            <div class="mt-md-0 mt-2">
                                <select name="tablo-durum" class="tablo-filtre filter-select-custom w-100"
                                    placeholder="Durum Seçiniz" autocomplete="off" id="durum">
                                    <option value="">Durum Seçiniz</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Pasif</option>
                                </select>
                            </div>

                            <div class="mt-md-0 mt-2">
                                <select name="tablo-kategori" class="tablo-filtre filter-select-custom w-100"
                                    placeholder="Kategori Seçiniz" autocomplete="off" id="kategoriler">
                                    <option value="">Kategori Seçiniz</option>
                                    @foreach ($urunKategoriler as $urunKategori)
                                        @php
                                            $dilVerisi = $urunKategori->urunKategoriDiller->where('dil', 'tr')->first();
                                        @endphp
                                        <option value="{{ $urunKategori->id }}">
                                            {{ $dilVerisi->isim }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <table id="urunDataTable" class="table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sıra No</th>
                            <th>Oluşturulma Tarih</th>
                            <th>Başlık</th>
                            <th>Sepet Adet</th>
                            <th>Durum</th>
                            <th class="no-content text-center">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <x-slot:footerFiles>
        <script type="module" src="{{ asset('admin/plugins/global/vendors.min.js') }}"></script>
        @vite(['resources/js/custom/custom.js'])

        <script type="module" src="{{ asset('admin/plugins/table/datatable/datatables.js') }}"></script>
        <script type="module" src="{{ asset('admin/plugins/table/datatable/reorder.js') }}"></script>
        <script src="{{ asset('admin/plugins/tomSelect/tom-select.base.js') }}"></script>

        @vite(['resources/js/pages/admin/urun/index.js']);

        <script>
            new TomSelect("#kategoriler", {
                maxItems: 1,
                plugins: ['clear_button'],
                render: {
                    no_results: function(data, escape) {
                        return '<div class="no-results">Bulamadık</div>';
                    },
                }
            });

            new TomSelect("#durum", {
                maxItems: 1,
                plugins: ['clear_button']
            });
        </script>
    </x-slot>

</x-layout.admin>
