@extends('__layouts.__frontend.main_auth')

@section('body')
<section class="w-100 d-flex justify-content-center align-items-center p-3 p-md-5 background-auth"
    style="min-height: 78vh; height: 100%;">
    <div class="container-card-login row border border-1 rounded bg-white shadow-sm p-2">
        <div class="col w-100 p-4 bg-white">
            <h5 class="text-center mb-2">Reset Password</h5>
            <p class="text-center" style="font-size: 14px;">Silakan masukkan password baru Anda di bawah ini.</p>

            <form id="resetPasswordForm" class="mt-4">
                <div class="mb-3">
                    <label for="password" class="mb-2 fw-semibold" style="font-size: 14px;">Password Baru</label>
                    <input type="password" class="form-control" name="password" id="password"
                        placeholder="Masukkan password baru" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="mb-2 fw-semibold" style="font-size: 14px;">Konfirmasi Password</label>
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password"
                        placeholder="Ulangi password baru" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Reset Password</button>
            </form>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    $(document).ready(function () {

        //get parameter from url
        const urlParams = new URLSearchParams(window.location.search);
        const user_id = urlParams.get('user_id');
        const code = urlParams.get('code');

        $("#resetPasswordForm").on("submit", function (e) {
            e.preventDefault();

            const password = $("#password").val();
            const confirmPassword = $("#confirm_password").val();

            if (password !== confirmPassword) {
                sweetAlertDanger("Password dan konfirmasi tidak cocok.");
                return;
            }

            sweetAlertLoading();

            $.ajax({
                url: '{{ route("api.reset-password") }}',
                headers: {
                    'X-API-KEY': '{{ env("API_KEY") }}'
                },
                method: 'POST',
                data: {
                    user_id: user_id,
                    code: code,
                    password: password,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    Swal.close();
                    if (response.status === 200) {
                        sweetAlertSuccessThenRedirect(response.text, "{{ url('/login') }}");
                    } else {
                        sweetAlertDanger(response.text);
                    }
                },
                error: function (xhr) {
                    Swal.close();
                    sweetAlertDanger(xhr.responseJSON?.text || "Terjadi kesalahan saat reset password.");
                }
            });
        });
    });

    function sweetAlertDanger(message) {
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: message,
            confirmButtonText: 'OK'
        });
    }

    function sweetAlertLoading() {
        Swal.fire({
            title: 'Memproses...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    function sweetAlertSuccessThenRedirect(message, redirectUrl) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: message,
            showConfirmButton: false,
            timer: 2000
        }).then(() => {
            window.location.href = redirectUrl;
        });
    }
</script>
@endsection
