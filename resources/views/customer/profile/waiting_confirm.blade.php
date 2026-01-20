@extends('__layouts.__frontend.setting_profile')

@section('content-setting')
    <div class="col-12 col-lg-8 p-2 p-md-4 p-lg-4 mt-4 mt-lg-2 mt-lg-0 mx-lg-4 border border-0 border-lg-1 rounded-3">
        <div class="w-100 d-flex align-items-center justify-content-between">
            <strong class="fw-bold" style="font-size: 18px; line-height: 1.5rem">
                Menunggu Konfirmasi
            </strong>
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Filter Status
                </button>
                <ul class="dropdown-menu">
                    <li><button class="dropdown-item active" type="button" data-status="1">Menunggu Konfirmasi Seller</button></li>
                    <li><button class="dropdown-item" type="button" data-status="2">Menunggu Konfirmasi Admin</button></li>
                </ul>
            </div>
        </div>
        <div class="search-container mt-4">
            <input type="text" class="search-input" placeholder="Cari transaski">
            <i class="fas fa-search search-icon"></i>
        </div>
        <div id="containerWaitingConfirm" class="w-100 mt-3 p-0">

        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Detail Transaksi</h1>
                    <button type="button" class="btn-close detail" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="containerDetailTransaksi" class="modal-body">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-setting')
    <script type="text/javascript">
        let dataWaitingConfirm = [];
        let detailTransaksi = {};
        let statusFilter = "1";

        function getDataWaitingConfirm() {
            $.ajax({
                headers: {
                    'X-API-KEY': '{{ env('API_KEY') }}'
                },
                url: `{{ route('api.customer.transaction.index') }}?customer_id={{ session('customer_id') }}&status=${statusFilter}`,
                method: 'GET',
                processData: false,
                contentType: false,
                success: function(response) {
                    let dataResponse = response.data.data;
                    console.log("Response API Get Data Waiting Confirm: ", response.data.data);
                    if (response.success == true && response.message == "Success get transactions") {
                        if (dataResponse.length > 0) {
                            dataWaitingConfirm = dataResponse;
                            renderWaitingPayment(dataWaitingConfirm);
                        } else {
                            dataWaitingConfirm = [];
                            renderWaitingPayment(dataWaitingConfirm);
                        }
                    } else {
                        dataWaitingConfirm = [];
                        renderWaitingPayment(dataWaitingConfirm);
                        $("#containerWaitingConfirm").html(
                            `<div class="w-100 d-flex align-items-center justify-content-center">
                            <p>${response.message}</p>
                        </div>`);
                    }
                },
                error: function(error) {
                    dataWaitingConfirm = [];
                    renderWaitingPayment(dataWaitingConfirm);
                    $("#containerWaitingConfirm").html(
                        `<div class="w-100 d-flex align-items-center justify-content-center">
                            <p>${"Terjadi kesalahan, silahkan hubungi admin"}</p>
                    </div>`);
                    console.error("Terjadi kesalahan dalam mengambil data cart:", xhr);
                }
            });
        }

        function renderWaitingPayment(dataResponse) {
            if (dataResponse.length > 0) {
                $("#containerWaitingConfirm").html(
                    dataResponse.map((transaksi, index) => {
                        const createdAt = new Date(transaksi.created_at);
                        const formattedDate = createdAt.getDate().toString().padStart(2,
                                "0") + "/" +
                            (createdAt.getMonth() + 1).toString().padStart(2, "0") + "/" +
                            createdAt.getFullYear();
                        return `
                            <div class="w-100 d-flex flex-column px-2 py-2 px-lg-2 mb-3 border-bottom border-1">
                                <div class="w-100 d-flex align-items-center justify-content-between mb-1 gap-4">
                                    <strong class="d-inline-block fw-bold" style="font-size: 16px; line-height: 1.5rem" style="word-break: break-all">
                                        ${transaksi.code}
                                    </strong>
                                    <span class="badge text-bg-primary">
                                        ${transaksi.status == "1" 
                                            ? "Menunggu Konfirmasi Seller" 
                                            : transaksi.status == "2" 
                                            ? "Menunggu Konfirmasi Admin" 
                                            : transaksi.status == "3" 
                                            ? "Waiting Payment" 
                                            : transaksi.status == "4" 
                                            ? "Paid" 
                                            : transaksi.status == "5" 
                                            ? "On Packing" 
                                            : transaksi.status == "6" 
                                            ? "On Delivery" 
                                            : transaksi.status == "7" 
                                            ? "Received" 
                                            : transaksi.status == "8" 
                                            ? "Cancelled" 
                                            : ""}
                                    </span>
                                </div>
                                <span class="d-inline-block fw-medium fs-6 mb-2">Tanggal Pemesanan: ${formattedDate}</span>
                                <div class="w-100 d-flex flex-column gap-1">
                                    ${transaksi.transaction_products.length > 0 
                                        ? transaksi.transaction_products.slice(0, 2).map(product => {
                                            return `
                                                    <div class="w-lg-75 d-flex align-items-center gap-4">
                                                        <span class="fw-medium" style="font-size: 14px; line-height: 1.5rem">
                                                            ${product.product?.name ?? 'Unknown Product'}
                                                        </span>
                                                        <span class="fw-medium" style="font-size: 14px; line-height: 1.5rem">
                                                            ${product.qty ?? 0}x
                                                        </span>
                                                    </div>`;
                                        }).join("") 
                                        : ""
                                    }
                                    <div class="collapse" id="collapseExample${index}">
                                        ${transaksi.transaction_products.length > 0 
                                            ? transaksi.transaction_products.slice(2).map(product => {
                                                return `
                                                        <div class="w-lg-75 d-flex align-items-center gap-4">
                                                            <span class="fw-medium" style="font-size: 14px; line-height: 1.5rem">
                                                                ${product.product?.name ?? 'Unknown Product'}
                                                            </span>
                                                            <span class="fw-medium" style="font-size: 14px; line-height: 1.5rem">
                                                                ${product.qty ?? 0}x
                                                            </span>
                                                        </div>`;
                                        }).join("") 
                                            : ""
                                        }
                                    </div>
                                    <div class="w-100 d-flex align-items-center justify-content-between">
                                        <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                                            data-bs-toggle="collapse" href="#collapseExample${index}" role="button" aria-expanded="false"
                                            aria-controls="collapseExample${index}" style="font-size: 14px; line-height: 1.5;">
                                            Lihat lainnya...
                                        </a>
                                        <span class="d-inline-block fw-bold mb-2" style="font-size: 14px; line-height: 1.5rem">Total: <span style="font-size: 14px; color: #EE0000">
                                            ${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(transaksi.total)}
                                        </span></span>
                                    </div>
                                    <div class="w-100 d-flex align-items-center justify-content-end mt-1 gap-4">
                                        <a class="link-offset-2 link-underline link-underline-opacity-0 d-flex align-items-center gap-2 fw-bold lihat-detail"
                                            href="#" data-bs-toggle="modal" data-bs-target="#exampleModalToggle" style="font-size: 14px; line-height: 1.5;" data-id-transaksi="${transaksi.id}">
                                            Lihat Detail
                                            <i class="fa-solid fa-arrow-right" style="font-size: 14px;"></i>
                                        </a>
                                        <a class="link-offset-2 link-underline link-underline-opacity-0 d-flex align-items-center gap-2 fw-bold text-danger batalkan-pesanan"
                                            href="#"style="font-size: 14px; line-height: 1.5;" data-code="${transaksi.code}">
                                            Batalkan Pesanan
                                        </a>
                                    </div>
                                </div>
                            </div>`;
                    }).join("")
                );
            } else {
                $("#containerWaitingConfirm").html(
                    `<div class="w-100 d-flex align-items-center justify-content-center">
                    <p>Data Transaksi Kosong</p>
                </div>`);
            }
        }

        getDataWaitingConfirm();

        function formatTanggal(dateString) {
            if (!dateString) return "-"; // Handle jika tanggal kosong

            const date = new Date(dateString);
            const options = {
                day: "numeric",
                month: "long",
                year: "numeric",
                hour: "2-digit",
                minute: "2-digit",
                hour12: false, // Menggunakan format 24 jam
            };

            return new Intl.DateTimeFormat("id-ID", options).format(date);
        }

        function updateDetailTransaksi(detail) {
            if (!detail || Object.keys(detail).length === 0) {
                // $("#containerDetailTransaksi").html(
                //     `<div class="w-100 d-flex align-items-center justify-content-center">
            //     <p>Data Detail Transaksi Kosong</p>
            // </div>`);
                return;
            }

            // Jika detail tidak kosong, jalankan logika berikut
            console.log("Detail transaksi:", detail);

            // mengelompokkan detail.transaction_products dari seller id
            let dataProductBySeller = detail.transaction_products.reduce((acc, product) => {
                let sellerId = product.seller.id;
                if (!acc[sellerId]) {
                    acc[sellerId] = [];
                }
                acc[sellerId].push(product);
                return acc;
            }, {});

            // console.log("Product by Seller", dataProductBySeller);

            $("#containerDetailTransaksi").html(
                `<div class="w-100 d-flex flex-column gap-2 px-3 py-3 border border-1 rounded-3 mb-3">
                    <strong style="font-size: 16px; line-height: 1.5;">Detail Pesanan</strong>
                    <div class="w-100 mt-1 d-flex flex-wrap align-items-center justify-content-between">
                        <span class="text-secondary" style="font-size: 14px; line-height: 1.5;">No. Pesanan</span>
                        <span class="fw-bold text-primary"
                            style="font-size: 14px; line-height: 1.5;">${detail.code}</span>
                    </div>
                    <div class="w-100 mt-1 d-flex flex-wrap align-items-center justify-content-between">
                        <span class="text-secondary" style="font-size: 14px; line-height: 1.5;">Tanggal Pembelian</span>
                        <span class="" style="font-size: 14px; line-height: 1.5;">
                            ${formatTanggal(detail.created_at)}
                        </span>
                    </div>
                </div>
                <div class="w-100 d-flex flex-column gap-2 px-3 py-3 border border-1 rounded-3 mb-3">
                    <strong style="font-size: 16px; line-height: 1.5;">Detail Produk</strong>
                    <section id="containerDetailProduct" class="w-100">
                        ${Object.keys(dataProductBySeller).map(sellerId => {
                            let items = dataProductBySeller[sellerId];
                            let sellerName = items[0].seller?.name ||
                                    `Toko Seller Id ${sellerId}`;
                            
                            return `<div class="w-100 mb-3">
                                                                <button type="button" class="lihat-seller w-100 d-flex flex-row align-items-center gap-2" style="cursor: pointer; background-color: transparent; border: none; outline: none;" data-seller-id="${sellerId}" data-seller-name="${sellerName}" data-username="${items[0].seller?.username}">
                                                                    <i class="fa-solid fa-circle-check" style="color: #229FE1; font-size: 12px;"></i>
                                                                    <span class="fw-semibold" style="font-size: 16px; line-height: 1.5;">
                                                                        ${sellerName}
                                                                    </span>
                                                                </button>
                                                                ${items.map((product, index) =>{
                                                                                return `<div class="w-100 d-flex flex-column gap-2 px-4 mt-2">
                                    <span class="" style="font-size: 14px; line-height: 1.5;">
                                        ${product.product?.name}
                                    </span>
                                    <span class="text-secondary" style="font-size: 14px; line-height: 1.5;">
                                        ${product.qty} x ${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(product.product?.price || 0)}
                                    </span>
                                </div>`
                                                                            }).join('')}
                                                                        </div>`
                        }).join('')}
                    </section>
                </div>
                <div class="w-100 d-flex flex-column gap-2 px-3 py-3 border border-1 rounded-3 mb-3">
                    <strong style="font-size: 16px; line-height: 1.5;">Info Pengiriman</strong>
                    <div id="selectedAddressPrimary"
                        class="w-100 d-flex align-items-start justify-content-between gap-4 gap-lg-5">
                        <div class="d-flex flex-column">
                            <strong class="fw-bold" style="font-size: 16px; line-height: 1.5rem">
                                ${detail.customer_address?.name}
                            </strong>
                            <span class="fw-medium" style="font-size: 14px; line-height: 1.5rem">
                                ${detail.customer_address?.phone}
                            </span>
                            <div class="fw-medium text-wrap w-md-75 w-lg-75"
                                style="font-size: 14px; line-height: 1.5rem;">
                                ${detail.customer_address?.address}, ${detail.customer_address?.road}, 
                                ${detail.customer_address?.city}, ${detail.customer_address?.province} ${detail.customer_address?.zip_code}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-100 d-flex flex-column gap-2 px-3 py-3 border border-1 rounded-3">
                    <strong style="font-size: 16px; line-height: 1.5;">Rincian Pembayaran</strong>
                    <section id="containerRincianPembayaran" class="w-100 d-flex flex-column gap-2 mt-1">
                        <div class="w-100 d-flex flex-row align-items-center justify-content-between gap-2">
                            <span style="font-size: 14px; line-height: 1.5;">Sub Total</span>
                            <span class="fw-semibold" style="font-size: 14px; line-height: 1.5;">
                                ${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(detail?.subtotal || 0)}
                            </span>
                        </div>
                        <div class="w-100 d-flex flex-row align-items-center justify-content-between gap-2">
                            <span style="font-size: 14px; line-height: 1.5;">Tagihan Lainnya</span>
                            <span class="fw-semibold" style="font-size: 14px; line-height: 1.5;">
                                ${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(detail?.other_cost || 0)}
                            </span>
                        </div>
                        <div class="w-100 d-flex flex-row align-items-center justify-content-between gap-2">
                            <span style="font-size: 14px; line-height: 1.5;">Biaya Pengiriman</span>
                            <span class="fw-semibold" style="font-size: 14px; line-height: 1.5;">
                                ${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(detail?.shipping_cost || 0)}
                            </span>
                        </div>
                        <div class="w-100 d-flex flex-row align-items-center justify-content-between gap-2">
                            <div class="col">
                                <span class="fs-6 fw-semibold">Total Belanja</span>
                            </div>
                            <div class="col text-end">
                                <span class="fs-6 fw-bold">
                                    ${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(detail?.total || 0)}
                                </span>
                            </div>
                        </div>
                    </section>
                </div>`);
        }

        function cancelTransaksi(transaksiId) {
            return new Promise((resolve, reject) => {
                sweetAlertLoading()
                let formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('order_id', transaksiId);

                $.ajax({
                    headers: {
                        'X-API-KEY': '{{ env('API_KEY') }}'
                    },
                    url: '{{ route('api.customer.transaction.cancel') }}',
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

        $(document).on("click", ".lihat-detail", function() {
            let transaksiId = $(this).data('id-transaksi');
            console.log("Transaksi Id", transaksiId);
            detailTransaksi = dataWaitingConfirm.find((transaksi) => transaksi.id == transaksiId);
            updateDetailTransaksi(detailTransaksi)
        });

        $(document).on("click", ".btn-close.detail", function() {
            detailTransaksi = {};
            updateDetailTransaksi(detailTransaksi)
        });

        $(document).on("click", ".dropdown-item", function() {
            let status = $(this).data('status');
            statusFilter = status;
            getDataWaitingConfirm(statusFilter);
            //tambahkan class aktif pada dropdown item yang diklik
            $('.dropdown-item').removeClass('active');
            $(this).addClass('active');
            $('.search-input').val('');
        });

        $(document).on("click", ".lihat-seller", function() {
            let sellerName = $(this).data('seller-name');
            let sellerId = $(this).data('seller-id');
            let sellerUsername = $(this).data('username');

            window.location.href =
                `{{ url('/detail-seller/${sellerUsername}') }}`;
        });

        $(document).on("click", ".batalkan-pesanan", function() {
            Swal.fire({
                title: "Batalkan Pesanan",
                text: "Apakah anda yakin ingin membatalkan pesanan ini? Pesanan yang telah dibatalkan tidak dapat dikembalikan",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#229FE1",
                cancelButtonColor: "#d33",
                confirmButtonText: "Batalkan Pesanan",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    let transaksiCode = $(this).data('code');
                    console.log("Transaksi Id", transaksiCode);
                    cancelTransaksi(transaksiCode)
                        .then((response) => {
                            console.log("Response API Add Address Customer: ", response);
                            if (response.success === true && response.message ==
                                'Success cancel transaction') {
                                Swal.close();
                                sweetAlertSuccess("Berhasil membatalkan pesanan");
                                getDataWaitingConfirm();
                            } else {
                                Swal.close();
                                sweetAlertDanger(response.message);
                            }
                        })
                        .catch((error) => {
                            Swal.close();
                            console.error('Terjadi kesalahan dalam membatalkan pesanan:', error);
                            sweetAlertDanger(error.responseJSON.message);
                        });
                }
            });
        });

        $(document).on("input", ".search-input", function() {
            let query = $(this).val().toLowerCase();

            let filteredData = dataWaitingConfirm.filter(transaksi => {
                let transaksiCode = transaksi.code.toLowerCase();
                let sellerName = transaksi.seller?.name?.toLowerCase() || "";

                let productNames = transaksi.transaction_products
                    .map(product => product.product?.name?.toLowerCase() || "")
                    .join(" ");

                return (
                    transaksiCode.includes(query) ||
                    sellerName.includes(query) ||
                    productNames.includes(query)
                );
            });

            renderWaitingPayment(filteredData);
        });
    </script>
@endsection
