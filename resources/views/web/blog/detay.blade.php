<x-layout.web>
    @php
        $blogDilVerisi = dilVerisi($blog, 'blogDiller')->first();
    @endphp

    <x-slot:baslik>
        {{ ayar('siteBaslik') . ' | ' . $blogDilVerisi->baslik }}
    </x-slot>
    <x-slot:aciklama>
        {{ $blogDilVerisi->meta_icerik }}
    </x-slot>
    <x-slot:anahtar>
        {{ $blogDilVerisi->meta_anahtar }}
    </x-slot>


    <!-- Hero/Breadcrumb Section -->
    <section class="hero-banner bg-success position-relative text-white"
        style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ Storage::url(ayar('reklamBanner2Resim-tr')) }}') no-repeat center center; background-size: cover;">
        <div class="container py-5">
            <div class="row py-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-3">{{ $blogDilVerisi->baslik }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="{{ rota('index') }}" class="text-white">Anasayfa</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ rota('bloglar') }}" class="text-white">Kılavuz</a>
                            </li>
                            <li class="breadcrumb-item active text-white" aria-current="page">
                                {{ $blogDilVerisi->baslik }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="custom-shape-divider-bottom-1621361714">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                preserveAspectRatio="none">
                <path
                    d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                    opacity=".25" class="shape-fill"></path>
                <path
                    d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z"
                    opacity=".5" class="shape-fill"></path>
                <path
                    d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"
                    class="shape-fill"></path>
            </svg>
        </div>
    </section>

    <!-- =========  Blog Detail Area Start =========== -->
    <section class="blog-detail-section py-5">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <!-- Main Content Area -->
                <div class="col-lg-8 order-lg-2">
                    <article class="blog-article card border-0 shadow-sm mb-4">
                        <!-- Featured Image -->
                        <div class="blog-article__image overflow-hidden rounded-top">
                            <img src="{{ depolamaUrl($blog) }}" class="img-fluid w-100"
                                alt="{{ $blogDilVerisi->baslik }}" style="max-height: 500px; object-fit: cover;">
                        </div>

                        <!-- Article Content -->
                        <div class="card-body p-4 p-md-5">
                            <!-- Meta Information -->
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge bg-light text-dark me-2">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ formatZaman($blog->created_at, 'yil') }}
                                </span>
                            </div>

                            <!-- Title -->
                            <h1 class="blog-article__title display-5 fw-bold mb-4">{{ $blogDilVerisi->baslik }}</h1>

                            <!-- Content -->
                            <div class="blog-article__content">
                                {!! $blogDilVerisi->icerik !!}
                            </div>
                        </div>
                    </article>

                   
                </div>

                <!-- Sidebar Area -->
                <div class="col-lg-4 order-lg-1">
                    <aside class="blog-sidebar">
                        <!-- Recent Posts Widget -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white border-0 py-3">
                                <h3 class="h5 fw-bold mb-0"><i class="fas fa-newspaper me-2 text-success"></i> Diğer
                                    Yazılarımız</h3>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    @foreach ($bloglar as $blog)
                                        @php
                                            $blogDilVerisi = dilVerisi($blog, 'blogDiller')->first();
                                        @endphp
                                        <a href="{{ rota('blog-detay', ['slug' => $blogDilVerisi->slug]) }}"
                                            class="list-group-item list-group-item-action border-0 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-3">
                                                    <img src="{{ Storage::url($blog->resim_url) }}" class="rounded"
                                                        width="80" height="60" style="object-fit: cover;"
                                                        alt="{{ $blogDilVerisi->baslik }}">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">{{ $blogDilVerisi->baslik }}</h6>
                                                    <small
                                                        class="text-muted">{{ formatZaman($blog->created_at, 'yil') }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                      
                    </aside>
                </div>
            </div>
        </div>
    </section>
    <!-- =========  Blog Detail Area End =========== -->
</x-layout.web>
