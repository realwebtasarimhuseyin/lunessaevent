<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        Ayar Düzenle
    </x-slot>

    <x-slot:headerFiles>
        @vite(['resources/scss/light/assets/forms/switches.scss', 'resources/scss/light/form.scss', 'resources/scss/dark/assets/forms/switches.scss', 'resources/scss/dark/form.scss'])
    </x-slot>

    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('realpanel.ayar.index') }}">Ayarlar</a></li>
            </ol>
        </nav>
    </div>

    @include('admin.ayar.partials.form', ['btnText' => 'Ayarları Düzenle'])

    <x-slot:footerFiles>
        @vite(['resources/js/pages/admin/ayar/index.js'])
    </x-slot>

</x-layout.admin>
