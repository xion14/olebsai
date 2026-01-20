@extends('__layouts.__frontend.main_auth')

@section('body')
<section class="w-100 d-flex justify-content-center align-items-center p-3 p-md-5 background-auth"
    style="min-height: 78vh; height: 100%;">
    <div class="container-card-login row border border-1 rounded bg-white shadow-sm p-2">
        <div class="col w-100 p-4 bg-white">
            <h5 class="text-center mb-2">Lupa Password</h5>
            <p class="text-center" style="font-size: 14px;">Masukkan email Anda untuk menerima kode verifikasi.</p>

            <form id="requestResetForm" class="mt-4">
                <div class="mb-3">
                    <label for="email" class="mb-2 fw-semibold" style="font-size: 14px;">Email</label>
                    <input type="email" class="form-control" name="email" id="email"
                        placeholder="contoh@email.com" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Kirim Kode</button>
            </form>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $("#requestResetForm").on("submit", function (e) {
            e.preventDefault();

            const email = $("#email").val();

            sweetAlertLoading();

            $.ajax({
                url: '{{ route("api.request-reset-password") }}',
                headers: {
                    'X-API-KEY': '{{ env("API_KEY") }}'
                },
                method: 'POST',
                data: {
                    email: email,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    Swal.close();
                    if (response.status == 200) {
                        url = `/reset-password-code-verify/${response.data.id}?type=reset_password`;
                        sweetAlertSuccessThenRedirect(response.text, url);
                    } else {
                        sweetAlertDanger(response.text);
                    }
                },
                error: function (xhr) {
                    Swal.close();
                    sweetAlertDanger(xhr.responseJSON?.text || "Gagal mengirim kode verifikasi.");
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
