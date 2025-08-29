<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
       SSS Düzenle
    </x-slot>

    <x-slot:headerFiles>
        <link rel="stylesheet" href="{{asset('admin/plugins/froala/froala_editor.pkgd.min.css')}}">
        @vite(['resources/scss/light/assets/forms/switches.scss', 'resources/scss/light/form.scss', 'resources/scss/dark/assets/forms/switches.scss', 'resources/scss/dark/form.scss'])
    </x-slot>


    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('realpanel.sss.index') }}">SSS</a></li>
                <li class="breadcrumb-item active" aria-current="page">Düzenle</li>
            </ol>
        </nav>
    </div>

    @include('admin.sss.partials.form', ['btnText' => 'S.s.s Düzenle'])

    <x-slot:footerFiles>
        <script src="{{asset('admin/plugins/froala/froala_editor.pkgd.min.js')}}"></script>
        <script src="{{asset('admin/plugins/froala/languages/tr.js')}}"></script>

        @vite(['resources/js/pages/admin/sss/duzenle.js'])
    </x-slot>

</x-layout.admin>
