<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        Ürün Kdv Düzenle
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->

        @vite(['resources/scss/light/assets/forms/switches.scss'])
        @vite(['resources/scss/light/form.scss'])

        @vite(['resources/scss/dark/assets/forms/switches.scss'])
        @vite(['resources/scss/dark/form.scss'])

        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('realpanel.urunkdv.index') }}">Ürün Kdv</a></li>
                <li class="breadcrumb-item active" aria-current="page">Düzenle</li>
            </ol>
        </nav>
    </div>
    <!-- /BREADCRUMB -->

    @include('admin.urunkdv.partials.form', ['btnText' => 'Ürün Kdv Düzenle'])

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        @vite(['resources/js/pages/admin/urunKdv/duzenle.js'])
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-layout.admin>
