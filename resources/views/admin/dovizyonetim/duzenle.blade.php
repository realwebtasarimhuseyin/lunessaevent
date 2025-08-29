<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        Döviz Yönetim Düzenle
    </x-slot>

    <x-slot:headerFiles>
        @vite(['resources/scss/light/assets/forms/switches.scss', 'resources/scss/light/form.scss', 'resources/scss/dark/assets/forms/switches.scss', 'resources/scss/dark/form.scss'])
    </x-slot>

    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('realpanel.dovizyonetim.index') }}">Döviz Yönetim</a></li>
                <li class="breadcrumb-item active" aria-current="page">Düzenle</li>
            </ol>
        </nav>
    </div>

    @include('admin.dovizyonetim.partials.form', ['btnText' => 'Döviz Yönetim Düzenle'])

    <x-slot:footerFiles>
        @vite(['resources/js/pages/admin/dovizYonetim/duzenle.js'])
    </x-slot>
</x-layout.admin>
