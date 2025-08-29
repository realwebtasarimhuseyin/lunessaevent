<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        Ürün Kategori Ekle
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" href="{{ asset('admin/plugins/filepond/filepond.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/plugins/filepond/FilePondPluginImagePreview.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/plugins/tagify/tagify.css') }}">

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

        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('realpanel.urunkategori.index')}}">Ürün Kategori</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ekle</li>
            </ol>
        </nav>
    </div>
    <!-- /BREADCRUMB -->

    @include('admin.urunkategori.partials.form',["btnText" => "Ürün Kategori Ekle"])

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
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
        <script src="{{ asset('admin/plugins/tagify/tagify.min.js') }}"></script>

        @vite(['resources/js/pages/admin/urunKategori/ekle.js'])
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-layout.admin>
