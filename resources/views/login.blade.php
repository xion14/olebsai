<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="api-key" content="{{ env('API_KEY') }}">
    <title>Login &mdash; Olebsai</title>
    <link rel="shortcut icon" href="{{ asset('assets/image/brand/logo-brand.png') }}" type="image/x-icon">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/panel/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/panel/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/panel/modules/bootstrap-social/bootstrap-social.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/panel/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/panel/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/brands.min.css"
        integrity="sha512-58P9Hy7II0YeXLv+iFiLCv1rtLW47xmiRpC1oFafeKNShp8V5bKV/ciVtYqbk2YfxXQMt58DjNfkXFOn62xE+g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>
    <div id="app">
        <section class="">
            <div class="container-fluid vh-100">
                <div class="row gx-5" style="height: 100vh; overflow: hidden">
                    <div class="col ">
                        <div class="login-brand px-5 py-3">
                            <div
                                class="d-flex justify-content-center justify-content-lg-start align-items-center gap-5">
                                <img src="{{ asset('assets/image/brand/logo-brand.png') }}" alt="Logo Brand"
                                    width="40">
                                <h5 class="mb-0 ml-2">Olebsai</h5>
                            </div>
                        </div>
                        <div
                            class="d-flex flex-column justify-content-center align-items-center gap-5 bg-white p-3 pt-lg-5">
                            <h4 class="">
                                Selamat Data di Dashboard Olebsai
                            </h4>
                            <p class="card-text">
                                Masukkan email dan password yang telah terdaftar.
                            </p>
                            <div class="col-12 col-md-8 col-lg-6 p-2 ">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" name="email" class="form-control"
                                            placeholder="Masukkan email" tabindex="1" required autofocus
                                            autocomplete="off">
                                    </div>
                                    <div class="form-group position-relative">
                                        <label for="password">Password</label>
                                        <input id="password" type="password" placeholder="Masukkan password"
                                            class="form-control" name="password" tabindex="2" required
                                            autocomplete="off">
                                        <button id="showPassword" type="button"
                                            style="border: none; outline: none; cursor: pointer; background-color: transparent; position: absolute; top: 39px; right: 8px;">
                                            <i class="fa-solid fa-eye-slash" style="font-size: 16px;"></i>
                                        </button>
                                        <button id="hidePassword" type="button" class="d-none"
                                            style="border: none; outline: none; cursor: pointer; background-color: transparent; position: absolute; top: 39px; right: 8px;">
                                            <i class="fa-solid fa-eye" style="font-size: 16px;"></i>
                                        </button>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Login
                                        </button>
                                    </div>

                                    <div class="form-group mt-3 d-flex align-items-center justify-content-center">
                                        Belum punya akun ? <a href="{{ url('seller/register') }}" class=""
                                            tabindex="5"><b>Register</b></a>
                                    </div>
                                </form>

                            </div>
                            <div class="simple-footer">
                                Copyright &copy; Olebsai 2025
                            </div>
                        </div>
                    </div>
                    <div class="col h-100 d-none d-lg-block" style="background-color: #bfe3f8;">
                        <div class="d-flex justify-content-center align-content-center h-100">
                            <img src="{{ asset('assets/image/illustrasi/login.svg') }}" alt="illustrasi login"
                                width="512">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/panel/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/panel/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/panel/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/panel/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/panel/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/panel/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/panel/js/stisla.js') }}"></script>
    <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- JS Libraies -->

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="{{ asset('assets/panel/js/scripts.js') }}"></script>
    <script src="{{ asset('utility/js/custom.js') }}"></script>
    <script>
        @if (session('success'))
            sweetAlertSuccess("{{ session('success') }}")
        @endif

        @if (session('danger'))
            sweetAlertDanger("{{ session('danger') }}")
        @endif

        @if (session('error'))
            sweetAlertDanger("{{ session('error') }}")
        @endif

        @if (session('warning'))
            sweetAlertWarning("{{ 'warning' }}")
        @endif
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#showPassword').on('click', function() {
                $('#password').attr('type', 'text');
                $('#hidePassword').removeClass('d-none');
                $('#showPassword').addClass('d-none');
            });

            $('#hidePassword').on('click', function() {
                $('#password').attr('type', 'password');
                $('#hidePassword').addClass('d-none');
                $('#showPassword').removeClass('d-none');
            });
        });
    </script>
</body>

</html>
