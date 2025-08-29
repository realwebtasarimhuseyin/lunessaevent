<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        Hizmet Kategori Ekle
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
                <li class="breadcrumb-item"><a href="{{route('realpanel.hizmetkategori.index')}}">Hizmet Kategori</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ekle</li>
            </ol>
        </nav>
    </div>

    @include('admin.hizmetkategori.partials.form',["btnText" => "Hizmet Kategori Ekle"])

    <x-slot:footerFiles>
        @vite(['resources/js/pages/admin/hizmetKategori/ekle.js'])
    </x-slot>

</x-layout.admin>
