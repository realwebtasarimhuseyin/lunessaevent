<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        Sektör Ekle
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
                <li class="breadcrumb-item active" aria-current="page">Ekle</li>
            </ol>
        </nav>
    </div>

    @include('admin.sektor.partials.form', ['btnText' => 'Sektör Ekle'])

    <x-slot:footerFiles>
        <script src="{{ asset('admin/plugins/editors/quill/quill.js') }}"></script>
        @vite(['resources/js/pages/admin/sektor/ekle.js'])
    </x-slot>

</x-layout.admin>
