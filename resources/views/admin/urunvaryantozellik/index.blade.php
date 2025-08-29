<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        Ürün Varyant Özellik Liste
    </x-slot>

    <x-slot:headerFiles>
        <link rel="stylesheet" href="{{ asset('admin/plugins/table/datatable/datatables.css') }}">
        @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss', 'resources/scss/dark/plugins/table/datatable/dt-global_style.scss', 'resources/scss/light/plugins/table/datatable/custom_dt_custom.scss', 'resources/scss/dark/plugins/table/datatable/custom_dt_custom.scss'])
    </x-slot>

    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Ürün Varyant Özellik</li>
                <li class="breadcrumb-item active" aria-current="page">Liste</li>
            </ol>
        </nav>
    </div>

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <table id="urunVaryantOzellikDataTable" class="table style-3 dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sıra No</th>
                            <th>Oluşturulma Tarih</th>
                            <th>Varyant İsim</th>
                            <th>Özellik İsim</th>
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
        @vite(['resources/js/pages/admin/urunVaryantOzellik/index.js'])
    </x-slot>

</x-layout.admin>
