<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        Kullanıcı Düzenle
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
                <li class="breadcrumb-item"><a href="{{route('realpanel.kullanici.index')}}">Kullanıcı</a></li>
                <li class="breadcrumb-item active" aria-current="page">Düzenle</li>
            </ol>
        </nav>
    </div>

    @include('admin.kullanici.partials.form',["btnText" => "Kullanıcı Düzenle"])

    <x-slot:footerFiles>
        @vite(['resources/js/pages/admin/kullanici/duzenle.js'])
    </x-slot>

</x-layout.admin>
