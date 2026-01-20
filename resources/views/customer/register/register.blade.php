@extends('__layouts.__frontend.main_auth')

@section('body')
    <section class="w-100 d-flex justify-content-center align-items-center p-3 p-md-5 background-auth"
        style="min-height: 78vh; height: 100%;">
        <div class="container-card-auth row border border-1 rounded bg-white shadow-sm p-2">
            <div class="col w-100 p-4 bg-white">
                <h5 class="text-center">Registrasi Olebsai</h5>
                <h6 class="text-muted fw-semibold text-center">
                    Registrasi yuk buat jelajahi semua produk Olebsai
                </h6>
                <form id="customerRegister" class="mt-5">
                    <div class="row g-3 g-lg-4 mb-3">
                        <div class="col-12 col-md-12">
                            <label for="name" class="mb-2 fw-semibold" style="font-size: 14px;">
                                Nama Lengkap
                            </label>
                            <input type="text" id="name" class="form-control" placeholder="Nama Lengkap"
                                name="name" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="row g-3 g-lg-4 mb-3">
                        <div class="col-12 col-md-6 col-lg-6">
                            <label for="email" class="mb-2 fw-semibold" style="font-size: 14px;">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                aria-describedby="emailHelp" autocomplete="off" autocomplete="off"
                                placeholder="m@example.com" required>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <label for="phone" class="mb-2 fw-semibold" style="font-size: 14px;">Phone</label>
                            <div class="input-group">
                                <span class="input-group-text">+62</span>
                                <input type="number" class="form-control" id="phone" name="phone" placeholder="Phone"
                                    autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 g-lg-4 mb-3">
                        <div class="col-12 col-md-6 col-lg-6 position-relative">
                            <label for="password" class="mb-2 fw-semibold" style="font-size: 14px;">
                                Password
                            </label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password" autocomplete="off" required>
                            <button id="showPassword" type="button"
                                style="border: none; background-color: transparent; position: absolute; top: 38px; right: 12px;">
                                <i class="fa-solid fa-eye-slash" style="font-size: 16px;"></i>
                            </button>
                            <button id="hidePassword" type="button" class="d-none"
                                style="border: none; background-color: transparent; position: absolute; top: 38px; right: 12px;">
                                <i class="fa-solid fa-eye" style="font-size: 16px;"></i>
                            </button>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 position-relative">
                            <label for="passwordConfirm" class="mb-2 fw-semibold" style="font-size: 14px;">
                                Konfirmasi Password
                            </label>
                            <input type="password" class="form-control" id="passwordConfirm" name="password"
                                placeholder="Konfirmasi Password" autocomplete="off" required>
                            <div class="invalid-feedback">
                                Password tidak sama
                            </div>
                            <button id="showPasswordConfirm" type="button"
                                style="border: none; background-color: transparent; position: absolute; top: 38px; right: 12px;">
                                <i class="fa-solid fa-eye-slash" style="font-size: 16px;"></i>
                            </button>
                            <button id="hidePasswordConfirm" type="button" class="d-none"
                                style="border: none; background-color: transparent; position: absolute; top: 38px; right: 12px;">
                                <i class="fa-solid fa-eye" style="font-size: 16px;"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row g-3 g-lg-4 mb-3">
                        <div class="col-12 col-md-6 col-lg-6">
                            <label for="birthday" class="mb-2 fw-semibold" style="font-size: 14px;">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="birthday" name="birthday" autocomplete="off"
                                required>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <label for="gender" class="mb-2 fw-semibold" style="font-size: 14px;">Gender</label>
                            <select class="form-select" id="gender" name="gender" aria-label="gender" required>
                                <option value="">-- Select Gender--</option>
                                <option value="male">Laki - Laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" id="buttonSubmit" class="btn btn-primary w-100 mt-2">Submit</button>
                </form>
                <div class="d-flex align-items-center my-3">
                    <hr class="flex-grow-1 text-body-tertiary">
                    <span class="mx-2 text-body-tertiary" style="font-size: 14px;">Olebsai</span>
                    <hr class="flex-grow-1 text-body-tertiary">
                </div>
                <div class="text-center mt-1">
                    <span class="" style="font-size: 14px; line-height: 1.5;">Already have an account?</span>
                    <a href="{{ url('/login') }}"
                        class="text-primary fw-bold link-offset-2 link-underline link-underline-opacity-0"
                        style="font-size: 14px; line-height: 1.5;">Login</a>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            const apiKey = $('meta[name="api-key"]').attr("content");
            var $inputs = $("input.form-control");
            var $selects = $("select.form-select");
            var $btnSave = $("#buttonSubmit");
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
                    $('.invalid-feedback').addClass("d-block");
                } else {
                    $(this).removeClass("border-danger");
                    $('.invalid-feedback').removeClass("d-block");
                }
            });

            $inputs.on("input", function() {
                $(this).toggleClass("border-primary", $(this).val().trim() !== "");
            });

            $selects.on("input", function() {
                $(this).toggleClass("border-primary", $(this).val().trim() !== "");
            });

            function registerCostumer(fullName, email, phone, password, birthday, gender) {
                return new Promise((resolve, reject) => {
                    sweetAlertLoading()
                    let formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('name', fullName);
                    formData.append('email', email);
                    formData.append('phone', phone);
                    formData.append('password', password);
                    formData.append('birthday', birthday);
                    formData.append('gender', gender);
                    formData.append('wallet', 0);

                    $.ajax({
                        headers: {
                            'X-API-KEY': '{{ env('API_KEY') }}'
                        },
                        url: '{{ route('api.customer.register.store') }}',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            "X-API-Key": apiKey
                        },
                        success: function(response) {
                            resolve(response);
                        },
                        error: function(xhr, status, error) {
                            reject(xhr);
                        }
                    });
                });
            }

            $("#customerRegister").on('submit', function(e) {
                e.preventDefault();

                let fullName = $("#name").val();
                let email = $("#email").val();
                let phone = $("#phone").val();
                let password = $("#password").val();
                let birthday = $("#birthday").val();
                let gender = $("#gender").val();
                let confirmPassword = $("#passwordConfirm").val();

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

                registerCostumer(fullName, email, phone, password, birthday, gender)
                    .then((response) => {
                        console.log("Response API Registrasi: ", response);
                        if (response.status === 200 && response.text == 'Data berhasil di simpan') {

                            sessionStorage.setItem('flashMessage',
                                'Registration successful. Please log in.');
                            window.location.href = '/login';
                        } else {
                            Swal.close();
                            sweetAlertDanger(response.text);
                        }
                    })
                    .catch((error) => {
                        Swal.close();
                        console.error('Terjadi Masalah:', error);
                        sweetAlertDanger(error.responseJSON.text);
                    });

            });
        });
    </script>
@endsection
