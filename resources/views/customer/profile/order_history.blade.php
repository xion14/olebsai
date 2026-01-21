@extends('__layouts.__frontend.setting_profile')

@section('content-setting')
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <div class="col-12 col-lg-8 p-2 p-md-4 p-lg-4 mt-4 mt-lg-2 mt-lg-0 mx-lg-4 border border-0 border-lg-1 rounded-3">
        <div class="w-100 d-flex align-items-center justify-content-between">
            <strong class="fw-bold" style="font-size: 18px; line-height: 1.5rem">
                Daftar Transaksi
            </strong>
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Filter Status
                </button>
                <ul class="dropdown-menu">
                    <li><button class="dropdown-item active" type="button" data-status="">Semua</button></li>
                    <li><button class="dropdown-item" type="button" data-status="1">Menunggu Konfirmasi Seller</button>
                    </li>
                    <li><button class="dropdown-item" type="button" data-status="2">Menunggu Konfirmasi Admin</button></li>
                    <li><button class="dropdown-item" type="button" data-status="3">Menunggu Pembayaran</button></li>
                    <li><button class="dropdown-item" type="button" data-status="4">Pembayaran Sukses</button></li>
                    <li><button class="dropdown-item" type="button" data-status="5">Pesanan Disiapkan</button></li>
                    <li><button class="dropdown-item" type="button" data-status="6">Pesanan Dikirim</button></li>
                    <li><button class="dropdown-item" type="button" data-status="7">Pesanan Diterima</button></li>
                    <li><button class="dropdown-item" type="button" data-status="8">Pesanan Dibatalkan</button></li>
                </ul>
            </div>
        </div>
        <div class="search-container mt-4">
            <input type="text" class="search-input" placeholder="Cari transaksi">
            <i class="fas fa-search search-icon"></i>
        </div>
        <div id="containeOrderHistory" class="w-100 mt-3 p-0">

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

    <div class="modal fade" id="modalDelivery" aria-hidden="true" aria-labelledby="modalDeliveryLabel" >
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalDeliveryLabel">Tracking Delivery</h1>
                    <button type="button" class="btn-close detail" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="w-100 d-flex flex-column align-items-center justify-content-center gap-4">
                        <img src="{{ asset('assets/image/illustrasi/illustrasi_delivery.svg') }}" alt="Illustrasi Delivery"
                            class="w-100 h-auto object-fit-cover" style="object-position: center; max-width: 300px">
                        <span class="m-0 text-center">Status: <strong id="statusDelivery"
                                class="fw-bold m-0"></strong></span>
                    </div>
                    <section id="containerDelivery" class="w-100 mt-5"></section>
                </div>
            </div>
        </div>
    </div>

	<div id="frmAdd" style="z-index:4001"><input type="hidden" id="item_id" /><input type="hidden" id="item_code" /><input type="hidden" id="item_variant" /><textarea style="display:block" style="z-index:4002" name="txtmessage" id="txtmessage" cols="55" rows="5"></textarea></div>

@endsection

@section('script-setting')
	<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script type="text/javascript">
	
		var add_window = $("#frmAdd").dialog({
		  title: "My New Dialog Title",
		  closeText: "",
		  autoOpen: false,
		  height: 280,
		  width: 650,
		  modal: true,
		  buttons: {
			"--Submit Review--": addComment
		  },
		  close: function() {
			$('#exampleModalToggle').css('display', 'block');
			// // // // // add_window.dialog( "close" );
		  }
		});
		
		$("#frmAdd").closest('.ui-dialog').css("z-index", 4000);
			
		function addComment() {
			$('#exampleModalToggle').css('display', 'block');
			add_window.dialog( "close" );
			callCrudAction('add','');
		}
		
		$(".review-item").on("click", function() {
			// // // // // alert('hihihi');
			add_window.dialog( "open" );
		});
		
		function review(element) {
			// // // // // alert('transaction-item = ' + element.getAttribute('id'));
			$("#item_id").val(element.getAttribute('data-item-id'));
			$("#item_code").val(element.getAttribute('data-item-code'));
			$("#item_variant").val(element.getAttribute('data-item-variant'));
			// // // // // alert('hey = ' + element.getAttribute('data-item-review'));
			$("#txtmessage").val(element.getAttribute('data-item-review') != 'null' ? element.getAttribute('data-item-review') : '');
			$('#exampleModalToggle').css('display', 'none');
			add_window.dialog( "option", "title", element.getAttribute('data-item-detail'));
			add_window.dialog( "open" );
		}
		
		function callCrudAction(action,id) {
			var comment_var = '#comment-list-box-'+$("#item_code").val() + "_" + $("#item_id").val()+ "_" + ($("#item_variant").val()).replace(/ /g,'');
			var queryString;
			//It is better to sanitise user input to avoid XSS attack and SQL injection
			switch(action) {
				case "add":
					queryString = '_token={{ csrf_token() }}&action='+action+'&item_id='+ $("#item_id").val()+'&item_variant='+ $("#item_variant").val()+'&item_code='+ $("#item_code").val()+'&item_review='+ $("#txtmessage").val();
				break;
				case "edit":
					queryString = 'action='+action+'&message_id='+ id + '&txtmessage='+ $("#edit-message").val();
				break;
				// // // // // case "delete":
					// // // // // queryString = 'action='+action+'&message_id='+ id;
				// // // // // break;
			}	 
			$.ajax({
			headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
			url: "{{ url('submit-review') }}",
			data:queryString,
			type: "POST",
			success:function(data){
				switch(action) {
					case "add":
						$(comment_var).html(data);
					break;
				}
				$("#txtmessage").val('');
				// // // // // $("#edit-message").val('');
				// // // // // $("#loaderIcon").hide();
			},
			error:function (){}
			});
		}
	
        let dataWaitingConfirm = [];
        let detailTransaksi = {};
        let statusFilter = "";


        function getDataOrderHistory() {
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
                            renderOrderHistory(dataWaitingConfirm);
                        } else {
                            dataWaitingConfirm = [];
                            renderOrderHistory(dataWaitingConfirm);
                        }
                    } else {
                        dataWaitingConfirm = [];
                        renderOrderHistory(dataWaitingConfirm);
                        $("#containeOrderHistory").html(
                            `<div class="w-100 d-flex align-items-center justify-content-center">
                            <p>${response.message}</p>
                        </div>`);
                    }
                },
                error: function(error) {
                    dataWaitingConfirm = [];
                    renderOrderHistory(dataWaitingConfirm);
                    $("#containeOrderHistory").html(
                        `<div class="w-100 d-flex align-items-center justify-content-center">
                            <p>${"Terjadi kesalahan, silahkan hubungi admin"}</p>
                    </div>`);
                    console.error("Terjadi kesalahan dalam mengambil data cart:", xhr);
                }
            });
        }

        function renderOrderHistory(dataResponse) {
            if (dataResponse.length > 0) {
                $("#containeOrderHistory").html(
                    dataResponse.map((transaksi, index) => {
                        const createdAt = new Date(transaksi.created_at);
                        const formattedDate = createdAt.getDate().toString().padStart(2,
                                "0") + "/" +
                            (createdAt.getMonth() + 1).toString().padStart(2, "0") + "/" +
                            createdAt.getFullYear();
                        return `
                            <div class="w-100 d-flex flex-column px-2 py-2 px-lg-2 mb-3 border-bottom border-1">
                                <div class="w-100 d-flex align-items-center justify-content-between mb-1 gap-4" style="word-break: break-all">
                                    <strong class="d-inline-block fw-bold" style="font-size: 16px; line-height: 1.5rem">
                                        ${transaksi.code}
                                    </strong>
                                    <span class="badge text-bg-primary" ${(transaksi.status == 6 || transaksi.status == 7) ? 'style="cursor: pointer" onClick="checkDelivery('+ transaksi.id + ',' + transaksi.status +')"' : ''} >
                                        ${transaksi.status == "1" 
                                            ? "Menunggu Konfirmasi Seller" 
                                            : transaksi.status == "2" 
                                            ? "Menunggu Konfirmasi Admin" 
                                            : transaksi.status == "3" 
                                            ? "Menunggu Pembayaran" 
                                            : transaksi.status == "4" 
                                            ? "Pembayaran Sukses" 
                                            : transaksi.status == "5" 
                                            ? "Pesanan Disiapkan" 
                                            : transaksi.status == "6" 
                                            ? "Pesanan Dikirim" 
                                            : transaksi.status == "7" 
                                            ? "Pesanan Diterima" 
                                            : transaksi.status == "8" 
                                            ? "Pesanan Dibatalkan" 
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
                                    <div class="w-100 d-flex align-items-center justify-content-end gap-4 mt-1">
                                        ${
                                            transaksi.status == 6
                                            ? `<a class="link-offset-2 link-underline link-underline-opacity-0 d-flex align-items-center gap-2 fw-bold text-success"
                                                                href="#" onclick="transactionComplete('${transaksi.code}')" style="font-size: 14px; line-height: 1.5;">
                                                                Pesanan Diterima
                                                                <i class="fa-solid fa-check" style="font-size: 14px;"></i>
                                                            </a>`
                                            : ""
                                        }
                                        &nbsp; &nbsp; 
                                        <a class="link-offset-2 link-underline link-underline-opacity-0 d-flex align-items-center gap-2 fw-bold lihat-detail"
                                            href="#" data-bs-toggle="modal" data-bs-target="#exampleModalToggle" style="font-size: 14px; line-height: 1.5;" data-id-transaksi="${transaksi.id}">
                                            Lihat Detail
                                            <i class="fa-solid fa-arrow-right" style="font-size: 14px;"></i>
                                        </a>
                                        ${[1, 2, 3].includes(transaksi.status) ? `
                                                        <a class="link-offset-2 link-underline link-underline-opacity-0 d-flex align-items-center gap-2 fw-bold text-danger batalkan-pesanan"
                                                            href="#"style="font-size: 14px; line-height: 1.5;" data-code="${transaksi.code}">
                                                            Batalkan Pesanan
                                                        </a>
                                                    ` : ""}
                                    </div>
                                </div>
                            </div>`;
                    }).join("")
                );
            } else {
                $("#containeOrderHistory").html(
                    `<div class="w-100 d-flex align-items-center justify-content-center">
                    <p>Data Transaksi Kosong</p>
                </div>`);
            }
        }

        getDataOrderHistory();

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
					<div class="w-100 mt-1 d-flex flex-wrap align-items-center justify-content-between">
                        <span class="text-secondary" style="font-size: 14px; line-height: 1.5;">Chat/Kontak/Komplain</span>
                        <span class="" style="font-size: 14px; line-height: 1.5;">
                            <a href="https://wa.me/082113498393" class="btn-whatsapp" target="_blank">
								<i class="bi bi-whatsapp"></i> 
								Chat Now
							</a>
                        </span>
                    </div>
                </div>
                <div class="w-100 d-flex flex-column gap-2 px-3 py-3 border border-1 rounded-3 mb-3">
                    <strong style="font-size: 16px; line-height: 1.5;">Detail Produk</strong>
                    <section id="containerDetailProduct" class="w-100">
                        ${Object.keys(dataProductBySeller).map(sellerId => {
                            let items = dataProductBySeller[sellerId];
							let sellerPhone = items[0].seller?.phone;
							let lbr = detail.status==7 ? 'Review !' : '';
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
                                                            return `
                                        <div class="w-100 d-flex flex-column gap-2 px-4 mt-2">
											<div class="row">
												<div class="form-group col-md-4">
													<span class="" style="font-size: 14px; line-height: 1.5;">
														${product.product?.name} ${product.variant}
													</span>
													<span class="text-secondary" style="font-size: 14px; line-height: 1.5;">
														${product.qty} x ${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(product?.price || 0)}<br />
													</span>
													<span class="" style="font-size: 14px; line-height: 1.5;">
														<a href="https://wa.me/62${sellerPhone}/?text=Transaction ID ${detail.code}, ${product.product?.name} ${product.variant}" class="btn-whatsapp" target="_blank">
															<i class="bi bi-whatsapp"></i> 
															Chat Now
														</a>
													</span>
												</div>
												<div class="form-group col-md-3">
													<span class="" style="font-size: 14px; line-height: 1.5;">
													{{---
														<button id="id${detail.code}_${product.product.id}" type="button" class="btn btn-outline-primary d-flex align-items-center gap-2 review-xitem" data-bs-toggle="modal"
															data-bs-target="#staticBackdropAddAddress">
															Review
														</button>
													---}}
														<a href="#" class="review-item" data-item-review="${product.review}" data-item-id="${product.product.id}" id="${detail.code}_${product.product.id}" data-item-variant="${product.variant}" data-item-code="${detail.code}" data-item-detail="${detail.code} : ${product.qty} x ${product.product?.name}" onclick="return review(this);">`+lbr+`</a>
													
														
													
													</span>
													
												</div>
												<div class="form-group col-md-5">
													<span class="" style="font-size: 14px; line-height: 1.5;" id="comment-list-box-${detail.code}_${product.product.id}_${(product.variant!=null?product.variant:'').replace(/ /g,'')}">
													<div class="message-content">${product.review==null ? '' : product.review}</div>
													<div class="message-time">${product.reviewed_at==null ? '' : product.reviewed_at}</div>
													</span>
												</div>
											</div>
                                        </div>`}).join('')}
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
            getDataOrderHistory(statusFilter);
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

        function checkDelivery(id, statusDelivery) {
            console.log("Status Delivery", statusDelivery);
            $('#statusDelivery').text(statusDelivery == 6 ? "Pesanan Dikirim" : statusDelivery == 7 ? "Pesanan Diterima" :
                "Pesanan Dikirim");
            $.ajax({
                headers: {
                    'X-API-KEY': '{{ env('API_KEY') }}'
                },
                url: '/api/delivery?transaction_id=' + id,
                type: 'GET',
                processData: false,
                contentType: false,
                success: function(response) {
                    var ui = ``;
                    if (response.success) {
                        var data = response.data;
                        console.log('data tracking', data);

                        ui += `
                            <div class="timeline">
                                ${data.map((item, index) => {
                                    return `
                                                    <div class="timeline-item right ${index == 0 ? 'latest' : ''}">
                                                        <div class="timeline-content">
                                                            <h6><i class="fas fa-box-open me-2"></i>${item.status}</h6>
                                                            <p class="mb-1 mt-0" style="font-size: 14px; line-height: 1.5;">
                                                                ${item.note}
                                                            </p>
                                                            <small class="text-muted">
                                                                ${new Date(item.created_at).toLocaleString('id-ID', {
                                                                    day: '2-digit',
                                                                    month: '2-digit',
                                                                    year: 'numeric',
                                                                    hour: '2-digit',
                                                                    minute: '2-digit',
                                                                    hour12: false
                                                                })}
                                                            </small>
                                                        </div>
                                                    </div>`;
                                }).join('')}
                            </div>
                        `;
                    }

                    $('#containerDelivery').html(ui);
                }
            });

            $('#modalDelivery').modal('show');
        }

        function transactionComplete(id) {
            Swal.fire({
                title: 'Apakah Pesanan Sudah Diterima ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Belum',
                confirmButtonText: 'Ya, Sudah!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        headers: {
                            'X-API-KEY': '{{ env('API_KEY') }}'
                        },
                        url: `{{ url('api/transaction/received') }}?order_id=` + id,
                        method: 'POST',
                        success: function(response) {
                            if (response.success) {
                                sessionStorage.setItem('success', response.message);
                                window.location.reload();
                            }
                        },
                        error: function(error) {
                            Swal.fire(
                                'Error!',
                                'An error occurred while processing your request.',
                                'error'
                            );
                            console.error("Error completing transaction:", error);
                        }
                    });
                }
            });
        }

        if (sessionStorage.getItem('success')) {
            Swal.fire(
                'Success!',
                sessionStorage.getItem('success'),
                'success'
            );
            sessionStorage.removeItem('success');
        }

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

            renderOrderHistory(filteredData);
        });
    </script>
@endsection
