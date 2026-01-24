@extends('__layouts.__frontend.main')

@section('body')
    <div class="w-100 mt-3">
        <div class="row px-2">
            <div class="d-none d-lg-block col-12 col-lg-2 py-lg-5 py-2 px-0 border border-1 rounded-3 mx-lg-4 position-relative"
                style="height: 64vh;">
                <ul class="p-0 m-0 ">
                    <li class="list-group-item mb-2">
                        <button type="button" onclick="window.location.href='{{ url('/user-setting') }}'"
                            class="{{ request()->is('user-setting') ? 'btn btn-primary' : 'btn-setting' }} w-100 px-3 py-2 text-start  rounded-0">
                            Ubah Profile
                        </button>
                    </li>
                    <li class="list-group-item mb-2">
                        <button type="button" onclick="window.location.href='{{ url('/address-setting') }}'"
                            class="{{ request()->is('address-setting') ? 'btn btn-primary' : 'btn-setting' }} w-100 px-3 py-2 text-start rounded-0">
                            Daftar Alamat
                        </button>
                    </li>
                    <li class="list-group-item mb-2">
                        <button type="button" onclick="window.location.href='{{ url('/order-history') }}'"
                            class="{{ request()->is('order-history') ? 'btn btn-primary' : 'btn-setting' }} w-100 px-3 py-2 text-start rounded-0">
                            Transaksi
                        </button>
                    </li>
                    <li class="list-group-item mb-2">
                        <button type="button" onclick="window.location.href='{{ url('/waiting-payment') }}'"
                            class="{{ request()->is('waiting-payment') ? 'btn btn-primary' : 'btn-setting' }} w-100 px-3 py-2 text-start rounded-0">
                            Menunggu Pembayaran
                        </button>
                    </li>
                    <li class="list-group-item mb-2">
                        <button type="button" onclick="window.location.href='{{ url('/waiting-confirmation') }}'"
                            class="{{ request()->is('waiting-confirmation') ? 'btn btn-primary' : 'btn-setting' }} w-100 px-3 py-2 text-start rounded-0">
                            Menunggu Konfirmasi
                        </button>
                    </li>
                    <li class="list-group-item mb-2">
                        <button type="button" onclick="window.location.href='{{ url('/get-saldo-user') }}'"
                            class="{{ request()->is('get-saldo-user') ? 'btn btn-primary' : 'btn-setting' }} w-100 px-3 py-2 text-start rounded-0">
                            Penarikan Saldo
                        </button>
                    </li>
                </ul>
                <button type="button"
                    class="btn-text-error logout fs-6 w-100 px-3 py-2 text-start rounded-0 position-absolute"
                    style="bottom: 1rem;">
                    Keluar Sekarang
                </button>
            </div>
            @yield('content-setting')
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var $btnLogout = $(".btn-text-error.logout");

            function logoutCostumer() {
                return new Promise((resolve, reject) => {
                    sweetAlertLoading()

                    $.ajax({
                        headers: {
                            'X-API-KEY': '{{ env('API_KEY') }}'
                        },
                        url: '{{ route('api.customers.logout') }}',
                        type: 'GET',
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

            $btnLogout.on("click", function() {
                Swal.fire({
                    title: "Apakah kamu yakin keluar aplkasi?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#229FE1",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Keluar Sekarang",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        logoutCostumer()
                            .then((response) => {
                                console.log("Response API Logout: ", response);
                                if (response.status === 200 && response.text ==
                                    'Logout Success') {
                                    Swal.close();
                                    sweetAlertSuccess(response.text);
                                    window.location.href =
                                        "{{ url('/customer-end-session') }}";
                                } else {
                                    Swal.close();
                                    sweetAlertDanger(response.text);
                                }
                            })
                            .catch((error) => {
                                Swal.close();
                                console.error('Terjadi Masalah Saat Logout: ',
                                    error);
                                sweetAlertDanger(error.response.text);
                            });
                    }
                });
            })
        });
    </script>
    @yield('script-setting')
@endsection
