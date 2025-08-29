<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{ $pageTitle }}</title>
    <link rel="icon" type="image/x-icon" href="{{ Vite::asset('resources/images/favicon.png') }}" />
    @vite(['resources/scss/layouts/light/loader.scss', 'resources/layouts/loader.js'])

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/bootstrap/bootstrap.min.css') }}">
    @vite(['resources/scss/light/assets/main.scss', 'resources/scss/dark/assets/main.scss'])

    <link rel="stylesheet" href="{{ asset('admin/plugins/sweetalerts2/sweetalerts2.css') }}">

    @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss','resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss','resources/css/app.css'])

    @if (!Request::routeIs('404') && !Request::routeIs('lockscreen'))

        @if ($scrollspy == 1)
            @vite(['resources/scss/light/assets/scrollspyNav.scss', 'resources/scss/dark/assets/scrollspyNav.scss'])
        @endif

        <link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/waves/waves.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/highlight/styles/monokai-sublime.css') }}">

        @vite(['resources/scss/light/plugins/perfect-scrollbar/perfect-scrollbar.scss', 'resources/scss/light/assets/components/tabs.scss', 'resources/scss/dark/assets/components/tabs.scss', 'resources/scss/layouts/light/structure.scss', 'resources/scss/layouts/dark/structure.scss'])
    @endif

    <link rel="stylesheet" href="{{ asset('admin/plugins/filepond/filepond.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/filepond/FilePondPluginImagePreview.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/filepond/FilepondPluginMediaPreview.css') }}">

    {{ $headerFiles }}

    <script>
        const varsayilanDil = "{{ $varsayilanDil }}";
        const diller = {{ Js::from($desteklenenDil) }};
    </script>
</head>

<body @class([
    'layout-boxed' => true,
    'alt-menu' => false,
    'error' => Request::routeIs('404') ? true : false,
    'maintanence' => Request::routeIs('maintenance') ? true : false,
])
    @if ($scrollspy == 1) {{ $scrollspyConfig }} @else {{ '' }} @endif
    @if (Request::routeIs('fullWidth')) layout="full-width" @endif>

    <x-admin.layout.loader />

    @if (!Request::routeIs('404') && !Request::routeIs('lockscreen'))
        @if (!Request::routeIs('blank'))
            <x-admin.navbar.style-vertical-menu classes="{{ 'container-xxl' }}" />
        @endif
        <div class="main-container " id="container">
            <x-admin.layout.overlay />
            @if (!Request::routeIs('blank'))
                <x-admin.menu.vertical-menu />
            @endif

            <div id="content" class="main-content {{ Request::routeIs('blank') ? 'ms-0 mt-0' : '' }}">
                @if ($scrollspy == 1)
                    <div class="container">
                        <div class="container">
                            {{ $slot }}
                        </div>
                    </div>
                @else
                    <div class="layout-px-spacing">
                        <div class="middle-content {{ 'container-xxl' }} p-0">
                            {{ $slot }}
                        </div>
                    </div>
                @endif
                <x-admin.layout.footer />
            </div>
        </div>
    @else
        {{ $slot }}
    @endif

    @if (!Request::routeIs('404') && !Request::routeIs('lockscreen'))
        <script>
            const panelUrl = "{{ route('realpanel.index') }}";
        </script>
        <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/bootstrap/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/mousetrap/mousetrap.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/waves/waves.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/highlight/highlight.pack.js') }}"></script>
        <script src="{{ asset('admin/plugins/moment/moment.js') }}"></script>

        <script src="{{ asset('admin/plugins/filepond/filepond.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/FilePondPluginFileValidateType.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/FilePondPluginImageExifOrientation.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/FilePondPluginImagePreview.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/FilePondPluginImageCrop.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/FilePondPluginImageResize.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/FilePondPluginImageTransform.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/FilepondPluginFileValidateSize.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/filepond/FilepondPluginMediaPreview.js') }}"></script>

        @vite(['resources/layouts/app.js'])
    @endif

    {{ $footerFiles }}
</body>

</html>
