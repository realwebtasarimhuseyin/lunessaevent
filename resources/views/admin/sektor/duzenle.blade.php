<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        Sektör Düzenle
    </x-slot>

    <x-slot:headerFiles>
        @vite(['resources/scss/light/assets/forms/switches.scss'])
        @vite(['resources/scss/light/plugins/editors/quill/quill.snow.scss'])
        @vite(['resources/scss/light/plugins/editors/quill/quill.snow.scss'])
        @vite(['resources/scss/light/form.scss'])

        @vite(['resources/scss/dark/assets/forms/switches.scss'])
        @vite(['resources/scss/dark/plugins/editors/quill/quill.snow.scss'])
        @vite(['resources/scss/dark/plugins/editors/quill/quill.snow.scss'])
        @vite(['resources/scss/dark/form.scss'])

    </x-slot>

    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('realpanel.sektor.index') }}">Sektör</a></li>
                <li class="breadcrumb-item active" aria-current="page">Düzenle</li>
            </ol>
        </nav>
    </div>

    @include('admin.sektor.partials.form', ['btnText' => 'Sektör Düzenle'])

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

        @vite(['resources/js/pages/admin/sektor/duzenle.js'])
    </x-slot>

</x-layout.admin>
