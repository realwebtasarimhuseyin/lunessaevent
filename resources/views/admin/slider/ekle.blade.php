<x-layout.admin :scrollspy="false">

    <x-slot:pageTitle>
        Slider Ekle
    </x-slot>

    <x-slot:headerFiles>


        @vite(['resources/scss/light/assets/forms/switches.scss', 'resources/scss/light/form.scss', 'resources/scss/dark/assets/forms/switches.scss', 'resources/scss/dark/form.scss'])

    </x-slot>

    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/slider/">Slider</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ekle</li>
            </ol>
        </nav>
    </div>

    @include('admin.slider.partials.form', ['btnText' => 'Slider Ekle'])

    <x-slot:footerFiles>
      

        @vite(['resources/js/pages/admin/slider/ekle.js'])
    </x-slot>
</x-layout.admin>
