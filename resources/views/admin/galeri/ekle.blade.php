<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        Galeri Ekle
    </x-slot>

    <x-slot:headerFiles>
        @vite(['resources/scss/light/assets/forms/switches.scss'])
        @vite(['resources/scss/light/form.scss'])
        @vite(['resources/scss/dark/assets/forms/switches.scss'])
        @vite(['resources/scss/dark/form.scss'])
    </x-slot>

    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/galeri/">Galeri</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ekle</li>
            </ol>
        </nav>
    </div>

    @include('admin.galeri.partials.form',["btnText" => "Galeri Ekle"])

    <x-slot:footerFiles>
        @vite(['resources/js/pages/admin/galeri/ekle.js'])
    </x-slot>

</x-layout.admin>
