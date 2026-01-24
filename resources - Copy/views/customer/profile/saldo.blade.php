@extends('__layouts.__frontend.setting_profile')

@section('content-setting')
    <div class="col-12 col-lg-8 p-0 mt-4 mt-lg-2 mt-lg-0 mx-lg-4 border border-0 border-lg-1 rounded-3">
        <div class="e-card playing">
            <div class="image"></div>
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="infotop">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="mb-1" width="40" height="40">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                </svg>
                <br>
                <h4 id="info-saldo">
                    Rp 0
                </h4>
                <div class="name">
                    Total Saldo Aktif
                </div>
                <button type="button" id="tarik-saldo" class="btn btn-primary mt-4"
                    style="background-color: #8acaef; border: 1px solid #8acaef" disabled data-bs-toggle="modal"
                    data-bs-target="#staticBackdropWhitedraw">
                    Tarik Saldo Sekarang
                </button>
            </div>
        </div>
        <div class="w-100 p-2 p-md-4 p-lg-4 mt-4 mt-md-0">
            <div class="w-100 d-flex flex-wrap align-items-center justify-content-between gap-2">
                <strong class="fw-bold" style="font-size: 18px; line-height: 1.5rem">
                    Riwayat Penarikan Saldo
                </strong>
                <div class="d-flex align-items-center gap-2">
                    <div class="d-flex align-items-center justify-content-end">
                        <button type="button" class="btn btn-primary d-flex align-items-center gap-2" type="button"
                            data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            <i class="fa-solid fa-money-check-dollar" style="font-size: 18px;"></i>
                            Akun Bank
                        </button>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Filter Status
                        </button>
                        <ul class="dropdown-menu">
                            <li><button class="dropdown-item active" type="button" data-status="">Semua</button></li>
                            <li><button class="dropdown-item" type="button" data-status="1">Menunggu Konfirmasi
                                    Seller</button>
                            </li>
                            <li><button class="dropdown-item" type="button" data-status="2">Menunggu Konfirmasi
                                    Admin</button>
                            </li>
                            <li><button class="dropdown-item" type="button" data-status="3">Selesai</button></li>
                            <li><button class="dropdown-item" type="button" data-status="4">Ditolak</button></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="containeOrderHistory" class="w-100 d-flex flex-column gap-2 p-0 mt-4">
            </div>
        </div>
    </div>

    {{-- Modal Penarikan Saldo --}}
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">
                        Detail Akun Bank
                    </h1>
                    <button type="button" class="btn-close close-bank" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" class="w-100">
                        <div class="mb-3">
                            <label for="nama-bank" class="mb-2 fw-semibold" style="font-size: 14px;">
                                Nama Bank
                            </label>
                            <input type="text" class="form-control detail-bank" name="nama-bank" id="nama-bank"
                                aria-describedby="emailHelp" autocomplete="off" placeholder="Masukkan nama bank" required
                                disabled>
                        </div>
                        <div class="mb-3">
                            <label for="kode-bank" class="mb-2 fw-semibold" style="font-size: 14px;">
                                Kode Bank
                            </label>
                            <input type="text" inputmode="numeric" class="form-control detail-bank" name="kode-bank"
                                id="kode-bank" aria-describedby="emailHelp" autocomplete="off"
                                placeholder="Masukkan kode bank" required disabled>
                        </div>
                        <div class="mb-3">
                            <label for="nomor-rekening" class="mb-2 fw-semibold" style="font-size: 14px;">
                                Nomor Rekening
                            </label>
                            <input type="text" inputmode="numeric" class="form-control detail-bank"
                                name="nomor-rekening" id="nomor-rekening" aria-describedby="emailHelp"
                                autocomplete="off" placeholder="Masukkan nomor rekening" required disabled>
                        </div>
                        <div class="mb-3">
                            <label for="atas-nama-rekening" class="mb-2 fw-semibold" style="font-size: 14px;">
                                Atas Nama Rekening
                            </label>
                            <input type="text" class="form-control detail-bank" name="atas-nama-rekening"
                                id="atas-nama-rekening" aria-describedby="emailHelp" autocomplete="off"
                                placeholder="Masukkan atas nama rekening" required disabled>
                        </div>
                        <div class="alert alert-warning d-flex align-items-center gap-3" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="" width="32" height="32" style="flex-shrink: 0">
                                <path fill-rule="evenodd"
                                    d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                    clip-rule="evenodd" />
                            </svg>

                            <div style="font-size: 14px; line-height: 1.5">
                                Pastikan jika semua data diisi dengan benar, kami tidak akan bertanggung jawab atas
                                kesalahan pengiriman
                                saldo
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-bank" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" id="edit-bank" class="btn btn-primary">
                        Edit Akun Bank
                    </button>
                    <button type="button" id="submit-bank" class="btn btn-primary d-none">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Whitedraw Saldo --}}
    <div class="modal fade" id="staticBackdropWhitedraw" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropWhitedrawLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropWhitedrawLabel">
                        Pengajuan Penarikan Saldo
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" class="w-100">
                        <div class="mb-3">
                            <label for="total-saldo-penarikan" class="mb-2 fw-semibold" style="font-size: 14px;">
                                Total Penarikan
                            </label>
                            <input type="text" inputmode="numeric" class="form-control" name="total-saldo-penarikan"
                                id="total-saldo-penarikan" aria-describedby="emailHelp" autocomplete="off"
                                placeholder="Masukkan total penarikan saldo" required>
                        </div>
                        <div class="alert alert-warning d-flex align-items-center gap-3" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="" width="32" height="32" style="flex-shrink: 0">
                                <path fill-rule="evenodd"
                                    d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div style="font-size: 14px; line-height: 1.5">
                                Total penarikan saldo tidak boleh melebih saldo saat ini
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" id="add-whitedraw" class="btn btn-primary">
                        Ajukan Penarikan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-setting')
    <script type="text/javascript">
        $(document).ready(function() {
            let detailBank = {};
            let totalSaldo = 0;
            var $inputs = $("input.form-control.detail-bank");
            const inputFilters = {
                "#nama-bank": /[^a-zA-Z\s]/g,
                "#kode-bank": /[^0-9]/g,
                "#nomor-rekening": /[^0-9]/g,
                "#atas-nama-rekening": /[^a-zA-Z\s]/g,
            };

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
                        let responseData = response.data;
                        detailBank = responseData;
                        if (responseData !== null || responseData !== undefined || responseData !==
                            '') {
                            $("#nama-bank").val(responseData.bank_name);
                            $("#kode-bank").val(responseData.bank_code);
                            $("#nomor-rekening").val(responseData.bank_account_number);
                            $("#atas-nama-rekening").val(responseData.bank_account_name);
                        } else {
                            detailBank = {};
                            $("#nama-bank, #kode-bank, #nomor-rekening, #atas-nama-rekening")
                                .val("");
                        }
                    },
                    error: function(error) {
                        detailBank = {};
                        $("#nama-bank, #kode-bank, #nomor-rekening, #atas-nama-rekening")
                            .val("");
                        console.error("Terjadi kesalahan dalam mengambil data detail customer:", xhr);
                    }
                });
            }

            getDetailsProfile();

            function closeAkunBank() {
                getDetailsProfile();
                $inputs.prop("disabled", true);
                $("#submit-bank").addClass("d-none");
                $("#edit-bank").removeClass("d-none");
            }

            $inputs.on("input", function() {
                $(this).toggleClass("border-primary", $(this).val().trim() !== "");
            });

            $(document).on("click", ".close-bank", function() {
                closeAkunBank();
            });

            $(document).on("click", "#edit-bank", function() {
                $inputs.prop("disabled", false);
                $("#submit-bank").removeClass("d-none");
                $(this).addClass("d-none");
            });

            $.each(inputFilters, function(selector, regex) {
                $(document).on("input", selector, function() {
                    const cleanValue = $(this).val().replace(regex, "");
                    $(this).val(cleanValue);
                    if (selector == "#kode-bank") {
                        console.log("Kode Bank: " + cleanValue);
                    }
                });
            });

            $(document).on("click", "#submit-bank", function() {
                let namaBank = $("#nama-bank").val();
                let kodeBank = $("#kode-bank").val();
                let nomorRekening = $("#nomor-rekening").val();
                let namaRekening = $("#atas-nama-rekening").val();

                const values = [namaBank, kodeBank, nomorRekening, namaRekening];
                const emptyCount = values.filter(val => val.trim() === "").length;

                if (emptyCount > 0) {
                    sweetAlertWarning("Harap isi semua data bank");
                    return;
                }

                if (emptyCount > 0 && emptyCount <= 2) {
                    sweetAlertWarning("Harap isi semua data bank");
                    return;
                }

                updateDetailBank(namaBank, namaRekening, nomorRekening, kodeBank)
                    .then((response) => {
                        console.log("Response API Update Bank Customer: ", response);
                        if (response.status === 200 && response.text ==
                            'Bank account berhasil di tambahkan') {
                            Swal.close();
                            sweetAlertSuccess("Bank akun berhasil di tambahkan");
                            closeAkunBank();
                        } else {
                            Swal.close();
                            sweetAlertDanger(response.text);
                        }
                    })
                    .catch((error) => {
                        Swal.close();
                        console.error('Terjadi Masalah Update Bank Customer:', error);
                        sweetAlertDanger(error.responseJSON.text);
                    });

            });

            function updateDetailBank(bankName, bankAccountName, bankAccountNumber, bankCode) {
                return new Promise((resolve, reject) => {
                    sweetAlertLoading()
                    let formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('bank_name', bankName);
                    formData.append('bank_account_name', bankAccountName);
                    formData.append('bank_account_number', bankAccountNumber);
                    formData.append('bank_code', bankCode);

                    $.ajax({
                        headers: {
                            'X-API-KEY': '{{ env('API_KEY') }}'
                        },
                        url: `{{ url('api/customer/add-bank-account/') }}/{{ session('customer_id') }}`,
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

            // get balance saldo
            function getBalanceSaldo() {
                $.ajax({
                    headers: {
                        'X-API-KEY': '{{ env('API_KEY') }}'
                    },
                    url: `{{ url('api/customer/check-available-balance') }}?customer_id={{ session('customer_id') }}`,
                    method: 'GET',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        let responseData = response.data;
                        if (responseData !== null || responseData !== undefined || responseData !==
                            '') {
                            let balance = responseData;
                            totalSaldo = balance;
                            $("#info-saldo").text("Rp " + new Intl.NumberFormat("id-ID").format(response
                                ?.data ?? 0));

                            if (balance > 0) {
                                $("#tarik-saldo").prop("disabled", false);
                            } else {
                                $("#tarik-saldo").prop("disabled", true);
                            }
                        } else {
                            totalSaldo = 0;
                            $("#info-saldo").text("Rp " + new Intl.NumberFormat("id-ID").format(0));
                            $("#tarik-saldo").prop("disabled", true);
                        }
                    },
                    error: function(error) {
                        totalSaldo = 0;
                        $("#info-saldo").text("Rp " + new Intl.NumberFormat("id-ID").format(0));
                        $("#tarik-saldo").prop("disabled", true);
                        console.error("Terjadi kesalahan dalam mengambil data balance customer:", xhr);
                    }
                });
            }

            getBalanceSaldo();

            // get history balance
            function getHistoryBalance() {
                $("#containeOrderHistory").html(`<div class="w-100 d-flex align-items-center justify-content-center">
                    <p>Proses Mengambil Data</p>
                </div>`);
                $.ajax({
                    headers: {
                        'X-API-KEY': '{{ env('API_KEY') }}'
                    },
                    url: `{{ url('api/customer/balance') }}?customer_id={{ session('customer_id') }}`,
                    method: 'GET',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        let responseData = response.data;

                        if (responseData !== null || responseData !== undefined || responseData !==
                            '') {
                            console.log(responseData);
                            $("#containeOrderHistory").html(`${responseData?.map((item, index) => {
                                return `<div class="card-saldo mb-2">
                                    <div class="card-saldo-wrapper">
                                        <div class="card-saldo-icon">
                                            <div class="icon-cart-box">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" width="32" height="32">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                                        fill="#009688" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="card-saldo-content">
                                            <div class="card-saldo-title-wrapper">
                                                <span class="card-saldo-title">
                                                    ${item.type == "in" ? "Pengembalian Saldo" : item.type == "out" ? "Penarikan Saldo" : ""}
                                                </span>
                                            </div>
                                            <div class="product-name mt-1">
                                                ${moment(item.created_at).format("DD MMMM YYYY")}
                                            </div>
                                            <div class="product-price mt-1" style="font-weight: 600; font-size: 14px; line-height: 1.5;">
                                                Rp ${new Intl.NumberFormat("id-ID").format(item.amount)}
                                            </div>
                                            <span class="badge rounded-pill ${item.type == "in" ? "text-bg-warning text-white" : item.type == "out" ? "text-bg-primary text-white" : ""} mt-1">
                                                ${item.type == "in" ? "Pengembalian" : item.type == "out" ? "Penarikan" : ""}
                                            </span>
                                        </div>
                                    </div>
                                </div>`;
                            }).join("")}`);
                        } else {
                            $("#containeOrderHistory").html(`<div class="w-100 d-flex align-items-center justify-content-center">
                                <p>Terjadi kesalahan: ${response.message}</p>
                            </div>`);
                        }
                    },
                    error: function(error) {
                        $("#containeOrderHistory").html(`<div class="w-100 d-flex align-items-center justify-content-center">
                            <p>Terjadi kesalahan mengambil history balance</p>
                        </div>`);
                        console.error("Terjadi kesalahan get history balance customer:", xhr);
                    }
                });
            }

            getHistoryBalance();

            // tarik saldo
            $(document).on("click", "#tarik-saldo", function() {
                $("#total-saldo-penarikan").val(totalSaldo);
            });

            $(document).on("input", "#total-saldo-penarikan", function() {
                let cleanValue = $(this).val().replace(/[^0-9]/g, "");
                $(this).val(cleanValue);
            });

            $(document).on("click", "#add-whitedraw", function() {
                let totalPenarikan = $("#total-saldo-penarikan").val();

                if (totalPenarikan > totalSaldo) {
                    sweetAlertWarning("Maaf saldo tidak mencukupi, saldo saat ini Rp " + new Intl
                        .NumberFormat("id-ID").format(totalSaldo));
                    return;
                }

                if (totalPenarikan < 10000) {
                    sweetAlertWarning("Minimal penarikan Rp 10.000");
                    return;
                }

                if (
                    [detailBank.bank_name, detailBank.bank_code, detailBank.bank_account_number, detailBank
                        .bank_account_name
                    ]
                    .some(val => val == null || val == undefined || val == "")
                ) {
                    sweetAlertWarning("Harap lengkapi semua detail bank terlebih dahulu");
                    return;
                }

                withdrawCustomer(totalPenarikan)
                    .then((response) => {
                        console.log("Response API Withdraw Customer: ", response);
                        if (response.status === 200 && response.message ==
                            'Withdrawal successful') {
                            Swal.close();
                            sweetAlertSuccess("Pengajuan penarikan saldo berhasil dikirim");
                            $("#total-saldo-penarikan").val("");
                            $("#staticBackdropWhitedraw").modal("hide");
                            getHistoryBalance();
                            getBalanceSaldo();
                        } else {
                            Swal.close();
                            sweetAlertDanger(response.message);
                        }
                    })
                    .catch((error) => {
                        Swal.close();
                        console.error('Terjadi Masalah Update Bank Customer:', error);
                        sweetAlertDanger(error.responseJSON.message);
                    });
            });

            function withdrawCustomer(amount) {
                return new Promise((resolve, reject) => {
                    sweetAlertLoading()
                    let formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('customer_id', {{ session('customer_id') }});
                    formData.append('amount', amount);

                    $.ajax({
                        headers: {
                            'X-API-KEY': '{{ env('API_KEY') }}'
                        },
                        url: `{{ url('api/withdraw') }}`,
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
        });
    </script>
@endsection
