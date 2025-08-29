<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        Ürün Ozellik Düzenle
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
                <li class="breadcrumb-item"><a href="{{ route('realpanel.urunozellik.index') }}">Ürün Ozellik</a></li>
                <li class="breadcrumb-item active" aria-current="page">Düzenle</li>
            </ol>
        </nav>
    </div>

    @include('admin.urunozellik.partials.form', ['btnText' => 'Ürün Ozellik Düzenle'])

    <x-slot:footerFiles>
        @vite(['resources/js/pages/admin/urunOzellik/duzenle.js'])
    </x-slot>

</x-layout.admin>
