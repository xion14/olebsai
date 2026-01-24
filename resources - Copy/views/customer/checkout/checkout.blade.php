@extends('__layouts.__frontend.main')

@section('body')
<style>
/* Styling tabel agar cantik */
    .table-custom {
        border-collapse: separate; /* WAJIB untuk border-radius */
        border-spacing: 0;
        width: 100%;
        max-width: 800px;
        margin: 20px auto;
        border: 1px solid #ddd;
        border-radius: 12px; /* Membuat sudut luar membulat */
        overflow: hidden; /* Memastikan isi mengikuti kurva */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1); /* Bayangan cantik */
    }

    /* Styling Cell (td) */
    .table-custom td {
        padding: 15px;
        border-bottom: 1px solid #eee;
        color: #333;
    }

    /* Menghapus border bawah pada baris terakhir */
    .table-custom tr:last-child td {
        border-bottom: none;
    }

    /* Warna Selang-Seling (Zebra Stripes) */
    .table-custom tr:nth-child(even) {
        background-color: #f9f9f9; /* Warna baris genap */
    }
    
    .table-custom tr:nth-child(odd) {
        background-color: #ffffff; /* Warna baris ganjil */
    }

    /* Membuat sudut membulat di pojok atas-kiri dan bawah-kiri */
    .table-custom tr:first-child td:first-child {
        border-top-left-radius: 12px;
    }
    
    /* Membuat sudut membulat di pojok atas-kanan dan bawah-kanan */
    .table-custom tr:first-child td:last-child {
        border-top-right-radius: 12px;
    }
    
    /* Sudut bawah */
    .table-custom tr:last-child td:first-child {
        border-bottom-left-radius: 12px;
    }
    
    .table-custom tr:last-child td:last-child {
        border-bottom-right-radius: 12px;
    }
</style>
    <div class="w-100 mt-3">
        <div class="row px-2 gap-5">
            <div class="col-12 col-lg-7 border border-1 rounded shadow-sm p-4">
                <div class="w-100 d-flex justify-content-end align-items-center">
                    <button id="btnDelete" type="button"
                        class="d-flex flex-row align-items-center btn-error mb-2 mb-lg-0 mx-0 mx-lg-2 text-nowrap">
                        <i class="bi bi-trash3" style="font-size: 16px;"></i>
                        <span class="d-inline-block mx-1">Hapus</span>
                    </button>
                </div>
                <div class="w-100 mt-3">
                    <div class="w-100 mb-5">
                        <div class="d-flex flex-row align-items-center gap-2 mb-3">
                            <input id="select-all-product-cart" class="form-check-input m-0" type="checkbox" value=""
                                id="namaToko">
                            <label class="fw-semibold" for="namaToko" style="font-size: 14px; line-height: 1.5;">
                                Semua
                            </label>
                        </div>
                        <section id="containerCart" class="w-100">
                        </section>
                    </div>
                </div>
            </div>
            <div class="d-none d-lg-block col-12 col-lg-3 col-xl-4 p-0">
                <div class="w-100 py-4 px-3 border border-1 rounded shadow-sm">
                    <h6 class="fw-bold mb-4">Alamat Penerima</h6>
                    <div class="w-100 d-flex flex-column gap-2 containerCustomerAddressList">

                    </div>
                </div>
				
				<div class="w-100 py-4 px-3 border border-1 rounded shadow-sm mt-3">
                    <h6 class="fw-bold mb-4">Ongkos Kirim</h6>
					
					
					<!-- Start Ongkir --->
				
				<div class="w-100 mt-3" id="ongkir">
														
					<div class="w-100 mt-2">
						<div id="other-costs">
							<div class="table-responsive" id="detail-ongkir" style="display:">
<table class="table table-bordered table-custom" id="cost-table"">									
<tbody id="cost-shipping"></tbody></table>
							</div>


							

						</div>
					</div>
				</div>
				
				<div class="w-100 mt-3">
					<div class="mt-3 d-flex justify-content-center" id="show_shipping">
						<img src="/images/LoaderIcon.gif" id="loaderIcon" style="display:none" />
						<button id="show-shipping" class="btn btn-sm btn-success py-1 px-3" style="font-size: 14px; height: 32px;">
						{{---<i class="fas fa-check"></i>---}} Lihat Ongkir
						</button>
					</div>
				</div>
					
					
					
					
					<!-- End Ongkir --->
					
					
                </div>
				
                <div class="w-100 py-4 px-3 border border-1 rounded shadow-sm mt-3">
                    <h6 class="fw-bold mb-4">
                        Voucher Diskon
                    </h6>
                    <div class="w-100 d-flex flex-column gap-2 continerListVoucher">
                        {{-- <div class="card-voucher-checkout shadow-sm border border-1">
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
                                    Gratis Ongkir
                                </p>
                                <p class="sub-text">
                                    Min. Belanja Rp 50Rb
                                </p>
                                <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                                    href="#" style="font-size: 12px; line-height: 1.5; font-weight: 700;"
                                    data-bs-toggle="modal" data-bs-target="#exampleModalSnK">
                                    Syarat & Ketentuan
                                </a>
                            </div>
                            <i class="fa-solid fa-circle-check" style="color: #64bae8; font-size: 32px;"></i>
                        </div>

                        <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                            data-bs-toggle="collapse" href="#collapsVoucher" role="button" aria-expanded="false"
                            aria-controls="collapsVoucher" style="font-size: 14px; line-height: 1.5;">
                            Lihat voucher lainnya
                        </a>
                        <div class="collapse" id="collapsVoucher">
                            @foreach (range(1, 4) as $index)
                                <div class="card-voucher-checkout shadow-sm border border-1 mb-3">
                                    <svg class="wave-voucher-checkout" viewBox="0 0 1440 320"
                                        xmlns="http://www.w3.org/2000/svg">
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
                                            Gratis Ongkir
                                        </p>
                                        <p class="sub-text">
                                            Min. Belanja Rp 50Rb
                                        </p>
                                        <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                                            href="#" style="font-size: 12px; line-height: 1.5; font-weight: 700;"
                                            data-bs-toggle="modal" data-bs-target="#exampleModalSnK">
                                            Syarat & Ketentuan
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div> --}}
                    </div>
                </div>
                <div class="w-100 py-4 px-3 border border-1 rounded shadow-sm mt-3">
                    <h6 class="fw-bold mb-4">Ringkasan belanja</h6>
                    <div class="w-100 d-flex flex-column gap-2">
                        <section id="containerRingkasanBelanja" class="w-100 d-flex flex-column gap-2">

                        </section>
						<section id="containerIncludeShipping" class="w-100 d-flex flex-column gap-2">

                        </section>
                        <button type="button" class="btn btn-primary w-100 mt-1 btn-checkout">Pesan Sekarang</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div
        class="w-100 d-flex align-items-center justify-content-between fixed-bottom px-3 py-3 px-md-5 d-lg-none bg-white shadow-top">
        <div class="d-flex flex-column gap-1">
            <span class="fw-bold" style="font-size: 14px; line-height: 1.5;">Total:</span>
            <span class="fw-bold currentTotal" style="color: #EE0000; font-size: 14px; line-height: 1.5;">Rp 52.000</span>
            <a href="#"
                class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                style="font-size: 14px; line-height: 1.5; font-weight: 800;" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasCheckoutMobile" aria-controls="offcanvasCheckoutMobile">
                Lihat Detail
            </a>
        </div>
        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasCheckoutMobile" aria-controls="offcanvasCheckoutMobile">Check Out</button>
    </div>
@endsection

@section('modal')
    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasCheckoutMobile"
        aria-labelledby="offcanvasCheckoutMobileLabel" style="height: 110vh;">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasCheckoutMobileLabel">Detail Checkout</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <section class="w-100 d-flex flex-column gap-2 px-3 py-3 border border-1 rounded-3">
                <h6>Alamat Pengiriman</h6>
                <div class="w-100 d-flex flex-column gap-2 containerCustomerAddressList">

                </div>
            </section>
            <section class="w-100 d-flex flex-column gap-2 px-3 py-3 border border-1 rounded-3 mt-4">
                <h6>Voucher Diskon</h6>
                <div class="w-100 d-flex flex-column gap-2 continerListVoucher">
                    {{-- <div class="card-voucher-checkout shadow-sm border border-1">
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
                                Gratis Ongkir
                            </p>
                            <p class="sub-text">
                                Min. Belanja Rp 50Rb
                            </p>
                            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                                href="#" style="font-size: 12px; line-height: 1.5; font-weight: 700;"
                                data-bs-toggle="modal" data-bs-target="#exampleModalSnK">
                                Syarat & Ketentuan
                            </a>
                        </div>
                        <i class="fa-solid fa-circle-check" style="color: #64bae8; font-size: 32px;"></i>
                    </div>
                    <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                        data-bs-toggle="collapse" href="#collapsVoucher" role="button" aria-expanded="false"
                        aria-controls="collapsVoucher" style="font-size: 14px; line-height: 1.5;">
                        Lihat voucher lainnya
                    </a>
                    <div class="collapse" id="collapsVoucher">
                        @foreach (range(1, 4) as $index)
                            <div class="card-voucher-checkout shadow-sm border border-1 mb-3">
                                <svg class="wave-voucher-checkout" viewBox="0 0 1440 320"
                                    xmlns="http://www.w3.org/2000/svg">
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
                                        Gratis Ongkir
                                    </p>
                                    <p class="sub-text">
                                        Min. Belanja Rp 50Rb
                                    </p>
                                    <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                                        href="#" style="font-size: 12px; line-height: 1.5; font-weight: 700;"
                                        data-bs-toggle="modal" data-bs-target="#exampleModalSnK">
                                        Syarat & Ketentuan
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div> --}}
                </div>
            </section>
            <div class="w-100 d-flex flex-column gap-2 px-3 py-3 border border-1 rounded-3 mt-4">
                <h6>Ringkasan Belanja</h6>
                <section id="containerRingkasanBelanjaMobile" class="w-100 d-flex flex-column gap-2">
                </section>
				<section id="containerIncludeOngkir" class="w-100 d-flex flex-column gap-2">
                </section>
                <button type="button" class="btn btn-primary btn-checkout w-100 mt-3">Pesan Sekarang</button>
            </div>
        </div>
    </div>

    {{-- Modal Syarat & Ketentuan --}}
    <div class="modal fade" id="exampleModalSnK" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Detail Voucher
                    </h1>
                    <button type="button" class="btn-close close-modal-snk" data-bs-dismiss="modal" aria-label="Close"></button>
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
    @include('customer.checkout.script_checkout')
@endsection
