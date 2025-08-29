<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <title>{{ $baslik }}</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $aciklama }}">
    <meta name="keywords" content="{{ $anahtar }}">
    <meta name="author" content="REAL WEB TASARIM">
    <meta name="robots" content="index, follow">
    <meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}">
    <link rel="canonical" href="{{ env('APP_URL') }}">



    <!-- Stylesheets -->
    <link href="{{ asset('web/css/bootstrap.min.css') }}?v={{ time() }}" rel="stylesheet">
    <link href="{{ asset('web/css/master.css') }}?v={{ time() }}" rel="stylesheet">
    <link href="{{ asset('web/css/style.css') }}?v={{ time() }}" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('web/js/sweetalerts2/sweetalerts2.min.css') }}?v={{ time() }}') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="{{ asset('web/js/jquery.min.js') }}"></script>

    @vite('resources/css/app.css')

    <link rel="shortcut icon" href="{{ Storage::url(ayar('favicon')) }}">
    <link rel="apple-touch-icon-precomposed" href="{{ Storage::url(ayar('favicon')) }}">

    {!! ayar('scriptKod') !!}

    <style>
        .stok-yok-etiket {
            position: absolute;
            top: 30%;
            left: 50%;
            background: rgba(255, 0, 0, 0.5);
            color: white;
            padding: 5px 10px;
            font-weight: bold;
            font-size: 30px;
            z-index: 10;
            border-radius: 4px;
            transform: translate(-50%, -50%);
            width: max-content;
        }


        .rs-breadcrumb-bg {
            position: relative;
            z-index: 1;
        }

        .rs-breadcrumb-bg::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            /* %50 karartma */
            z-index: 2;
        }

        /* İçeriğin karartma üstünde görünmesi için */
        .rs-breadcrumb-content-wrapper {
            position: relative;
            z-index: 3;
        }

        /* Menü ve başlık yazılarının daha net görünmesi için */
        .rs-breadcrumb-content-wrapper h1,
        .rs-breadcrumb-content-wrapper a,
        .rs-breadcrumb-content-wrapper span {
            color: #fff;
        }
    </style>

    <script>
        const appUrl = "{{ env('APP_URL') }}";
        const aktifDil = "{{ $aktifDil }}";
    </script>

    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
</head>


<body class="skeleton_body">


    {!! ayar('scriptKodBody') !!}

    <style>
        .whatsapp-and-phone {
            position: fixed;
            left: 15px;
            bottom: 15px;
            z-index: 12;
        }

        .whatsapp-and-phone ul {
            display: flex;
            flex-direction: column;
            gap: .3rem;
            list-style: none;
        }

        .whatsapp-and-phone ul li a#whatsapp {
            background: #4c9d41 !important;
        }

        .whatsapp-and-phone ul li a {
            width: 50px;
            height: 50px;
            background: black;
            border-radius: 5px;
            display: flex;
            align-items: Center;
            justify-content: center;
        }

        input,
        select,
        audio,
        canvas,
        iframe,
        img,
        svg,
        video {
            vertical-align: middle;
        }

        .full-body-overlay {

            background-image: url("{{ asset('web/img/body/body-bg.png') }}");

        }
    </style>
    <div class="whatsapp-and-phone">
        <ul>
            <li>
                <a target="_blank"
                    href="https://api.whatsapp.com/send?phone={{ str_replace([' ', '+'], '', ayar('telefon')) }}"
                    id="whatsapp">
                    <img src="{{ asset('web/images/whatsapp.png') }}" height="22px" width="22px" alt="telefon"
                        aria-label="telefon-img">
                </a>
            </li>
            <li><a target="_blank" href="tel:{{ str_replace([' ', '+'], '', ayar('telefon')) }}"
                    aria-label="Telefon ile iletişime geç"><img src="{{ asset('web/images/call.png') }}" width="14px"
                        alt="Telefon"></a></li>
        </ul>
    </div>
    <div class="site-wrapper overflow-hidden">
        <x-web.header />

        {{ $slot }}

        <x-web.footer />
    </div>

    @vite('resources/js/app.js')


    <script src="{{ asset('web/js/jquery.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('web/js/popper.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('web/js/bootstrap.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('web/js/jquery.fancybox.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('web/js/jquery.countdown.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('web/js/wow.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('web/js/appear.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('web/js/lightcase.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('web/js/swipper.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('web/js/backtotop.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('web/js/gsap.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('web/js/ScrollTrigger.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('web/js/splitType.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('web/js/SplitText.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('web/js/script.js') }}?v={{ time() }}"></script>


    @vite('resources/js/pages/web/main.js')

</body>

</html>
