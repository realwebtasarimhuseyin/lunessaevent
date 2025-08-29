<x-layout.admin :scrollspy="false">
    <x-slot:pageTitle>
        Proje Ekle
    </x-slot>

    <x-slot:headerFiles>
        <link rel="stylesheet" href="{{asset('admin/plugins/froala/froala_editor.pkgd.min.css')}}">
        @vite(['resources/scss/light/assets/forms/switches.scss'])
        @vite(['resources/scss/light/plugins/editors/quill/quill.snow.scss'])
        @vite(['resources/scss/light/plugins/editors/quill/quill.snow.scss'])
        @vite(['resources/scss/light/form.scss'])
        @vite(['resources/scss/dark/assets/forms/switches.scss'])
        @vite(['resources/scss/dark/plugins/editors/quill/quill.snow.scss'])
        @vite(['resources/scss/dark/plugins/editors/quill/quill.snow.scss'])
        @vite(['resources/scss/dark/form.scss'])

        <link rel="stylesheet" href="{{ asset('admin/plugins/flatpickr/flatpickr.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/plugins/noUiSlider/nouislider.min.css') }}">
        @vite(['resources/scss/light/plugins/flatpickr/custom-flatpickr.scss'])
        @vite(['resources/scss/dark/plugins/flatpickr/custom-flatpickr.scss'])

    </x-slot>
    
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('realpanel.proje.index') }}">Proje</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ekle</li>
            </ol>
        </nav>
    </div>

    @include('admin.proje.partials.form', ['btnText' => 'Proje Ekle'])

    <x-slot:footerFiles>
        <script src="{{asset('admin/plugins/froala/froala_editor.pkgd.min.js')}}"></script>
        <script src="{{asset('admin/plugins/froala/languages/tr.js')}}"></script>


        <script src="{{ asset('admin/plugins/flatpickr/flatpickr.js') }}"></script>
        <script src="{{ asset('admin/plugins/flatpickr/tr.js') }}"></script>
        @vite(['resources/js/pages/admin/proje/ekle.js'])
    </x-slot>

</x-layout.admin>
