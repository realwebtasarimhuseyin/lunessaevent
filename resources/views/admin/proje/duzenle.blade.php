<x-layout.admin :scrollspy="false">
    <x-slot:pageTitle>
        Proje Düzenle
    </x-slot>

    <x-slot:headerFiles>

        <link rel="stylesheet" href="{{ asset('admin/plugins/filepond/filepond.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/plugins/filepond/FilePondPluginImagePreview.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/plugins/filepond/FilepondPluginMediaPreview.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/plugins/tomSelect/tom-select.default.min.css') }}">

        @vite(['resources/scss/light/assets/forms/switches.scss'])
        @vite(['resources/scss/light/plugins/editors/quill/quill.snow.scss'])
        @vite(['resources/scss/light/plugins/editors/quill/quill.snow.scss'])
        @vite(['resources/scss/light/plugins/tagify/custom-tagify.scss'])
        @vite(['resources/scss/light/form.scss'])
        @vite(['resources/scss/dark/assets/forms/switches.scss'])
        @vite(['resources/scss/dark/plugins/editors/quill/quill.snow.scss'])
        @vite(['resources/scss/dark/plugins/editors/quill/quill.snow.scss'])
        @vite(['resources/scss/dark/plugins/tagify/custom-tagify.scss'])
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
                <li class="breadcrumb-item active" aria-current="page">Düzenle</li>
            </ol>
        </nav>
    </div>

    @include('admin.proje.partials.form', ['btnText' => 'Proje Düzenle'])

    <x-slot:footerFiles>
        <script src="{{ asset('admin/plugins/editors/quill/quill.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/filepond.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/FilePondPluginFileValidateType.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/FilePondPluginImageExifOrientation.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/FilePondPluginImagePreview.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/FilePondPluginImageCrop.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/FilePondPluginImageResize.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/FilePondPluginImageTransform.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/FilepondPluginFileValidateSize.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/FilepondPluginMediaPreview.js') }}"></script>

        <script src="{{ asset('admin/plugins/tomSelect/tom-select.base.js') }}"></script>
        <script src="{{ asset('admin/plugins/flatpickr/flatpickr.js') }}"></script>
        <script src="{{ asset('admin/plugins/flatpickr/tr.js') }}"></script>

        @vite(['resources/js/pages/admin/proje/duzenle.js'])
    </x-slot>
</x-layout.admin>
