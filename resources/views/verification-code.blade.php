@extends('__layouts.__frontend.main_auth')

@section('body')
<section class="w-100 d-flex justify-content-center align-items-center p-3 p-md-5 background-auth"
    style="min-height: 78vh; height: 100%;">
    <div class="container-card-login row border border-1 rounded bg-white shadow-sm p-2">
        <div class="col w-100 p-4 bg-white">
            <h5 class="text-center mb-2">Verifikasi Kode</h5>
            <p class="text-center" style="font-size: 14px;">Masukkan 6 digit kode yang dikirim ke email Anda.</p>

            <form id="verifyCodeForm" class="mt-4">
                <div class="mb-3">
                    <label for="verification_code" class="mb-2 fw-semibold" style="font-size: 14px;">Kode Verifikasi</label>
                    <input type="text" class="form-control text-center fw-bold fs-4" maxlength="6"
                        name="code" id="verification_code" placeholder="______" autocomplete="off" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Verifikasi</button>

                <div class="text-center mt-3">
                    <span id="timerText" style="font-size: 14px;">Kirim ulang kode dalam <strong id="countdown">05:00</strong></span>
                    <br>
                    <button type="button" id="resendCode" class="btn btn-link p-0 mt-2 text-primary fw-bold"
                        style="font-size: 14px;" disabled>Kirim Ulang Kode</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        //get params 
        const params = new URLSearchParams(window.location.search);
        const type = params.get('type') || 'register';
        const userId = '{{ $user_id }}';
        
        const verificationCodeFromURL = '{{ $code ?? "" }}'; // jika perlu

        const RESEND_INTERVAL = 300; // 5 menit (dalam detik)
        const $timerText = $("#countdown");
        const $resendBtn = $("#resendCode");
        let countdown = 0;
        let timerInterval;

        function updateTimer() {
            let minutes = Math.floor(countdown / 60);
            let seconds = countdown % 60;
            $timerText.text(`${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`);

            if (countdown <= 0) {
                clearInterval(timerInterval);
                $resendBtn.prop("disabled", false);
                $timerText.text("Kode bisa dikirim ulang");
            }

            countdown--;
        }

        function startCountdown(seconds) {
            countdown = seconds;
            $resendBtn.prop("disabled", true);
            clearInterval(timerInterval);
            timerInterval = setInterval(updateTimer, 1000);
            updateTimer();
        }

        // Ambil waktu sisa dari backend (dalam detik)
        const timeLeftFromServer = parseInt(`{{ $time_left ?? 0 }}`);
        if (timeLeftFromServer > 0) {
            startCountdown(timeLeftFromServer);
        } else {
            $resendBtn.prop("disabled", false);
            $timerText.text("Kode bisa dikirim ulang");
        }

        // Submit form verifikasi kode
        $("#verifyCodeForm").on("submit", function(e) {
            e.preventDefault();
            let code = $("#verification_code").val();

            sweetAlertLoading();

            $.ajax({
                url: '{{ route("api.customer.validate-code") }}',
                headers: {
                            'X-API-KEY': '{{ env('API_KEY') }}'
                        },
                method: 'POST',
                data: {
                    type: type,
                    user_id: '{{ $user_id }}',
                    code: code,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.close();
                    if(type == "reset_password") {
                        sweetAlertSuccessThenRedirect("Kode berhasil diverifikasi" , `/reset-password?user_id=${userId}&code=${code}`);
                    }
                    if (response.status === 200 && response.role == 3) {
                        let responeData = response.data;
                        url =
                        `{{ url('/customer-start-session') }}?id=${responeData.id}&email=${responeData.email}&name=${responeData.name}&phone=${responeData.phone}&gender=${responeData.gender}&birthday=${responeData.birthday}&code=${responeData.code}`;
                        sweetAlertSuccessThenRedirect(response.text , url);
                    } else if (response.status === 200 &&  response.role == 4) {
                        sweetAlertSuccessThenRedirect(response.text , "/seller/dashboard");
                    }
                    else {
                        sweetAlertDanger(response.text);
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    sweetAlertDanger(xhr.responseJSON?.text || "Terjadi kesalahan");
                }
            });
        });

        // Tombol Kirim Ulang Kode
        $resendBtn.on("click", function() {
            $resendBtn.prop("disabled", true);

            // Tampilkan loading alert
            Swal.fire({
                title: 'Memproses...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '{{ route("api.customer.resend-code") }}',
                headers: {
                    'X-API-KEY': '{{ env('API_KEY') }}'
                },
                method: 'POST',
                data: {
                    type: type,
                    user_id: '{{ $user_id }}',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.close(); // Tutup loading
                    if (response.status === 200) {
                        startCountdown(RESEND_INTERVAL);
                        sweetAlertSuccessThenRedirect("Kode berhasil dikirim ulang" , "#");
                    } else {
                        if (response.status === 500) {
                            sweetAlertDanger(response.text);
                            $resendBtn.prop("disabled", false);
                            $timerText.text(response.message);
                        }
                    }
                },
                error: function() {
                    Swal.close(); // Tutup loading
                    sweetAlertDanger("Gagal mengirim ulang kode");
                    $resendBtn.prop("disabled", false);
                }
            });
        });
    });

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
