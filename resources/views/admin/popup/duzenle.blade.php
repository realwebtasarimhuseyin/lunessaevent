<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        Popup Düzenle
    </x-slot>

    <x-slot:headerFiles>
       
        @vite(['resources/scss/light/assets/forms/switches.scss'])
        @vite(['resources/scss/light/form.scss'])

        @vite(['resources/scss/dark/assets/forms/switches.scss'])
        @vite(['resources/scss/dark/form.scss'])

        <link rel="stylesheet" href="{{ asset('admin/plugins/flatpickr/flatpickr.css') }}">
        @vite(['resources/scss/light/plugins/flatpickr/custom-flatpickr.scss'])
        @vite(['resources/scss/dark/plugins/flatpickr/custom-flatpickr.scss'])

    </x-slot>

    
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('realpanel.popup.index') }}">Popup</a></li>
                <li class="breadcrumb-item active" aria-current="page">Düzenle</li>
            </ol>
        </nav>
    </div>

    
    @include('admin.popup.partials.form', ['btnText' => 'Popup Düzenle'])


    <x-slot:footerFiles>
        <script src="{{ asset('admin/plugins/flatpickr/flatpickr.js') }}"></script>
        <script src="{{ asset('admin/plugins/flatpickr/tr.js') }}"></script>

        @vite(['resources/js/pages/admin/popup/duzenle.js'])
    </x-slot>

</x-layout.admin>
