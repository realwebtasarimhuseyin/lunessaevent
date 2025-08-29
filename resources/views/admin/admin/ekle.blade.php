<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        Admin Ekle
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
                <li class="breadcrumb-item"><a href="{{route('realpanel.admin.index')}}">Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ekle</li>
            </ol>
        </nav>
    </div>

    @include('admin.admin.partials.form',["btnText" => "Admin Ekle"])

    <x-slot:footerFiles>
        @vite(['resources/js/pages/admin/admin/ekle.js'])
    </x-slot>

</x-layout.admin>
