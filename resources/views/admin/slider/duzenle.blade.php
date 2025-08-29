<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        Slider Düzenle
    </x-slot>

    <x-slot:headerFiles>
        <link rel="stylesheet" href="{{ asset('admin/plugins/filepond/filepond.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/plugins/filepond/FilePondPluginImagePreview.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/plugins/filepond/FilepondPluginMediaPreview.css') }}">

        @vite(['resources/scss/light/assets/forms/switches.scss', 'resources/scss/light/form.scss', 'resources/scss/dark/assets/forms/switches.scss', 'resources/scss/dark/form.scss'])

    </x-slot>

    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/slider/">Slider</a></li>
                <li class="breadcrumb-item active" aria-current="page">Düzenle</li>
            </ol>
        </nav>
    </div>

    @include('admin.slider.partials.form', ['btnText' => 'Slider Düzenle'])

    <x-slot:footerFiles>
        <script src="{{ asset('admin/plugins/filepond/filepond.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/FilePondPluginFileValidateType.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/FilePondPluginImageExifOrientation.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/FilePondPluginImagePreview.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/FilePondPluginImageCrop.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/FilePondPluginImageResize.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/FilePondPluginImageTransform.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/FilepondPluginFileValidateSize.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/FilepondPluginMediaPreview.js') }}"></script>

        @vite(['resources/js/pages/admin/slider/duzenle.js'])
    </x-slot>
</x-layout.admin>
