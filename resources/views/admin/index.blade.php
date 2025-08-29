<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        Admin Panel
    </x-slot>

    <x-slot:headerFiles>
        <link rel="stylesheet" href="{{ asset('admin/plugins/apex/apexcharts.css') }}">
        @vite(['resources/scss/light/assets/components/list-group.scss','resources/scss/light/assets/widgets/modules-widgets.scss','resources/scss/dark/assets/components/list-group.scss','resources/scss/dark/assets/widgets/modules-widgets.scss'])
    </x-slot>


    <div class="row layout-top-spacing">

        <div class="col-12 layout-spacing">
            <x-admin.widgets._w-chart-one title="Yıllık Toplam Ziyaretler" />
        </div>

        <div class="col-12 layout-spacing">
            <x-admin.widgets._w-chart-three title="Yıllık Cihaz Kullanımları" />
        </div>

        <div class="col-md-6 layout-spacing">
            <x-admin.widgets._w-four title="Tarayıcı Girişleri" :populerTarayicilar="$populerTarayicilar" />
        </div>

        <div class="col-md-6 layout-spacing">
            <x-admin.widgets._w-table-one title="Toplam Veriler" :toplamVeriler="$toplamVeriler" />
        </div>

        <div class="col-12 layout-spacing">
            <x-admin.widgets._w-table-three title="Populer ilk 20 Sayfa" :populerSayfalar="$populerSayfalar" />
        </div>
    </div>

    <x-slot:footerFiles>
        <script src="{{ asset('admin/plugins/apex/apexcharts.min.js') }}"></script>
        <script>
            const toplamGiris = {{ $toplamZiyaret }};
            const yillikZiyaretVerileri = {{ Js::from($yillikZiyaretVerileri) }};
            const cihazVerileri = {{ Js::from($cihazVerileri) }};
        </script>

        @vite(['resources/js/custom/widgets/_wChartOne.js','resources/js/custom/widgets/_wChartThree.js'])
    </x-slot>
</x-layout.admin>
