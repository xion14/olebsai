<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="api-key" content="{{ env('API_KEY') }}">
    <title>Autentikasi &mdash; Olebsai</title>
    <link rel="shortcut icon" href="{{ asset('assets/image/brand/logo-brand.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">
    <script src="{{ asset('assets/frontend/js/bootstrap.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/brands.min.css"
        integrity="sha512-58P9Hy7II0YeXLv+iFiLCv1rtLW47xmiRpC1oFafeKNShp8V5bKV/ciVtYqbk2YfxXQMt58DjNfkXFOn62xE+g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">
    @yield('head')
</head>

<body>
    <main class="bg-white">
        @include('__layouts.__frontend.header_auth')
        @yield('body')
        @include('__layouts.__frontend.footer')
    </main>

    <script src="{{ asset('assets/panel/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/panel/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/panel/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('utility/js/custom.js') }}"></script>
    @yield('script')

    <script>
        // Load Information Bar
        $.ajax({
            headers: {
                'X-API-KEY': '{{ env('API_KEY') }}'
            },
            url: '{{ url('api/information-bar') }}',
            type: 'GET',
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    var information_bar = response.data;
                    $('#information-bar').html(information_bar.text);
                }
            },
            error: function(xhr, status, error) {
                reject(xhr);
            }
        });
    </script>
</body>

</html>
