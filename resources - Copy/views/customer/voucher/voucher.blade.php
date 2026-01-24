@extends('__layouts.__frontend.main')

@section('body')
    <div id="containerListVoucher"
        class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-4 gap-y-2 mt-3 px-2">
    </div>
@endsection

@section('modal')
    {{-- Modal Syarat & Ketentuan --}}
    <div class="modal fade" id="exampleModalSnK" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Detail Voucher
                    </h1>
                    <button type="button" class="btn-close close-modal-snk" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="containerDetailVoucher" class="w-100 d-flex flex-column gap-1">

                    </div>
                    <div class="w-100 d-flex flex-column gap-1 mt-4">
                        <h6 class="fw-semibold m-0 p-0">Cara Pakai</h6>
                        <div class="w-100 d-flex gap-1">
                            <span class="" class="" style="font-size: 14px; line-height: 1.5;">1. </span>
                            <span class="" style="font-size: 14px; line-height: 1.5;">Cek halaman “Voucher” untuk
                                melihat Kupon yang telah didapat.</span>
                        </div>
                        <div class="w-100 d-flex gap-1">
                            <span class="" class="" style="font-size: 14px; line-height: 1.5;">2. </span>
                            <span class="" style="font-size: 14px; line-height: 1.5;">
                                Gunakan Kupon pada saat checkout.
                            </span>
                        </div>
                        <div class="w-100 d-flex gap-1">
                            <span class="" class="" style="font-size: 14px; line-height: 1.5;">3. </span>
                            <span class="" style="font-size: 14px; line-height: 1.5;">
                                Dapatkan notifikasi Kupon jika sudah berhasil digunakan.
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary close-modal-snk" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            let voucherSelected = {};
            let dataVoucher = [];

            function getDataVoucher() {
                $("#containerListVoucher").html(
                    `<div class="w-100 p-2 p-md-2 d-flex align-items-center justify-content-center">
                    <p>Proses ambil data...</p>
                </div>`);

                $.ajax({
                    headers: {
                        'X-API-KEY': '{{ env('API_KEY') }}'
                    },
                    url: "{{ route('api.voucher.active') }}",
                    type: "GET",
                    dataType: "JSON",
                    success: function(response) {
                        if (response.success) {
                            let dataResponse = response.data;

                            console.log("Response API Get Data Voucher: ", response.data);
                            if (dataResponse.length > 0) {
                                dataVoucher = dataResponse;
                                $("#containerListVoucher").html(`
                                    ${dataResponse.map((item, index) => {
                                        return `<div class="col p-2 p-md-2" key="${index}">
                                                <div class="card-voucher-checkout shadow-sm border border-1">
                                                    <svg class="wave-voucher-checkout" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M0,256L11.4,240C22.9,224,46,192,69,192C91.4,192,114,224,137,234.7C160,245,183,235,206,213.3C228.6,192,251,160,274,149.3C297.1,139,320,149,343,181.3C365.7,213,389,267,411,282.7C434.3,299,457,277,480,250.7C502.9,224,526,192,549,181.3C571.4,171,594,181,617,208C640,235,663,277,686,256C708.6,235,731,149,754,122.7C777.1,96,800,128,823,165.3C845.7,203,869,245,891,224C914.3,203,937,117,960,112C982.9,107,1006,181,1029,197.3C1051.4,213,1074,171,1097,144C1120,117,1143,107,1166,133.3C1188.6,160,1211,224,1234,218.7C1257.1,213,1280,139,1303,133.3C1325.7,128,1349,192,1371,192C1394.3,192,1417,128,1429,96L1440,64L1440,320L1428.6,320C1417.1,320,1394,320,1371,320C1348.6,320,1326,320,1303,320C1280,320,1257,320,1234,320C1211.4,320,1189,320,1166,320C1142.9,320,1120,320,1097,320C1074.3,320,1051,320,1029,320C1005.7,320,983,320,960,320C937.1,320,914,320,891,320C868.6,320,846,320,823,320C800,320,777,320,754,320C731.4,320,709,320,686,320C662.9,320,640,320,617,320C594.3,320,571,320,549,320C525.7,320,503,320,480,320C457.1,320,434,320,411,320C388.6,320,366,320,343,320C320,320,297,320,274,320C251.4,320,229,320,206,320C182.9,320,160,320,137,320C114.3,320,91,320,69,320C45.7,320,23,320,11,320L0,320Z"
                                                            fill-opacity="1"></path>
                                                    </svg>
                                                    <div class="icon-container">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                                            width="32" height="32" class="size-6">
                                                            <path fill="#64bae8" fill-rule="evenodd"
                                                                d="M1.5 6.375c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v3.026a.75.75 0 0 1-.375.65 2.249 2.249 0 0 0 0 3.898.75.75 0 0 1 .375.65v3.026c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 17.625v-3.026a.75.75 0 0 1 .374-.65 2.249 2.249 0 0 0 0-3.898.75.75 0 0 1-.374-.65V6.375Zm15-1.125a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-1.5 0V6a.75.75 0 0 1 .75-.75Zm.75 4.5a.75.75 0 0 0-1.5 0v.75a.75.75 0 0 0 1.5 0v-.75Zm-.75 3a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-1.5 0v-.75a.75.75 0 0 1 .75-.75Zm.75 4.5a.75.75 0 0 0-1.5 0V18a.75.75 0 0 0 1.5 0v-.75ZM6 12a.75.75 0 0 1 .75-.75H12a.75.75 0 0 1 0 1.5H6.75A.75.75 0 0 1 6 12Zm.75 2.25a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                    <div class="message-text-container">
                                                        <p class="message-text">
                                                            ${item.name.length > 20 ? item.name.substring(0, 20) + "..." : item.name}
                                                        </p>
                                                        <p class="sub-text" style=" font-size: 12px line-height: 1.5;">
                                                            Min. Belanja Rp ${new Intl.NumberFormat("id-ID").format(item.minimum_transaction)}
                                                        </p>
                                                        <a id="syaratKetentuan" class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                                                            href="#" style="font-size: 12px; line-height: 1.5; font-weight: 700;"
                                                            data-bs-toggle="modal" data-bs-target="#exampleModalSnK" data-voucher-id="${item.id}">
                                                            Syarat & Ketentuan
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>`;
                                    }).join("")}
                                `);
                            } else {
                                dataVoucher = [];
                                $("#containerListVoucher").html(
                                    `<div class="w-100 p-2 p-md-2 d-flex align-items-center justify-content-center">
                                <p>${"Saat ini belum ada voucher yang tersedia"}</p>
                            </div>`);
                            }
                        } else {
                            dataVoucher = [];
                            $("#containerListVoucher").html(
                                `<div class="w-100 p-2 p-md-2 d-flex align-items-center justify-content-center">
                                <p>${"Terjadi kesalahan mengambil data voucher"}</p>
                            </div>`);
                        }
                    },
                    error: function(error) {
                        dataVoucher = [];
                        $("#containerListVoucher").html(
                            `<div class="w-100 p-2 p-md-2 d-flex align-items-center justify-content-center">
                            <p>${error.responseJSON.text}</p>
                        </div>`);
                        console.error("Terjadi kesalahan mengambil data voucher:", error);
                    }
                });
            }
            getDataVoucher();

            $(document).on("click", "#syaratKetentuan", function() {
                let voucherId = $(this).data("voucher-id");
                $('#exampleModalSnK').modal('show');
                voucherSelected = dataVoucher.find(item => item.id == voucherId);
                console.log("Voucher Selected: ", voucherSelected);
                $("#containerDetailVoucher").html(`<h6 class="fw-semibold m-0 p-0">
                    Syarat & Ketentuan ${voucherSelected?.name}
                    </h6>
                    <div class="w-100 d-flex gap-1">
                        <span class="" class="" style="font-size: 14px; line-height: 1.5;">1. </span>
                        <span class="" style="font-size: 14px; line-height: 1.5;">
                            Voucher hanya digunakan untuk ${voucherSelected?.type == "1" ? "ongkos kirim" : "pembelian produk"}
                        </span>
                    </div>
                <div class="w-100 d-flex gap-1">
                    <span class="" class="" style="font-size: 14px; line-height: 1.5;">2. </span>
                    <span class="" style="font-size: 14px; line-height: 1.5;">
                        Minimal transaksi sebesar Rp ${new Intl.NumberFormat("id-ID").format(voucherSelected?.minimum_transaction)}
                    </span>
                </div>
                <div class="w-100 d-flex gap-1">
                    <span class="" class="" style="font-size: 14px; line-height: 1.5;">3. </span>
                    <span class="" style="font-size: 14px; line-height: 1.5;">
                        Maksimal diskon sebesar Rp. ${new Intl.NumberFormat("id-ID").format(voucherSelected?.max_discount)}
                    </span>
                </div>
                <div class="w-100 d-flex gap-1">
                    <span class="" class="" style="font-size: 14px; line-height: 1.5;">4. </span>
                    <span class="" style="font-size: 14px; line-height: 1.5;">
                        Voucher dapat digunakan mulai ${moment(voucherSelected?.start_date).format("DD MMMM YYYY")} sampai ${moment(voucherSelected?.expired_date).format("DD MMMM YYYY")}
                    </span>
                </div>`);
            });

            $(document).on("click", ".close-modal-snk", function() {
                voucherSelected = {};
                $('#exampleModalSnK').modal('hide');
            });
        });
    </script>
@endsection
