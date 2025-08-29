<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        Ürün Düzenle
    </x-slot>

    <x-slot:headerFiles>
        <link rel="stylesheet" href="{{asset('admin/plugins/froala/froala_editor.pkgd.min.css')}}">
        @vite(['resources/scss/light/assets/forms/switches.scss', 'resources/scss/light/form.scss', 'resources/scss/dark/assets/forms/switches.scss', 'resources/scss/dark/form.scss'])
    </x-slot>

    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('realpanel.urun.index') }}">Ürün</a></li>
                <li class="breadcrumb-item active" aria-current="page">Düzenle</li>
            </ol>
        </nav>
    </div>


    @include('admin.urun.partials.form', ['btnText' => 'Ürün Düzenle'])

    <x-slot:footerFiles>
        <script src="{{asset('admin/plugins/froala/froala_editor.pkgd.min.js')}}"></script>
        <script src="{{asset('admin/plugins/froala/languages/tr.js')}}"></script>

        <script>
            secilenVaryantlar = $('#varyant-secim input:checked').map((_, cb) => cb.value).get();
        </script>
        @vite(['resources/js/pages/admin/urun/duzenle.js'])
    </x-slot>

</x-layout.admin>
