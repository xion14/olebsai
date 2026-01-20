@extends('__layouts.__frontend.setting_profile')

@section('content-setting')
    <div class="col-12 col-lg-8 p-2 p-md-4 p-lg-5 mt-4 mt-lg-2 mt-lg-0 mx-lg-4 border border-0 border-lg-1 rounded-3">
        <div class="row flex-column flex-lg-row w-100">
            <div class="col">
                <div class="d-flex align-items-center gap-4">
                    <div class="profile-image">
                        <img src="{{ asset('assets/image/profile/profile.jpeg') }}" id="imageProfile" alt="Profile"
                            class="rounded-circle object-fit-cover "
                            style="width: 6rem; height: 6rem; overflow: hidden; flex-shrink: 0; object-position: top;">
                        <label for="upload-photo" class="edit-icon d-none">
                            <i class="fas fa-edit"></i>
                        </label>
                        <input class="change-profile" type="file" id="upload-photo" accept="image/*" />
                    </div>
                    <div class="d-flex flex-column">
                        <strong id="nameProfile" class="fw-bold" style="font-size: 18px; line-height: 1.5rem">-</strong>
                        <span id="emailProfile" class="fw-medium fs-6" style="word-break: break-all">-</span>
                    </div>
                </div>
            </div>
        </div>
        <form class="mt-4">
            <div class="row g-3 g-lg-4 mb-4">
                <div class="col-12 col-md-6">
                    <label for="firstName" class="mb-2 fw-semibold " style="font-size: 14px;">Nama Lengkap</label>
                    <input type="text" id="firstName" class="form-control fs-6 py-2" placeholder="Nama Lengkap"
                        name="firstName" autocomplete="off" value="" disabled>
                </div>
                <div class="col-12 col-md-6">
                    <label for="email" class="mb-2 fw-semibold" style="font-size: 14px;">Email</label>
                    <input type="email" id="email" class="form-control fs-6 py-2" placeholder="Email" name="email"
                        autocomplete="off" disabled>
                </div>
            </div>
            <div class="row g-3 g-lg-4 mb-4">
                <div class="col-12 col-md-6">
                    <label for="phone" class="mb-2 fw-semibold" style="font-size: 14px;">Nomor Telpon</label>
                    <input type="number" id="phone" class="form-control fs-6 py-2" placeholder="Nomor Telpon"
                        name="phone" autocomplete="off" disabled>
                </div>
                <div class="col-12 col-md-6">
                    <label for="birthDate" class="mb-2 fw-semibold" style="font-size: 14px;">Tanggal Lahir</label>
                    <input type="date" id="birthDate" class="form-control fs-6 py-2" name="birthDate" disabled>
                </div>
            </div>
            <div class="row g-3 g-lg-4 mb-4">
                <div class="col-12 col-md-12">
                    <label for="gender" class="mb-2 fw-semibold" style="font-size: 14px;">Jenis Kelamin</label>
                    <select id="gender" name="gender" class="form-select py-2" aria-label="Default select example"
                        disabled>
                        <option value="">-- Pilih Jenis Kelamin--</option>
                        <option value="male">Laki - Laki</option>
                        <option value="female">Perempuan</option>
                    </select>
                </div>
                <input type="hidden" name="wallet" id="wallet" value="0">
            </div>
        </form>
        <div class="w-100 d-flex flex-wrap align-items-center gap-2 mt-4 px-0">
            <div class="d-flex align-items-center justify-content-end">
                <button id="btnEdit" type="button" class="btn btn-outline-primary d-flex align-items-center gap-2">
                    <i class="bi bi-pencil-square" style="font-size: 16px;"></i>
                    Ubah Profile
                </button>
                <button id="btnSave" type="button" class="d-none btn btn-primary d-flex align-items-center gap-2 py-2">
                    Simpan
                </button>
            </div>
            <div class="d-flex align-items-center justify-content-end">
                <button type="button" class="btn btn-primary d-flex align-items-center gap-2 py-2" type="button"
                    data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <i class="fa-solid fa-key" style="font-size: 18px;"></i>
                    Ubah Kata Sandi
                </button>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    @include('customer.reset-password.ubah-password')
@endsection

@section('script-setting')
    <script type="text/javascript">
        $(document).ready(function() {
            var $inputs = $("input.form-control");
            var $selects = $("select.form-select");
            var $btnSave = $("#btnSave");

            // handle get data profile
            function getDetailsProfile() {
                $.ajax({
                    headers: {
                        'X-API-KEY': '{{ env('API_KEY') }}'
                    },
                    url: `{{ url('api/customer/detail/') }}/{{ session('customer_id') }}`,
                    method: 'GET',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log("Response API Get Detail Customer: ", response.data);
                        let responseData = response.data;
                        if (responseData !== null || responseData !== undefined || responseData !==
                            '') {
                            $("#firstName").val(responseData.name);
                            $("#birthDate").val(responseData.birthday == null ? '' : responseData
                                .birthday);
                            $("#gender").val(responseData.gender == null ? '' : responseData.gender);
                            $("#email").val(responseData.email);
                            $("#phone").val(responseData.phone == null ? '' : Number(responseData
                                .phone));
                            $("#wallet").val(responseData.wallet);
                            $("#nameProfile").text(responseData.name);
                            $("#emailProfile").text(responseData.email);
                            $('#imageProfile').attr('src', responseData.image_user_profile === null ?
                                `{{ asset('assets/image/profile/profile.jpeg') }}` :
                                "/uploads/customer/" + responseData
                                .image_user_profile);
                            $("#text-email-verfiksi").text(
                                'Buat kata sandi yang kuat untuk akun dengan e-mail ' + responseData
                                .email);
                        } else {
                            $("#firstName, #birthDate, #gender, #email, #phone, #wallet, #text-email-verfiksi")
                                .val("");
                            $("#nameProfile, #emailProfile").text("-");
                            $('#imageProfile').attr('src',
                                `{{ asset('assets/image/profile/profile.jpeg') }}`);
                        }
                    },
                    error: function(error) {
                        $("#firstName, #birthDate, #gender, #email, #phone, #wallet, #text-email-verfiksi")
                            .val("");
                        $("#nameProfile, #emailProfile").text("-");
                        $('#imageProfile').attr('src',
                            `{{ asset('assets/image/profile/profile.jpeg') }}`);
                        console.error("Terjadi kesalahan dalam mengambil data detail customer:", xhr);
                    }
                });
            }

            getDetailsProfile();

            $inputs.on("input", function() {
                $(this).toggleClass("border-primary", $(this).val().trim() !== "");
            });

            $selects.on("input", function() {
                $(this).toggleClass("border-primary", $(this).val().trim() !== "");
            });

            $("#btnEdit").on("click", function() {
                $inputs.prop("disabled", false);
                $selects.prop("disabled", false);
                $btnSave.text("Simpan");
                $btnSave.removeClass("d-none");
                $(this).addClass("d-none");
                $(".edit-icon").removeClass("d-none");
            });

            // handle form submit
            function updateProfile(name, email, phone, birthday, gender, wallet) {
                return new Promise((resolve, reject) => {
                    sweetAlertLoading()
                    let formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('name', name);
                    formData.append('email', email);
                    formData.append('phone', phone);
                    formData.append('birthday', birthday);
                    formData.append('gender', gender);
                    formData.append('gender', gender);
                    formData.append('wallet', wallet);

                    $.ajax({
                        headers: {
                            'X-API-KEY': '{{ env('API_KEY') }}'
                        },
                        url: `{{ url('api/customer/update/') }}/{{ session('customer_id') }}`,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            resolve(response);
                        },
                        error: function(xhr, status, error) {
                            reject(xhr);
                        }
                    });
                });
            }

            $btnSave.on("click", function() {
                let name = $("#firstName").val();
                let birthDate = $("#birthDate").val();
                let gender = $("#gender").val();
                let email = $("#email").val();
                let phone = $("#phone").val();
                let wallet = $("#wallet").val();

                if (name == "" || birthDate == "" || gender == "" || email == "" || phone == "") {
                    sweetAlertWarning("Harap isi semua field");
                    return;
                }

                updateProfile(name, email, phone, birthDate, gender, wallet)
                    .then((response) => {
                        console.log("Response API Update Profile Customer: ", response);
                        if (response.status === 200 && response.text == 'Data berhasil di ubah') {
                            Swal.close();
                            sweetAlertSuccess("Update profile customer berhasil");
                            window.location.reload();
                            $inputs.prop("disabled", true);
                            $inputs.removeClass("border-primary");
                            $selects.prop("disabled", true);
                            $btnSave.addClass("d-none");
                            $("#btnEdit").removeClass("d-none");
                            $(".edit-icon").addClass("d-none");
                        } else {
                            Swal.close();
                            sweetAlertDanger(response.text);
                        }
                    })
                    .catch((error) => {
                        Swal.close();
                        console.error('Terjadi Masalah Update Profile Customer:', error);
                        sweetAlertDanger(error.responseJSON.text);
                    });
            });

            $(document).on("change", ".change-profile", function() {
                let file = $(this)[0].files[0];
                console.log(file);

                if (!file) {
                    sweetAlertWarning("Harap pilih file yang akan diunggah");
                    return;
                }

                sweetAlertLoading();

                let formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('image_user_profile', file);

                $.ajax({
                    headers: {
                        'X-API-KEY': '{{ env('API_KEY') }}'
                    },
                    url: `{{ url('api/customer/update/image-profile/') }}/{{ session('customer_id') }}`,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === 200 && response.text ==
                            'Image profile berhasil diubah') {
                            Swal.close();
                            sweetAlertSuccess("Image profile berhasil diubah");
                            window.location.reload();
                            $inputs.prop("disabled", true);
                            $inputs.removeClass("border-primary");
                            $selects.prop("disabled", true);
                            $btnSave.addClass("d-none");
                            $("#btnEdit").removeClass("d-none");
                            $(".edit-icon").addClass("d-none");
                        } else {
                            Swal.close();
                            sweetAlertDanger(response.text);
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.close();
                        console.error('Terjadi Masalah Update Image Profile Customer:', error);
                        sweetAlertDanger(error.responseJSON.text);
                    }
                });
            });

        });
    </script>

    {{-- Handle Ganti Kata Sandi --}}
    <script type="text/javascript">
        $(document).ready(function() {
            var $confirmPassword = $("#confirm-password");

            $('#showPasswordOld').on('click', function() {
                $('#old-password').attr('type', 'text');
                $('#hidePasswordOld').removeClass('d-none');
                $('#showPasswordOld').addClass('d-none');
            });

            $('#hidePasswordOld').on('click', function() {
                $('#old-password').attr('type', 'password');
                $('#hidePasswordOld').addClass('d-none');
                $('#showPasswordOld').removeClass('d-none');
            });

            $('#showPasswordNew').on('click', function() {
                $('#new-password').attr('type', 'text');
                $('#hidePasswordNew').removeClass('d-none');
                $('#showPasswordNew').addClass('d-none');
            });

            $('#hidePasswordNew').on('click', function() {
                $('#new-password').attr('type', 'password');
                $('#hidePasswordNew').addClass('d-none');
                $('#showPasswordNew').removeClass('d-none');
            });

            $('#showPasswordConfirmNew').on('click', function() {
                $('#confirm-password').attr('type', 'text');
                $('#hidePasswordConfirmNew').removeClass('d-none');
                $('#showPasswordConfirmNew').addClass('d-none');
            });

            $('#hidePasswordConfirmNew').on('click', function() {
                $('#confirm-password').attr('type', 'password');
                $('#hidePasswordConfirmNew').addClass('d-none');
                $('#showPasswordConfirmNew').removeClass('d-none');
            });

            $confirmPassword.on("input", function() {
                if ($(this).val() != $('#new-password').val()) {
                    $(this).addClass("border-danger");
                    $('.invalid-feedback').addClass("d-block");
                } else {
                    $(this).removeClass("border-danger");
                    $('.invalid-feedback').removeClass("d-block");
                }
            });

            $('.close-modal-pw').on('click', function() {
                $('#old-password').val('');
                $('#new-password').val('');
                $('#confirm-password').val('');
            })

            $("#btnChangePassword").on("click", function(e) {
                e.preventDefault();
                let oldPassword = $('#old-password').val();
                let newPassword = $('#new-password').val();
                let confirmPassword = $('#confirm-password').val();

                if (oldPassword == "" || newPassword == "" || confirmPassword == "") {
                    sweetAlertDanger("Harap isi semua data yang dibutuhkan");
                    return;
                }

                if (newPassword != confirmPassword) {
                    sweetAlertDanger("Password baru tidak sama dengan konfirmasi password");
                    return;
                }

                console.log(oldPassword, newPassword, confirmPassword);

                sweetAlertLoading();

                let formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('old_password', oldPassword);
                formData.append('new_password', newPassword);

                $.ajax({
                    headers: {
                        'X-API-KEY': '{{ env('API_KEY') }}'
                    },
                    url: `{{ url('api/customer/update-password/') }}/{{ session('customer_id') }}`,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === 200 && response.text ==
                            'Password berhasil diubah') {
                            console.log(response);
                            Swal.close();
                            sweetAlertSuccess("Password berhasil diubah");
                            window.location.reload();
                        } else {
                            Swal.close();
                            sweetAlertDanger(response.text);
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.close();
                        console.error('Terjadi Masalah Update Password Customer:', error);
                        sweetAlertDanger(error.responseJSON.text);
                    }
                });
            });
        });
    </script>
@endsection
