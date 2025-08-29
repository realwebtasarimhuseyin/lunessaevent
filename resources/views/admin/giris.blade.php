<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title> Admin Giriş </title>
    <link rel="icon" type="image/x-icon" href="{{ Vite::asset('resources/images/favicon.png') }}" />
    @vite(['resources/scss/layouts/light/loader.scss','resources/layouts/loader.js'])

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/bootstrap/bootstrap.min.css') }}">
    @vite(['resources/scss/light/assets/main.scss', 'resources/scss/dark/assets/main.scss','resources/scss/light/assets/authentication/auth-cover.scss','resources/scss/dark/assets/authentication/auth-cover.scss'])

    <link rel="stylesheet" href="{{ asset('admin/plugins/sweetalerts2/sweetalerts2.css') }}">
    @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss','resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
</head>

<body>

    <x-admin.layout.loader />

    <div class="auth-container d-flex">

        <div class="container mx-auto align-self-center">

            <div class="row">

                <div
                    class="col-6 d-lg-flex d-none h-100 my-auto top-0 start-0 text-center justify-content-center flex-column">
                    <div class="auth-cover-bg-image"></div>
                    <div class="auth-overlay"></div>

                    <div class="auth-cover">

                        <div class="position-relative">

                            <img src="{{ Vite::asset('resources/images/auth-cover.svg') }}" alt="auth-img">


                        </div>

                    </div>

                </div>

                <div
                    class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center ms-lg-auto me-lg-0 mx-auto">
                    <form class="card" onsubmit="(return false;)" id="girisForm">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12 mb-3">

                                    <h2>Giriş Yap</h2>
                                    <p>Giriş yapmak için e-postanızı ve şifrenizi girin</p>

                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3 lvvl">
                                        <label class="form-label">Eposta</label>
                                        <input type="email" class="form-control input" id="eposta" name="eposta">
                                    </div>
                                </div>
                                <div class="col-12 ">
                                    <div class="mb-4  lvvl">
                                        <label class="form-label">Şifre</label>
                                        <input type="password" class="form-control input" id="sifre" name="sifre">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <div class="form-check form-check-primary form-check-inline">
                                            <input class="form-check-input me-3" type="checkbox"
                                                id="beniHatirla">
                                            <label class="form-check-label" for="beniHatirla">
                                                Beni Hatırla
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-4">
                                        <button class="btn btn-secondary w-100" type="button" id="giris-btn">
                                            Giriş Yap
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const panelUrl = "{{ route('realpanel.index') }}";
    </script>
    <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
    @vite(['resources/js/pages/admin/giris.js'])
</body>

</html>
