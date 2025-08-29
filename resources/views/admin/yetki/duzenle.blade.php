<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        Yetki Düzenle
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
                <li class="breadcrumb-item"><a href="{{route('realpanel.yetki.index')}}">Yetki</a></li>
                <li class="breadcrumb-item active" aria-current="page">Düzenle</li>
            </ol>
        </nav>
    </div>

    @include('admin.yetki.partials.form',["btnText" => "Yetki Düzenle"])

    <x-slot:footerFiles>
        @vite(['resources/js/pages/admin/yetki/duzenle.js'])
    </x-slot>

</x-layout.admin>
