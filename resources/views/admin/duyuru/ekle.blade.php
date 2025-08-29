<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        Duyuru Ekle
    </x-slot>

    <x-slot:headerFiles>
        <link rel="stylesheet" href="{{ asset('admin/plugins/filepond/filepond.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/plugins/filepond/FilePondPluginImagePreview.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/plugins/tagify/tagify.css') }}">

        @vite(['resources/scss/light/assets/forms/switches.scss'])
        @vite(['resources/scss/light/form.scss'])

        @vite(['resources/scss/dark/assets/forms/switches.scss'])
        @vite(['resources/scss/dark/form.scss'])

    </x-slot>

    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('realpanel.duyuru.index')}}">Duyuru</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ekle</li>
            </ol>
        </nav>
    </div>

    @include('admin.duyuru.partials.form',["btnText" => "Duyuru Ekle"])

    <x-slot:footerFiles>
        @vite(['resources/js/pages/admin/duyuru/ekle.js'])
    </x-slot>
</x-layout.admin>
