<x-layout.web>
    <x-slot:baslik>
        {{ ayar('siteBaslik', $aktifDil) }} | {{ $sayfaBaslik }}
    </x-slot>
    <x-slot:aciklama>
        {{ ayar('metaIcerik', $aktifDil) }}
    </x-slot>
    <x-slot:anahtar>
        {{ ayar('metaAnahtar', $aktifDil) }}
    </x-slot>

    @php
        $sayfaYonetimDilVerisi = dilVerisi($sayfaYonetim, 'sayfaYonetimDiller')->first();
    @endphp


    <section class="section-b-space pt-0">
        <div class="heading-banner">
            <div class="custom-container container">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4> {{ $sayfaBaslik }} </h4>
                    </div>
                    <div class="col-sm-6">
                        <ul class="breadcrumb float-end">
                            <li class="breadcrumb-item"><a href="{{rota('index')}}"> Anasayfa </a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);"> {{ $sayfaBaslik }} </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-b-space pt-0">
        <div class="custom-container container">
            <div class="row align-items-center gy-4">

                <div class="col-12">
                    <div class="about-content">
                        <div class="sidebar-title">
                            <div class="loader-line"></div>
                            <h3>{{ $sayfaBaslik }} </h3>
                        </div>
                        <div>
                            {!! $sayfaYonetimDilVerisi->icerik ?? '' !!}

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


</x-layout.web>
