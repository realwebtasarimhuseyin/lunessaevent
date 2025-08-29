<x-layout.web>
    <x-slot:baslik>
        {{ ayar('siteBaslik', $aktifDil) }} | 404
    </x-slot>
    <x-slot:aciklama>
        {{ ayar('metaIcerik', $aktifDil) }}
    </x-slot>
    <x-slot:anahtar>
        {{ ayar('metaAnahtar', $aktifDil) }}
    </x-slot>


    <div class="page-not-found md:py-20 py-10 bg-linear md:mt-[74px] mt-14">
        <div class="container">
            <div class="flex items-center justify-between max-sm:flex-col gap-y-8">
                <img src="{{asset('web/images/404.png')}}" alt="bg-img" class="sm:w-1/2 w-3/4" />
                <div class="text-content sm:w-1/2 w-full flex items-center justify-center sm:pl-10">
                    <div class="">
                        <div class="lg:text-[140px] md:text-[80px] text-[42px] lg:leading-[152px] md:leading-[92px] leading-[52px] font-semibold">404</div>
                        <div class="heading2 mt-4">Birşeyler Eksik.</div>
                        <div class="body1 text-secondary mt-4 pb-4">Aradığınız sayfa bulunamıyor. <br class="max-xl:hidden" />Tekrar denemeden önce bir ara verin</div>
                        <a class="flex items-center gap-3" href="index.html">
                            <i class="ph ph-arrow-left"></i>
                            <div class="text-button">Ana Sayfaya Dön</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>



</x-layout.web>
