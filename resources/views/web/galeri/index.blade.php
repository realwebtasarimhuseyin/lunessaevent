<x-layout.web>
    <x-slot:baslik>
        {{ ayar('siteBaslik', $aktifDil) }}
    </x-slot>
    <x-slot:aciklama>
        {{ ayar('metaIcerik', $aktifDil) }}
    </x-slot>
    <x-slot:anahtar>
        {{ ayar('metaAnahtar', $aktifDil) }}
    </x-slot>



    <!-- Hero/Breadcrumb Section -->
    <section class="hero-banner bg-success position-relative text-white"
        style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ Storage::url(ayar('reklamBanner2Resim-tr')) }}') no-repeat center center; background-size: cover;">
        <div class="container py-5">
            <div class="row py-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-3">Galeri</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="{{ rota('index') }}" class="text-white">Anasayfa</a>
                            </li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Galeri</li>
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


    <!-- =============== Gallary area start =============== -->
    <div class="gallary-area gallary-style-one pt-110">
        <div class="container">
            <div class="row">

                @foreach ($galeriler as $galeri)
                    @php
                        $galeriDilVerisi = dilVerisi($galeri, 'galeriDiller')->first();
                    @endphp

                    @if (isset($galeri->resim_url))
                        <div class="col-lg-4 col-md-4">
                            <div class="gallary-item">
                                <img src="{{ Storage::url($galeri->resim_url) }}"
                                    alt="{{ $galeriDilVerisi->baslik }}" />
                                <a class="gallary-item-overlay" data-fancybox="gallery"
                                    data-caption="{{ $galeriDilVerisi->baslik }}"
                                    href="{{ Storage::url($galeri->resim_url) }}">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        </div>
                    @elseif(isset($galeri->video_url))
                        <!-- Video Gallery Item -->
                        <div class="col-lg-4 col-md-6 col-sm-6 mt-4">
                            <div class="gallery-item position-relative overflow-hidden rounded-3 video-gallery-item">
                                <video id="video-{{ $loop->index }}"
                                    data-video-src="{{ Storage::url($galeri->video_url) }}"
                                    class="img-fluid w-100 gallery-video"
                                    poster="{{ asset('web/images/video-poster-default.jpg') }}"
                                    style="height: 300px; object-fit: cover;">
                                </video>
                                <div class="gallery-overlay d-flex align-items-center justify-content-center">
                                    <button
                                        class="video-play-btn rounded-circle border-0 bg-success bg-opacity-75 text-white"
                                        data-bs-toggle="modal" data-bs-target="#videoModal"
                                        data-video-src="{{ Storage::url($galeri->video_url) }}"
                                        data-video-title="{{ $galeriDilVerisi->baslik }}">
                                        <i class="bi bi-play-fill fs-3"></i>
                                    </button>
                                </div>
                                <div
                                    class="video-duration-badge bg-dark text-white position-absolute bottom-0 end-0 m-2 px-2 rounded-1 small video-duration-placeholder">
                                    Yükleniyor...
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <!-- =============== Gallary area end =============== -->

    <!-- Video Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0" style="height: 1200px !important;">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="videoModalLabel">Video</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 ratio ratio-16x9">
                    <video id="modalVideoPlayer" controls class="w-100">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    </div>
    <!-- =============== Gallery Area End =============== -->

    <!-- Custom CSS -->
    <style>
        .gallery-item {
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        .video-play-btn {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .video-play-btn:hover {
            background: rgba(25, 135, 84, 1) !important;
            transform: scale(1.1);
        }

        .video-gallery-item:hover .video-play-btn {
            transform: scale(1.1);
        }

        .gallery-video {
            background-color: #000;
        }

        /* Modal video styling */
        #modalVideoPlayer {
            background: #000;
        }

        .modal-content {
            overflow: hidden;
        }
    </style>

    <!-- JavaScript for Video Modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var videoModal = document.getElementById('videoModal');
            var videoPlayer = document.getElementById('modalVideoPlayer');
            var videoModalLabel = document.getElementById('videoModalLabel');

            videoModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var videoSrc = button.getAttribute('data-video-src');
                var videoTitle = button.getAttribute('data-video-title');

                videoPlayer.src = videoSrc;
                videoModalLabel.textContent = videoTitle;
            });

            videoModal.addEventListener('hide.bs.modal', function() {
                videoPlayer.pause();
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.gallery-video').forEach(video => {
                // Metadata yüklendiğinde süreyi al
                video.addEventListener('loadedmetadata', function() {
                    const duration = video.duration;
                    const minutes = Math.floor(duration / 60);
                    const seconds = Math.floor(duration % 60);
                    const formattedTime =
                        `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                    // En yakın badge'i bul ve güncelle
                    const badge = video.closest('.gallery-item').querySelector(
                        '.video-duration-placeholder');
                    if (badge) {
                        badge.textContent = formattedTime;
                        badge.classList.remove('video-duration-placeholder');
                    }
                });

                // Hata durumu
                video.addEventListener('error', function() {
                    const badge = video.closest('.gallery-item').querySelector(
                        '.video-duration-placeholder');
                    if (badge) {
                        badge.textContent = '--:--';
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.gallery-video[data-video-src]').forEach(videoEl => {
                // Video elementini oluştur
                const video = document.createElement('video');
                video.src = videoEl.getAttribute('data-video-src');

                // Videodan poster oluştur
                video.addEventListener('loadeddata', function() {
                    // 1. saniyeden frame al
                    video.currentTime = 1;
                });

                video.addEventListener('seeked', function() {
                    // Canvas oluştur ve frame'i çiz
                    const canvas = document.createElement('canvas');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                    // Poster olarak ayarla
                    videoEl.poster = canvas.toDataURL('image/jpeg');
                });

                // Hata durumu
                video.addEventListener('error', function() {
                    console.error('Video yüklenirken hata oluştu');
                });
            });
        });
    </script>
</x-layout.web>
