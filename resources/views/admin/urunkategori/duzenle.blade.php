<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        Ürün Kategori Düzenle
    </x-slot>

    <x-slot:headerFiles>
        <link rel="stylesheet" href="{{ asset('admin/plugins/filepond/filepond.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/plugins/filepond/FilePondPluginImagePreview.min.css') }}">

        @vite(['resources/scss/light/assets/forms/switches.scss'])
        @vite(['resources/scss/light/form.scss'])

        @vite(['resources/scss/dark/assets/forms/switches.scss'])
        @vite(['resources/scss/dark/form.scss'])
    </x-slot>

    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('realpanel.urunkategori.index')}}">Ürün Kategori</a></li>
                <li class="breadcrumb-item active" aria-current="page">Düzenle</li>
            </ol>
        </nav>
    </div>

    @include('admin.urunkategori.partials.form',["btnText" => "Ürün Kategori Düzenle"])

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

        @vite(['resources/js/pages/admin/urunKategori/duzenle.js'])
    </x-slot>

</x-layout.admin>
