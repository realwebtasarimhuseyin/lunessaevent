<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        Katalog Kategori Ekle
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
     

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
                <li class="breadcrumb-item"><a href="{{ route('realpanel.katalogkategori.index') }}">Katalog
                        Kategori</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ekle</li>
            </ol>
        </nav>
    </div>

    @include('admin.katalogkategori.partials.form', ['btnText' => 'Katalog Kategori Ekle'])

    <x-slot:footerFiles>
        @vite(['resources/js/pages/admin/katalogKategori/ekle.js'])
    </x-slot>

</x-layout.admin>
