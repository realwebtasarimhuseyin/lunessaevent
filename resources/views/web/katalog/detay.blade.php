<x-layout.web>
    @php
        $hizmetDilVerisi = $hizmet->hizmetDiller->where('dil', $aktifDil)->first();
    @endphp

    <x-slot:baslik>
        {{ ayar('siteBaslik', $aktifDil) . ' | ' . $hizmetDilVerisi->baslik }}
    </x-slot>
    <x-slot:aciklama>
        {{ $hizmetDilVerisi->meta_icerik }}
    </x-slot>
    <x-slot:anahtar>
        {{ $hizmetDilVerisi->meta_anahtar }}
    </x-slot>


    <div class="breadcrumb-wrapper bg-cover"
        style="background-image: url('{{ Storage::url(ayar('hizmetHeadBannerResim')) }}');">
        <div class="container">
            <div class="breadcrumb-wrapper-items">
                <div class="page-heading">
                    <div class="breadcrumb-sub-title">
                        <h1 class="wow fadeInUp" data-wow-delay=".3s">{{ $hizmetDilVerisi->baslik }}</h1>
                    </div>
                    <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                        <li>
                            <a href="{{ rota('index') }}">
                                {{ __('global.anaSayfa') }}
                            </a>
                        </li>
                        <li>
                            <i class="fa-sharp fa-solid fa-slash-forward"></i>
                        </li>
                        <li>
                            <a href="{{ rota('hizmetler', ['kategori' => $hizmetKategoriDil->slug]) }}">
                                {{ $hizmetKategoriDil->isim }}
                            </a>
                        </li>
                        <li>
                            <i class="fa-sharp fa-solid fa-slash-forward"></i>
                        </li>
                        <li>
                            {{ $hizmetDilVerisi->baslik }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <style>
        .project-details-wrapper .project-details-items .details-image img {
            width: 100%;
            height: 100%;
            aspect-ratio: 2.1;
            object-fit: cover;
        }
    </style>
    <section class="project-details-section fix section-padding">
        <div class="container">
            <div class="project-details-wrapper">
                <div class="row g-4">
                    <div class="col-lg-12">
                        <div class="project-details-items">
                            <div class="details-image">
                                <img src="{{ Storage::url($hizmet->resim_url) }}" alt="img">
                            </div>
                            <div class="project-details-content">

                                <h2>{{ $hizmetDilVerisi->baslik }}</h2>
                                <p class="mb-3 mt-3">{!! $hizmetDilVerisi->icerik !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layout.web>
