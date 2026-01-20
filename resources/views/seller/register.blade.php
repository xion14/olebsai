<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Register &mdash; Olebsai Seller</title>

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
                <div class="row gx-5" style="height: 100vh; overflow: hidden;">
                    <div class="col h-100 custom-scroll bg-white" style="overflow: auto;">
                        <div class="px-5 py-3 mt-4">
                            <div
                                class="d-flex justify-content-center justify-content-lg-start align-items-center gap-5">
                                <img src="{{ asset('assets/image/brand/logo-brand.png') }}" alt="Logo Brand"
                                    width="40">
                                <h5 class="mb-0 ml-2">Olebsai</h5>
                            </div>
                        </div>
                        <div
                            class="d-flex flex-column justify-content-center align-items-center gap-5 bg-white p-3 pt-lg-5">
                            <div class="w-100 px-lg-5">
                                <h4 class="">
                                    Register Seller
                                </h4>
                                <p class="card-text">
                                    Lengkapi data diri kamu untuk menjadi seller di Olebsai
                                </p>
                            </div>
                            <div class="col-12 p-2 px-lg-5 pt-5">
                                <form id="registerForm">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="name" class="form-label">Nama</label>
                                            <input type="text" name="name" id="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') }}" placeholder="Nama Seller"
                                                autocomplete="off">
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="tax_number" class="form-label">Nomor NPWP</label>
                                            <input type="text" name="tax_number" id="tax_number"
                                                class="form-control @error('tax_number') is-invalid @enderror"
                                                value="{{ old('tax_number') }}" placeholder="Nomor NPWP"
                                                autocomplete="off">
                                            @error('tax_number')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="bussiness_number" class="form-label">
                                                Nomor Bisnis Lainnya
                                            </label>
                                            <input type="text" name="business_number" id="business_number"
                                                class="form-control @error('business_number') is-invalid @enderror"
                                                value="{{ old('bussiness_number') }}"
                                                placeholder="Nomor Bisnis Lainnya" autocomplete="off">
                                            @error('business_number')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="phone" class="form-label">
                                                Nomor Telepon
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">+62</span>
                                                </div>
                                                <input type="text" name="phone" id="phone"
                                                    class="form-control @error('phone') is-invalid @enderror"
                                                    value="{{ old('phone') }}" placeholder=" Nomor Telepon"
                                                    autocomplete="off">
                                            </div>
                                            @error('phone')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" name="username" id="username"
                                                class="form-control @error('username') is-invalid @enderror"
                                                value="{{ old('username') }}" placeholder="Username"
                                                autocomplete="off">
                                            @error('username')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" id="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}" placeholder="Email" autocomplete="off">
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6 position-relative">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" name="password" id="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                value="{{ old('password') }}" placeholder="Password"
                                                autocomplete="off">
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <button id="showPassword" type="button"
                                                style="border: none; outline: none; cursor: pointer; background-color: transparent; position: absolute; top: 39px; right: 16px;">
                                                <i class="fa-solid fa-eye-slash" style="font-size: 16px;"></i>
                                            </button>
                                            <button id="hidePassword" type="button" class="d-none"
                                                style="border: none; outline: none; cursor: pointer; background-color: transparent; position: absolute; top: 39px; right: 16px;">
                                                <i class="fa-solid fa-eye" style="font-size: 16px;"></i>
                                            </button>
                                        </div>
                                        <div class="form-group col-md-6 position-relative">
                                            <label for="passwordConfirm" class="form-label">Konfirmasi
                                                Password</label>
                                            <input type="password" name="passwordConfirm" id="passwordConfirm"
                                                class="form-control" value="" placeholder="Konfirmasi Password"
                                                autocomplete="off">
                                            <div class="invalid-feedback confirm-password">
                                                Password tidak sama
                                            </div>
                                            <button id="showPasswordConfirm" type="button"
                                                style="border: none; outline: none; cursor: pointer; background-color: transparent; position: absolute; top: 39px; right: 16px;">
                                                <i class="fa-solid fa-eye-slash" style="font-size: 16px;"></i>
                                            </button>
                                            <button id="hidePasswordConfirm" type="button" class="d-none"
                                                style="border: none; outline: none; cursor: pointer; background-color: transparent; position: absolute; top: 39px; right: 16px;">
                                                <i class="fa-solid fa-eye" style="font-size: 16px;"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="form-divider">
                                        Alamat
                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="form-label">Alamat Lengkap</label>
                                        <textarea name="address" id="address" class="form-control" cols="30" rows="5"
                                            placeholder="Masukkan alamat lengkap">{{ old('address') }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback" autocomplete="off">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="country" class="form-label">Negara</label>
                                            <input type="text" name="country" id="country"
                                                class="form-control @error('country') is-invalid @enderror"
                                                value="{{ old('country') }}" placeholder="Negara"
                                                autocomplete="off">
                                            @error('country')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="province" class="form-label">Provinsi</label>
                                            <input type="text" name="province" id="province"
                                                class="form-control @error('province') is-invalid @enderror"
                                                value="{{ old('province') }}" placeholder="Provinsi"
                                                autocomplete="off">
                                            @error('province')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="city" class="form-label">Kota/Kabupaten</label>
                                            <input type="text" name="city" id="city"
                                                class="form-control @error('city') is-invalid @enderror"
                                                value="{{ old('city') }}" placeholder="Kota/Kabupaten"
                                                autocomplete="off">
                                            @error('city')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="zip_code" class="form-label">Kode Pos</label>
                                            <input type="text" name="zip_code" id="zip_code"
                                                class="form-control @error('zip_code') is-invalid @enderror"
                                                value="{{ old('zip_code') }}" placeholder="Kode Pos"
                                                autocomplete="off">
                                            @error('zip_code')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            Register
                                        </button>
                                    </div>

                                    <div class="form-group mt-3 d-flex align-items-center justify-content-center">
                                        Sudah punya akun ? <a href="{{ url('seller/login') }}"
                                            tabindex="5"><b>Login</b></a>
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
                            <img src="{{ asset('assets/image/illustrasi/registrasi.svg') }}" alt="illustrasi login"
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

    <script>
        $(document).ready(function() {
            var $confirmPassword = $("#passwordConfirm");

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

            $('#showPasswordConfirm').on('click', function() {
                $('#passwordConfirm').attr('type', 'text');
                $('#hidePasswordConfirm').removeClass('d-none');
                $('#showPasswordConfirm').addClass('d-none');
            });

            $('#hidePasswordConfirm').on('click', function() {
                $('#passwordConfirm').attr('type', 'password');
                $('#hidePasswordConfirm').addClass('d-none');
                $('#showPasswordConfirm').removeClass('d-none');
            });

            $confirmPassword.on("input", function() {
                if ($(this).val() != $('#password').val()) {
                    $(this).addClass("border-danger");
                    $('.invalid-feedback.confirm-password').addClass("d-block");
                } else {
                    $(this).removeClass("border-danger");
                    $('.invalid-feedback.confirm-password').removeClass("d-block");
                }
            });

            function processForm(name, tax_number, business_number, phone, username, email, password, country,
                province, city,
                zip_code, address) {
                return new Promise((resolve, reject) => {
                    let formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('name', name);
                    formData.append('tax_number', tax_number);
                    formData.append('business_number', business_number);
                    formData.append('phone', phone);
                    formData.append('username', username);
                    formData.append('email', email);
                    formData.append('password', password);
                    formData.append('country', country);
                    formData.append('province', province);
                    formData.append('city', city);
                    formData.append('zip_code', zip_code);
                    formData.append('address', address);

                    sweetAlertLoading();


                    $.ajax({
                        headers: {
                            'X-API-KEY': '{{ env('API_KEY') }}'
                        },
                        url: '{{ route('api.seller.register.store') }}',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            resolve(response);
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;

                                for (let field in errors) {
                                    let input = $(`[name="${field}"]`);
                                    input.addClass('is-invalid');
                                    input.after(
                                        `<div class="invalid-feedback">${errors[field][0]}</div>`
                                    );
                                }
                            }
                            reject(xhr);
                        }
                    });
                });
            }

            $('#registerForm').on('submit', function(e) {
                e.preventDefault();

                let name = $('#name').val();
                let tax_number = $('#tax_number').val();
                let business_number = $('#business_number').val();
                let phone = $('#phone').val();
                let username = $('#username').val();
                let email = $('#email').val();
                let password = $('#password').val();
                let country = $('#country').val();
                let province = $('#province').val();
                let city = $('#city').val();
                let zip_code = $('#zip_code').val();
                let address = $('#address').val();
                let confirmPassword = $('#passwordConfirm').val();

                if (confirmPassword == "") {
                    Swal.close();
                    sweetAlertDanger('Konfirmasi Password tidak boleh kosong');
                    return;
                }

                if (password !== confirmPassword) {
                    Swal.close();
                    sweetAlertDanger('Password tidak sama');
                    return;
                }

                processForm(name, tax_number, business_number, phone, username, email, password, country,
                        province,
                        city, zip_code, address)
                    .then((response) => {
                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').remove();
                        if (response.status === 200) {
                            Swal.close();
                            sweetAlertSuccess(response.text);
                            setTimeout(() => {
                                window.open(
                                    'https://wa.me/62{{ $contactAdmin->contact }}?text=Hi%20Admin%0ARegistrasi%20user%' +
                                    name +
                                    '%20baru%20saja%20dilakukan,%20tolong%20untuk%20di%20proses',
                                    '_blank');
                                window.location.href = '/seller/login';
                            }, 1000);

                        } else if (response.status === 400) {
                            sweetAlertDanger(response.text);
                        }
                    })
                    .catch(error => {
                        Swal.close();
                        console.error('Terjadi Masalah:', error);
                    });
            });
        });
    </script>
</body>

</html>
