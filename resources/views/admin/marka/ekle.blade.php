<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        Marka Ekle
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
                <li class="breadcrumb-item"><a href="{{ route('realpanel.marka.index') }}">Marka</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ekle</li>
            </ol>
        </nav>
    </div>

    
    @include('admin.marka.partials.form', ['btnText' => 'Marka Ekle'])


    <x-slot:footerFiles>
        @vite(['resources/js/pages/admin/marka/ekle.js'])
    </x-slot>

</x-layout.admin>
