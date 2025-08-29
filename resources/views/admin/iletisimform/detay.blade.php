<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        İletişim Form Detay
    </x-slot>

    <x-slot:headerFiles>
        <link rel="stylesheet" href="{{ asset('admin/plugins/tagify/tagify.css') }}">
        @vite(['resources/scss/light/form.scss'])
        @vite(['resources/scss/dark/form.scss'])
    </x-slot>

    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('realpanel.iletisimform.index') }}">İletişim Form</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detay</li>
            </ol>
        </nav>
    </div>

    <div class="row mb-4 layout-spacing layout-top-spacing">
        <div class="col-12">
            <div class="widget-content widget-content-area form-section">
                <div class="row">
                    <div class="col-xxl-6 col-md-12">
                        <label for="">İsim</label>
                        <p> {{ $iletisimForm->isim ?? '' }} </p>
                    </div>

                    <div class="col-xxl-6 col-md-12 mb-4">
                        <label for="">Eposta</label>
                        <p> {{ $iletisimForm->eposta ?? '' }} </p>
                    </div>

                    <div class="col-xxl-6 col-md-12 mb-4">
                        <label for="">Telefon</label>
                        <p> {{ $iletisimForm->telefon ?? '' }} </p>
                    </div>

                    <div class="col-12 mb-4">
                        <label for="">Mesaj</label>
                        <p> {{ $iletisimForm->mesaj ?? '' }} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot:footerFiles>
    </x-slot>

</x-layout.admin>
