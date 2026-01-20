@extends('__layouts.__frontend.main_auth')

@section('body')
    <section class="w-100 d-flex justify-content-center align-items-center p-3 p-md-5 background-auth"
        style="min-height: 78vh; height: 100%;">
        <div class="container-card-login row border border-1 rounded bg-white shadow-sm p-2">
            <div class="col w-100 p-4 bg-white">
                <h5 class="text-center">Selamat Datang</h5>
                <h6 class="fw-semibold text-center">Yuk login untuk memulai belanja</h6>
                <form id="customerLogin" class="mt-4">
                    <div class="mb-3">
                        <label for="email" class="mb-2 fw-semibold" style="font-size: 14px;">Email</label>
                        <input type="email" class="form-control" name="email" id="email"
                            aria-describedby="emailHelp" autocomplete="off" placeholder="Masukkan email" required>
                        {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="password" class="mb-2 fw-semibold" style="font-size: 14px;">Password</label>
                        <input type="password" class="form-control" name="password" id="password"
                            placeholder="Masukkan password" required>
                        <button id="showPassword" type="button"
                            style="border: none; background-color: transparent; position: absolute; top: 82%; right: 4px; transform: translateY(-82%);">
                            <i class="fa-solid fa-eye-slash" style="font-size: 16px;"></i>
                        </button>
                        <button id="hidePassword" type="button" class="d-none"
                            style="border: none; background-color: transparent; position: absolute; top: 82%; right: 4px; transform: translateY(-82%);">
                            <i class="fa-solid fa-eye" style="font-size: 16px;"></i>
                        </button>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                    <div class="d-flex align-items-center my-3">
                        <hr class="flex-grow-1 text-body-tertiary">
                        <span class="mx-2 text-body-tertiary" style="font-size: 14px;">Olebsai</span>
                        <hr class="flex-grow-1 text-body-tertiary">
                    </div>
                    <div class="text-center mt-1">
                        <span class="" style="font-size: 14px; line-height: 1.5;">
                            Belum memiliki akun olebsai?
                        </span>
                        <a href="{{ url('/register') }}"
                            class="text-primary fw-bold link-offset-2 link-underline link-underline-opacity-0"
                            style="font-size: 14px; line-height: 1.5;">
                            Registrasi Sekarang
                        </a>
                    </div>

                    <div class="text-center mt-1">
                        <span class="" style="font-size: 14px; line-height: 1.5;">
                            Apakah kamu seller?
                        </span>
                        <a href="{{ url('/seller/login') }}"
                            class="text-primary fw-bold link-offset-2 link-underline link-underline-opacity-0"
                            style="font-size: 14px; line-height: 1.5;">
                            Masuk Sebagai Seller
                        </a>
                    </div>
                </form>
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

            $inputs.on("input", function() {
                $(this).toggleClass("border-primary", $(this).val().trim() !== "");
            });

            $selects.on("input", function() {
                $(this).toggleClass("border-primary", $(this).val().trim() !== "");
            });

            function loginCostumer(emailCustomer, passwordCustomer) {
                return new Promise((resolve, reject) => {
                    console.log('{{ env('API_KEY') }}');
                    sweetAlertLoading()
                    let formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('email', emailCustomer);
                    formData.append('password', passwordCustomer);

                    $.ajax({
                        headers: {
                            'X-API-KEY': '{{ env('API_KEY') }}'
                        },
                        url: '{{ route('api.customers.login') }}',
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

            $("#customerLogin").on('submit', function(e) {
                e.preventDefault();

                let emailCustomer = $("#email").val();
                let passwordCustomer = $("#password").val();

                loginCostumer(emailCustomer, passwordCustomer)
                    .then((response) => {
                        console.log("Response API Login: ", response);
                        if (response.status === 200 && response.text == 'Login berhasil') {
                            let responeData = response.data;
                            Swal.close();
                            sweetAlertSuccess(response.text);
                            window.location.href =
                                `{{ url('/customer-start-session') }}?id=${responeData.id}&email=${responeData.email}&name=${responeData.name}&phone=${responeData.phone}&gender=${responeData.gender}&birthday=${responeData.birthday}&code=${responeData.code}&user_id=${responeData.user_id}`;
                        }else if (response.status === 403 && response.text == 'Akun anda belum diverifikasi') {
                            let responeData = response.data;
                            Swal.close();
                            sweetAlertWarning("Verifikasi akun anda terlebih dahulu");
                            window.location.href = `{{ url('/customer/email-verify/${responeData.id}?type=register') }}`;
                        }else {
                            Swal.close();
                            sweetAlertDanger(response.text);
                        }
                    })
                    .catch((error) => {
                        Swal.close();
                        console.error('Terjadi Masalah Saat Login: ', error);
                        sweetAlertDanger(error.responseJSON.text);
                    });
            });

            if (sessionStorage.getItem('flashMessage')) {
                sweetAlertSuccess(sessionStorage.getItem('flashMessage'));
                sessionStorage.removeItem('flashMessage');
            }
        });
    </script>
@endsection
