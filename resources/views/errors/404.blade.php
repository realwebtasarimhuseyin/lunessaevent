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



    <section class="section-b-space pt-0">
        <div class="custom-container container error-img">
            <div class="row g-4">
                <div class="col-12 px-0">
                    <a href="#">
                        <img class="img-fluid" src="../assets/images/other-img/404.png"
                             alt="">
                    </a>
                </div>
                <div class="col-12">
                    <h2>Birşeyler Eksik.</h2>
                    <p>
                        Aradığınız sayfa bulunamıyor. Tekrar denemeden önce
                        bir ara verin
                    </p>
                    <a class="btn text-center btn_black rounded" href="index.html">
                        Anasayfaya Dön
                    </a>
                </div>
            </div>
        </div>
    </section>


</x-layout.web>
