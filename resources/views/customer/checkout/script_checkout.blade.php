<script type="text/javascript">
    $(document).ready(function() {
		let showShipping = true;
        let selectedItems = [];
        let dataItemsCart = [];
        let dataAddressCustomer = [];
        let addressCustomer = {};
        let voucherSelected = {};
        let dataVoucher = [];
        let voucherDetail = {};
		
		$.ajax({
			headers: {
				'X-API-KEY': '{{ env('API_KEY') }}'
			},
			url: '{{ route('api.rajaongkir.provinces') }}',
			type: "GET", // or "POST"
			dataType: "json", // Expect a JSON response
			success: function(data) {
				// console.log(data['data']);
				var datas = data['data'];
				// Clear existing options (except the default "Select an option")
				$('#provinceAddressee').empty();		
				$('#provinceCustomerEdit').empty(); 
				$('#provinceAddressee').append('<option value="">-- Provinsi --</option>');
				$('#provinceCustomerEdit').append('<option value="">-- Provinsi --</option>');
				console.log(data['data']);
				$.each(datas, function(key, value) {
					
					var newOption = new Option(value.name, value.id);
					$('#provinceAddressee').append('<option value="' + value.id + '">' + value.name + '</option>');
					$('#provinceCustomerEdit').append('<option value="' + value.id + '">' + value.name + '</option>');
				});
				
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
			}
		});

        // handle get product cart
        function getProductCart(type) {
            if (type != "update") {
                $("#containerCart").html(
                    `<div class="w-100 d-flex align-items-center justify-content-center">
                    <p>Proses ambil data...</p>
                </div>`);
            }
            $.ajax({
                headers: {
                    'X-API-KEY': '{{ env('API_KEY') }}'
                },
                url: '{{ route('api.customer.cart.index') }}?customer_id={{ session('customer_id') }}',
                method: 'GET',
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log("Response API Get Cart Customer: ", response);
                    let dataResponse = response.data;
                    if (response.success == true && response.text == "Success get cart") {
                        if (dataResponse.length > 0) {
                            dataItemsCart = dataResponse;
                            let containerCart = $("#containerCart");
                            let groupedData = dataResponse.reduce((acc, item) => {
                                let sellerId = item.product.seller_id;
                                if (!acc[sellerId]) {
                                    acc[sellerId] = [];
                                }
                                acc[sellerId].push(item);
                                return acc;
                            }, {});
                            let html = Object.keys(groupedData).map(sellerId => {
                                let items = groupedData[sellerId];
                                let sellerName = items[0].seller?.name ||
                                    `Toko Seller Id ${sellerId}`;
                                return `
                                    <div class="d-flex flex-row align-items-center gap-2 mb-3">
                                        <input class="form-check-input seller-checkbox m-0"
                                            type="checkbox" value="" id="namaToko${sellerId}" data-seller-id="${sellerId}">
                                        <label class="fw-semibold" for="namaToko${sellerId}"
                                            style="font-size: 14px; line-height: 1.5;">
                                            ${sellerName}
                                        </label> 
                                    </div>
                                    ${items.map((detail, index) => `
                                        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-lg-5 px-lg-4 mb-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <input class="form-check-input item-checkbox m-0" type="checkbox" value="" data-product-id="${detail.product_id}" id="flexCheckCart${index}" data-seller-id="${sellerId}" data-cart-id="${detail.id}">
                                            <div class="d-flex align-items-center gap-4">
                                            <img class="rounded" src="/uploads/product/${detail.product?.image_1}" alt="/uploads/product/${detail.product?.image_1}"
                                                style="width: 5rem; height: 5rem; object-fit: cover; object-position: center; flex-shrink: 0;">
                                            <div class="">
                                                <span class="d-block mb-2 mb-lg-1 fw-semibold fs-6 fs-lg-6">
                                                    ${detail.product?.name} ${detail.product?.weight}
                                                </span>
                                                <span class="d-none d-lg-block fw-bold fs-6">
                                                    ${new Intl.NumberFormat('id-ID', {
                                                    style: 'currency', currency: 'IDR', minimumFractionDigits: 0,
                                                    maximumFractionDigits: 0 }).format(detail.price_type=='single' ? detail.product?.price : detail.price)}
                                                </span>
												<span class="d-none d-lg-block fw-bold fs-6">
                                                    ${detail.price_type=='multi' ? detail.duration_info : ''}
                                                </span>
                                                <div class="d-flex d-lg-none flex-column gap-3">
                                                    <span class="d-block fw-bold fs-6 text-primary">
                                                        ${new Intl.NumberFormat('id-ID', {
                                                    style: 'currency', currency: 'IDR', minimumFractionDigits: 0,
                                                    maximumFractionDigits: 0 }).format(detail.product?.price)}
                                                    </span>
                                                    <div class="d-flex justify-content-between align-items-center border border-dark-subtle border-2 rounded"
                                                        style="width:fit-content;">
                                                        <button type="button" class="button-icon-outline-left" data-product-id="${detail.product?.id}" data-qty="${detail.qty}" data-cart-id="${detail.id}">
                                                            <i class="bi bi-dash" style="font-size: 24px;"></i>
                                                        </button>
                                                        <input class="input-checkout update-qty" data-seller-id="${sellerId}" type="number" value=${detail.qty} data-product-id="${detail.product?.id}" data-qty="${detail.qty}" data-cart-id="${detail.id}">
                                                        <button type="button" class="button-icon-outline-right" data-seller-id="${sellerId}" data-product-id="${detail.product?.id}" data-qty="${detail.qty}" data-cart-id="${detail.id}">
                                                            <i class="bi bi-plus" style="font-size: 24px;"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-none d-lg-flex flex-column align-items-end">
                                        <span
                                            class="d-block mb-2 fw-bold fs-6 text-primary"> ${new Intl.NumberFormat('id-ID', {
                                            style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits:
                                            0 }).format((detail.price_type=='single' ? detail.product?.price : detail.price) * detail.qty)}
                                        </span>
                                        <div class="d-flex justify-content-between align-items-center border border-dark-subtle border-2 rounded"
                                            style="width:fit-content;">
                                            <button type="button" class="button-icon-outline-left" data-product-id="${detail.product?.id}" data-qty="${detail.qty}" data-cart-id="${detail.id}">
                                                <i class="bi bi-dash" style="font-size: 24px;"></i>
                                            </button>
                                            <input class="input-checkout update-qty" data-seller-id="${sellerId}" type="number" value=${detail.qty} data-product-id="${detail.product?.id}" data-qty="${detail.qty}" data-cart-id="${detail.id}">
                                            <button type="button" class="button-icon-outline-right" data-seller-id="${sellerId}" data-product-id="${detail.product?.id}" data-qty="${detail.qty}" data-cart-id="${detail.id}">
                                                <i class="bi bi-plus" style="font-size: 24px;"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                `).join('')}
                            </div>`;
                                return html;
                            }).join('');
                            containerCart.html(html);
                        } else {
                            dataItemsCart = [];
                            $("#containerCart").html(
                                `<div class="w-100 d-flex align-items-center justify-content-center">
                                <p>Keranjang masih kosong, yuk belanja!</p>
                            </div>`);
                        }
                    } else {
                        dataItemsCart = [];
                        $("#containerCart").html(
                            `<div class="w-100 d-flex align-items-center justify-content-center">
                            <p>${response.text}</p>
                        </div>`);
                    }
                },
                error: function(error) {
                    dataItemsCart = [];
                    $("#containerCart").html(
                        `<div class="w-100 d-flex align-items-center justify-content-center">
                            <p>${error.responseJSON.text}</p>
                    </div>`);
                    console.error("Terjadi kesalahan dalam mengambil data cart:", xhr);
                }
            });
        }

        getProductCart("default");

        // handle get address customer
        function getAddressCustomer(type) {
            $.ajax({
                headers: {
                    'X-API-KEY': '{{ env('API_KEY') }}'
                },
                url: '{{ route('api.customer.address.active') }}?customer_id={{ session('customer_id') }}',
                method: 'GET',
                processData: false,
                contentType: false,
                success: function(response) {
                    let dataAddress = response.data;
                    dataAddressCustomer = dataAddress;
                    addressCustomer = type == "default" ? dataAddress[0] : addressCustomer;

                    if (dataAddress !== null) {
                        if (dataAddress.length > 0) {
                            $(".containerCustomerAddressList").html(
                                `<div id="selectedAddressPrimary" class="w-100 d-flex align-items-start justify-content-between gap-4 gap-lg-5 py-3 px-4 rounded-2 border border-1 bg-primary-subtle border-primary">
                                    <div class="d-flex flex-column">
                                        <strong class="fw-bold" style="font-size: 16px; line-height: 1.5rem">${addressCustomer.name}</strong>
                                        <span class="fw-medium" style="font-size: 14px; line-height: 1.5rem">${addressCustomer.phone}</span>
                                        <div class="fw-medium text-wrap w-md-75 w-lg-75" style="font-size: 14px; line-height: 1.5rem;">Jl.
                                            ${addressCustomer.address}, ${addressCustomer.road}, ${addressCustomer.city}, ${addressCustomer.province}, ${addressCustomer.zip_code}
                                        </div>
                                    </div>
                                </div>
								{{---
                                <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                                    data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                                    aria-controls="collapseExample" style="font-size: 14px; line-height: 1.5;">
                                    Lihat alamat lainnya
                                </a>
								---}}
						<a href="{{ url('address-setting') }}" 
                                    style="font-size: 14px; line-height: 1.5;">
                                    Lihat alamat lainnya
                                </a>
                                <div class="collapse mt-2" id="collapseExample">
                                    ${dataAddress.filter(address => address.id != addressCustomer.id).map((address, index) => {
                                    return `
                                        <div class="address-item w-100 d-flex align-items-start justify-content-between gap-4 gap-lg-5 py-3 px-4 rounded-2 border border-1 mb-3" data-address-id=${address.id} style="cursor: pointer;">
                                                <div class="d-flex flex-column">
                                                    <strong class="fw-bold" style="font-size: 16px; line-height: 1.5rem">${address.name}</strong>
                                                    <span class="fw-medium" style="font-size: 14px; line-height: 1.5rem">${address.phone}</span>
                                                    <div class="fw-medium text-wrap w-md-75 w-lg-75" style="font-size: 14px; line-height: 1.5rem;">Jl.
                                                        ${address.address}, ${address.road}, ${address.city}, ${address.province}, ${address.zip_code}
                                                    </div>
                                                </div>
                                            </div>
                                        `;
                                    }).join("")}
                                </div>
                                `
                            );
                        } else {
                            $(".containerCustomerAddressList").html(
                                `<div class="w-100 d-flex flex-column align-items-center justify-content-center">
                                    <p class="text-center">Alamat masih kosong, silahkan tambahkan alamat</p>
                                    <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                                        href="{{ url('/address-setting') }}" style="font-size: 14px; line-height: 1.5;">
                                        Tambahkan Alamat
                                    </a>
                                </div>`);
                        }
                    } else {
                        $(".containerCustomerAddressList").html(
                            `<div class="w-100 d-flex align-items-center justify-content-center">
                                    <p>Terjadi kesalahan: ${response.message}</p>
                                </div>`);
                    }
                },
                error: function(error) {
                    console.error("Terjadi kesalahan dalam mengambil data address:", xhr);
                }
            });
        }

        getAddressCustomer("default");

        // handle select address
        $(document).on("click", ".address-item", function() {
            // selected address
            let addressId = $(this).data("address-id");
            addressCustomer = dataAddressCustomer.find(address => address.id == addressId);
            $("#selectedAddressPrimary").html(
                `<div class="d-flex flex-column">
                    <strong class="fw-bold" style="font-size: 16px; line-height: 1.5rem">${addressCustomer.name}</strong>
                    <span class="fw-medium" style="font-size: 14px; line-height: 1.5rem">${addressCustomer.phone}</span>
                    <div class="fw-medium text-wrap w-md-75 w-lg-75" style="font-size: 14px; line-height: 1.5rem;">Jl.
                        ${addressCustomer.address}, ${addressCustomer.road}, ${addressCustomer.city}, ${addressCustomer.province}, ${addressCustomer.zip_code}
                    </div>
                </div>`
            );
            getAddressCustomer("update");
        });

        // handle select item cart
        $(document).on("click", "#select-all-product-cart", function() {
            if ($(this).is(":checked")) {
				checkStatus = true;
                $("input.form-check-input").prop("checked", true);
                selectedItems = dataItemsCart.filter(Boolean);
            } else {
				checkStatus = false;
                $("input.form-check-input").prop("checked", false);
                selectedItems = [];
            }
            a = updateRingkasanBelanja(checkStatus, selectedItems);
            console.log(selectedItems.filter(Boolean));
        });

        $(document).on("change", ".form-check-input.item-checkbox", function() {
            let sellerId = $(this).data('seller-id');
            let productId = $(this).data('product-id');
            let checked = $(this).is(":checked");
            let cartId = $(this).data('cart-id');

            if (checked) {
				checkStatus = true;
                let selectedItem = dataItemsCart.find(item => item.id == cartId);
                if (selectedItem) {
                    selectedItems.push(selectedItem);
                }

                if (selectedItems.length == dataItemsCart.length) {
                    $("#select-all-product-cart").prop("checked", true);
                }

                // Cek apakah semua item-checkbox dengan data-seller-id yang sama sudah tercentang
                let totalSellerItems = $(`.form-check-input.item-checkbox[data-seller-id="${sellerId}"]`).length;
                let checkedSellerItems = $(`.form-check-input.item-checkbox[data-seller-id="${sellerId}"]:checked`).length;
                if (totalSellerItems == checkedSellerItems) {
                    $(`.seller-checkbox[data-seller-id="${sellerId}"]`).prop("checked", true);
                }
            } else {
				// // // // // alert('cartId = ' + cartId);
				checkStatus = false;
                // // // // // selectedItems = selectedItems.filter(item => item.product_id !== productId);
				selectedItems = selectedItems.filter(item => item.id !== cartId);
                $("#select-all-product-cart").prop("checked", false);
                $(`.seller-checkbox[data-seller-id="${sellerId}"]`).prop("checked", false);
            }
            b = updateRingkasanBelanja(checkStatus, selectedItems);
            // console.log(selectedItems.filter(Boolean));
			if(!showShipping) {
				$("#show_shipping").append('<button id="show-shipping" class="btn btn-sm btn-success py-1 px-3" style="font-size: 14px; height: 32px;">Lihat Ongkir</button>');
				showShipping = true;
			}
        });

        $(document).on("change", ".seller-checkbox", function() {
            let sellerId = $(this).data('seller-id');
            const isChecked = $(this).is(":checked");
            $(`.form-check-input[data-seller-id="${sellerId}"]`).prop("checked", isChecked);
            if (isChecked) {
				checkStatus = true;
                let selectedSellerItems = dataItemsCart.filter(item => item.product.seller_id ==
                    sellerId);
				console.log(selectedSellerItems);
				console.log(selectedItems);
				selectedItems = selectedSellerItems;
                // // // // // selectedSellerItems.forEach(newItem => {
                    // // // // // if (!selectedItems.some(item => item.product_id == newItem.product_id)) {
                        // // // // // selectedItems.push(newItem);
                    // // // // // }
                // // // // // });
				console.log('======================');
				console.log(selectedSellerItems);
				console.log(selectedItems);
            } else {
				checkStatus = false;
                selectedItems = selectedItems.filter(item => item.product.seller_id !== sellerId);
                $("#select-all-product-cart").prop("checked", false);
            }
            c = updateRingkasanBelanja(checkStatus, selectedItems);
        });

        function updateRingkasanBelanja(checkStatus=false, selectedItems=[]) {
			$("#containerIncludeShipping").empty();
			$("#cost-shipping").empty();
            const formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
            const items = selectedItems.filter(Boolean);
            const totalBelanja = items.reduce((total, item) => total + (item.price_type=='multi' ? item.price : item.product.price) * item.qty, 0);

			const cartCheckedItem = items.map(item => ({
										id	: item.product.id,
										name: item.product.name,
										qty	: item.qty
									}));
									
			// // // // // console.log(selectedItems);
			
			if(checkStatus != null && selectedItems != null) {
				$.ajax({
					url: '{{ url('update-cart') }}?checkStatus='+checkStatus,
					type: 'GET',
					data: { items: JSON.stringify(selectedItems) },
					dataType: "json",
					success: function(response) {
						console.log(response);
					}
				});
			}

            const ringkasanHTML = items.map(item => `
                <div class="w-100 row mb-1">
                    <div class="col-5"><span class="fs-6 fw-medium">${item.product.name}<br />${item.price_type=='multi' ? item.duration_info : ''}</span></div>
                    <div class="col-2 text-end"><span class="fs-6 fw-medium ">${item.qty}x</span></div>
                    <div class="col-5 text-end"><span class="fs-6 fw-medium">${formatter.format((item.price_type=='multi' ? item.price : item.product.price) * item.qty)}</span></div>
                </div>
            `).join('') + `
                <div class="w-100 row">
                    <div class="col"><span class="fs-6 fw-medium" style="color: #858585;">Discount</span></div>
                    <div class="col text-end"><span class="fs-6 fw-medium discount-text" style="color: #858585;">Tidak ada voucher</span></div>
                </div>
                <div class="w-100 row mt-3">
                    <div class="col"><span class="fs-6 fw-bold">Sub Total</span></div>
                    <div class="col text-end"><span class="fs-6 fw-bold" style="color: #EE0000;">${formatter.format(totalBelanja)}</span></div>
                </div>
            `;

            if (items.length > 0) {
				// // // for(var y=0; y<items.length; $y++) {
					// // // alert(items[y].id);
					
				// // // }
				
                $("#containerRingkasanBelanja").html(ringkasanHTML);
				
                $("#containerRingkasanBelanjaMobile").html(ringkasanHTML);
                $(".currentTotal").text("" + formatter.format(totalBelanja));

                if (totalBelanja != 0) {
                    getDataVoucher(totalBelanja);
                } else {
                    voucherSelected = {};
                    $(".continerListVoucher").html(`
                        <div class="w-100 p-2 p-md-2 d-flex align-items-center justify-content-center">
                            <p>Pilih item produk terlebih dahulu</p>
                        </div>`);
                }
            } else {
                const emptyHTML = `
                    <div class="w-100 d-flex align-items-center justify-content-center">
                        <p>Belum ada produk yang dipilih</p>
                    </div>`;
                $("#containerRingkasanBelanja").html(emptyHTML);
                $("#containerRingkasanBelanjaMobile").html(emptyHTML);
                $(".continerListVoucher").html(`
                    <div class="w-100 p-2 p-md-2 d-flex align-items-center justify-content-center">
                        <p>Pilih item produk terlebih dahulu</p>
                    </div>`);
                $(".currentTotal").text("Rp 0");
                voucherSelected = {};
            }
			
			return cartCheckedItem;
        }

        updateRingkasanBelanja();

        // handle delete product cart
        function deleteProductCart(id) {
            return new Promise((resolve, reject) => {
                sweetAlertLoading()
                let formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    headers: {
                        'X-API-KEY': '{{ env('API_KEY') }}'
                    },
                    url: `{{ url('api/customer/delete/cart/') }}/${id}`,
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

        $(document).on("click", "#btnDelete", function() {
            if (selectedItems.length > 0) {
                Swal.fire({
                    title: "Hapus Barang?",
                    text: "Produk yang pilih akan dihapus dari keranjang",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#229FE1",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, hapus",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteProductCart(selectedItems.map((item) => item.id))
                            .then((response) => {
                                console.log("Response API Delete Product Cart: ",
                                    response);
                                if (response.success == true && response.text ==
                                    'Success delete cart') {
                                    Swal.close();
                                    sweetAlertSuccess("Berhasil menghapus barang");
                                    getProductCart("delete");
                                    selectedItems = [];
                                    updateRingkasanBelanja();
                                } else {
                                    Swal.close();
                                    sweetAlertDanger(response.text);
                                }
                            })
                            .catch((error) => {
                                Swal.close();
                                console.error('Terjadi Masalah Delete Product Cart:',
                                    error);
                                sweetAlertDanger(error.responseJSON.text);
                            });
                    }
                });
            } else {
                sweetAlertWarning("Pilih 1 item yang ingin dihapus");
            }
        });

        // handle update product cart
        function updateProductCart(customerId, productId, qty, cartId, statCheck='false') {
            return new Promise((resolve, reject) => {
                // sweetAlertLoading()
                let formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('customer_id', customerId);
                formData.append('product_id', productId);
                formData.append('qty', qty);
				formData.append('stat_check', statCheck);
                $.ajax({
                    headers: {
                        'X-API-KEY': '{{ env('API_KEY') }}'
                    },
                    url: `{{ url('api/customer/update/cart/') }}/${cartId}`,
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

        $(document).on("click", ".button-icon-outline-left", function() {
			let sellerId = $(this).data('seller-id')
            let customerId = {{ session('customer_id') }};
            let productId = $(this).data('product-id');
            let cartId = $(this).data('cart-id');
            let quantityInput = $(this).siblings('.input-checkout');
            let qtyProduct = parseInt(quantityInput.val());
            let isCheckedBefore = $(`.form-check-input[data-cart-id="${cartId}"]`).is(":checked");
            console.log("Qty Product Kurang: ", qtyProduct);

            if (qtyProduct > 1) {
                updateProductCart(customerId, productId, Number(qtyProduct) - 1, cartId)
                    .then((response) => {
                        console.log("Response API Update Qty Product Cart: ",
                            response);
                        if (response.success == true && response.text ==
                            'Success update cart') {
                            Swal.close();
                            sweetAlertSuccess("Jumlah produk berhasil dikurangi");
                            $(this).data('qty', Number(qtyProduct) - 1);
                            $(`.update-qty[data-cart-id="${cartId}"]`).val(Number(qtyProduct) - 1);
                            $(`.update-qty[data-cart-id="${cartId}"]`).attr("data-qty", Number(
                                qtyProduct) - 1);
                            $(`.form-check-input[data-cart-id="${cartId}"]`).prop("checked",
                                isCheckedBefore);
                            selectedItems = selectedItems.map(item =>
                                item.id == cartId ? {
                                    ...item,
                                    qty: Number(qtyProduct) - 1
                                } : item
                            );
                            dataItemsCart = dataItemsCart.map(item =>
                                item.id == cartId ? {
                                    ...item,
                                    qty: Number(qtyProduct) - 1
                                } : item
                            );
                            // // // // // selectedItems = selectedItems.filter(item => item.product_id !== productId);
							selectedItems = selectedItems.filter(item => item.id !== cartId);
							$(`.form-check-input[data-cart-id="${cartId}"]`).prop("checked", false);
							$("#select-all-product-cart").prop("checked", false);
							$(`.seller-checkbox[data-seller-id="${sellerId}"]`).prop("checked", false);
							updateRingkasanBelanja(false, selectedItems);
                        } else {
                            Swal.close();
                            sweetAlertDanger(response.text);
                        }
                    })
                    .catch((error) => {
                        Swal.close();
                        console.error('Terjadi Masalah Update Product Qty Cart:',
                            error);
                        sweetAlertDanger(error.responseJSON.text);
                    });
            } else {
                deleteProductCart(cartId)
                    .then((response) => {
                        console.log("Response API Delete Product Cart: ",
                            response);
                        if (response.success == true && response.text ==
                            'Success delete cart') {
                            Swal.close();
                            updateRingkasanBelanja();
                            sweetAlertSuccess("Berhasil menghapus barang");
                            getProductCart("delete");
                            selectedItems = [];
                        } else {
                            Swal.close();
                            sweetAlertDanger(response.text);
                        }
                    })
                    .catch((error) => {
                        Swal.close();
                        console.error('Terjadi Masalah Delete Product Cart:',
                            error);
                        sweetAlertDanger(error.responseJSON.text);
                    });
            }
        });

        $(document).on("click", ".button-icon-outline-right", function() {
			let sellerId = $(this).data('seller-id')
            let customerId = {{ session('customer_id') }};
            let productId = $(this).data('product-id');
            let cartId = $(this).data('cart-id');
            let quantityInput = $(this).siblings('.input-checkout');
            let qtyProduct = parseInt(quantityInput.val());
            let isCheckedBefore = $(`.form-check-input[data-cart-id="${cartId}"]`).is(":checked");
            console.log("Qty Product Tambah: ", qtyProduct);
            updateProductCart(customerId, productId, Number(qtyProduct) + 1, cartId, isCheckedBefore ? 'true' : 'false')
                .then((response) => {
                    console.log("Response API Update Qty Product Cart: ",
                        response);
                    if (response.success == true && response.text ==
                        'Success update cart') {
                        Swal.close();
                        $(this).data('qty', Number(qtyProduct) + 1);
                        $(`.update-qty[data-cart-id="${cartId}"]`).val(Number(qtyProduct) + 1);
                        $(`.update-qty[data-cart-id="${cartId}"]`).attr("data-qty", Number(
                            qtyProduct) + 1);
                        $(`.form-check-input[data-cart-id="${cartId}"]`).prop("checked",
                            isCheckedBefore);

                        sweetAlertSuccess("Jumlah produk berhasil ditambah");
                        selectedItems = selectedItems.map(item =>
                            item.id == cartId ? {
                                ...item,
                                qty: Number(qtyProduct) + 1
                            } : item
                        );
                        dataItemsCart = dataItemsCart.map(item =>
                            item.id == cartId ? {
                                ...item,
                                qty: Number(qtyProduct) + 1
                            } : item
                        );
						selectedItems = selectedItems.filter(item => item.product_id !== productId);
						$(`.form-check-input[data-cart-id="${cartId}"]`).prop("checked", false);
						$("#select-all-product-cart").prop("checked", false);
						$(`.seller-checkbox[data-seller-id="${sellerId}"]`).prop("checked", false);
                        updateRingkasanBelanja(false, selectedItems);
                    } else {
                        Swal.close();
                        sweetAlertDanger(response.text);
                    }
                })
                .catch((error) => {
                    Swal.close();
                    console.error('Terjadi Masalah Update Product Qty Cart:',
                        error);
                    sweetAlertDanger(error.responseJSON.text);
                });
        });

        // menggunakan debounce -> agar tidak sering melakukan req ke server
        let debounceTimer;
        $(document).on("input", ".update-qty", function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                let customerId = {{ session('customer_id') }};
                let productId = $(this).data('product-id');
                let qtyProduct = $(this).data('qty');
                let cartId = $(this).data('cart-id');
                let newQty = $(this).val();
                let isCheckedBefore = $(`.form-check-input[data-cart-id="${cartId}"]`).is(
                    ":checked");
                let sellerId = $(this).data('seller-id');

                if (newQty == "0" || newQty == "") {
                    console.log("Seller Id", sellerId);
                    sweetAlertWarning("Jumlah produk tidak boleh kurang dari 1");
                    $(`.form-check-input[data-cart-id="${cartId}"]`).prop(
                        "checked",
                        false);
                    $(`.seller-checkbox[data-seller-id="${sellerId}"]`).prop(
                        "checked",
                        false);
                    selectedItems = [];
                    deleteProductCart(cartId)
                        .then((response) => {
                            console.log("Response API Delete Product Cart: ",
                                response);
                            if (response.success == true && response.text ==
                                'Success delete cart') {
                                Swal.close();
                                updateRingkasanBelanja();
                                sweetAlertSuccess("Berhasil menghapus barang");
                                getProductCart("delete");
                                selectedItems = [];
                            } else {
                                Swal.close();
                                sweetAlertDanger(response.text);
                            }
                        })
                        .catch((error) => {
                            Swal.close();
                            console.error('Terjadi Masalah Delete Product Cart:',
                                error);
                            sweetAlertDanger(error.responseJSON.text);
                        });
                    updateRingkasanBelanja();
                    return;
                }



                if (newQty > 0) {
                    updateProductCart(customerId, productId, Number(newQty), cartId)
                        .then((response) => {
                            if (response.success == true && response.text ==
                                'Success update cart') {
                                Swal.close();
                                sweetAlertSuccess("Jumlah produk berhasil ditambahkan");
                                $(`.form-check-input[data-cart-id="${cartId}"]`).prop(
                                    "checked",
                                    isCheckedBefore);
                                selectedItems = selectedItems.map(item =>
                                    item.id == cartId ? {
                                        ...item,
                                        qty: Number(newQty)
                                    } : item
                                );
                                dataItemsCart = dataItemsCart.map(item =>
                                    item.id == cartId ? {
                                        ...item,
                                        qty: Number(newQty)
                                    } : item
                                );
                                updateRingkasanBelanja();
                            } else {
                                Swal.close();
                                sweetAlertDanger(response.text);
                            }
                        })
                        .catch((error) => {
                            Swal.close();
                            console.error('Terjadi Masalah Update Product Qty Cart:',
                                error);
                            sweetAlertDanger(error.responseJSON.text);
                        });
                } else {
                    sweetAlertWarning("Jumlah produk tidak boleh kurang dari 1");
                }
            }, 300);
        });
		
		
		$(document).on("click", "#show-shipping", function() {
            if (dataAddressCustomer.length == 0) {
                sweetAlertWarning("Silahkan tambahkan alamat terlebih dahulu");
                return;
            }

            if (selectedItems.filter(Boolean).length == 0) {
                sweetAlertWarning("Silahkan pilih produk terlebih dahulu");
                return;
            }

            let sellerIds = selectedItems.map(item => item.product.seller_id);
            let uniqueSellerIds = [...new Set(sellerIds)];

            if (uniqueSellerIds.length > 1) {
                sweetAlertWarning("Checkout hanya diperbolehkan untuk produk dari satu penjual.");
                return;
            }
			
			$.ajax({
				url: "{{ url('check-shipping') }}",
				type: 'GET',
				dataType: 'json', // Expecting a JSON response
				success: function(data) {
					var status = data['success'];
					var datas = data['data'];
					if(status==true) {
						$('#cost-shipping').empty();
						// Loop through the data and add options
						$.each(datas, function(key, value) {
							$('#cost-shipping').append(`<tr class="animate__animated animate__fadeIn">
							<td class="text-center"><input type="radio" name="shipping_cost" value="`+ value.service +`" /></td>
							<td>`+ value.name +`<br />`+ value.description +`<br />`+ value.etd +`</td>
							<td class="text-left">`+ new Intl.NumberFormat("id-ID", {style: "currency", currency: "IDR", minimumFractionDigits: 0}).format(value.cost) +`</td>
							</tr>`);
						});
					}
					$("#show-shipping").remove();
				},
				error: function(xhr, status, error) {
					console.error("An error occurred: " + status + " " + error);
					$('#detail-ongkir').empty().append('<div>Error loading items</div>');
				}
			});
			showShipping = false;
		});
		
		
		
		
		$(document).on("change", 'input[name="shipping_cost"], select', function() {
			var shipping_value;
			shipping_value = $('input[name="' + $(this).attr('name') + '"]:checked').val();
			$.ajax({
				url: '{{ url('select-shipping') }}?shipping='+shipping_value,
				type: 'GET',
				dataType: "json",
				success: function(data) {
					var status = data['success'];
					var datas = data['data'];
					if(status==true) {
						includeOngkirHTML = `<div class="w-100 row">
							<div class="col"><span class="fs-6 fw-medium" style="color: #858585;">Ongkos Kirim</span></div>
							<div class="col text-end"><span class="fs-6 fw-medium discount-text" style="color: #858585;">`+new Intl.NumberFormat("id-ID", {style: "currency", currency: "IDR", minimumFractionDigits: 0}).format(datas['cost'])+`</span></div>
						</div>
						<div class="w-100 row mt-3">
							<div class="col"><span class="fs-6 fw-bold">Total</span></div>
							<div class="col text-end"><span class="fs-6 fw-bold" style="color: #EE0000;">`+new Intl.NumberFormat("id-ID", {style: "currency", currency: "IDR", minimumFractionDigits: 0}).format(data['total_include_shipping'])+`</span></div>
						</div>
						`;
						$("#containerIncludeShipping").html(includeOngkirHTML);
						// // // // // console.log(response);
					}
				},
				error: function(xhr, status, error) {
					alert('shipping_value ERROR');
				}
			});
			
		});
		

        // handle checkout
        $(document).on("click", ".btn-checkout", function() {
            if (dataAddressCustomer.length == 0) {
                sweetAlertWarning("Silahkan tambahkan alamat terlebih dahulu");
                return;
            }
			

            if (selectedItems.filter(Boolean).length == 0) {
                sweetAlertWarning("Silahkan pilih produk terlebih dahulu");
                return;
            }
			
			// // // // // const selectedShipping = $("input[name='shipping_cost']:checked").val();
			// // // // // if (!selectedShipping) {
                // // // // // sweetAlertWarning("Silahkan pilih Ongkos Kirim terlebih dahulu");
                // // // // // return;
            // // // // // }

            let sellerIds = selectedItems.map(item => item.product.seller_id);
            let uniqueSellerIds = [...new Set(sellerIds)];

            if (uniqueSellerIds.length > 1) {
                sweetAlertWarning("Checkout hanya diperbolehkan untuk produk dari satu penjual.");
                return;
            }

            let customerId = {{ session('customer_id') }};
            let customerAddressId = addressCustomer.id;
            let otherCost = Number(selectedItems.filter(Boolean).reduce((total, item) => total + item
                .product.price * item.qty, 0));

            console.log("Customer ID:", customerId);
            console.log("Customer Address ID:", customerAddressId);
            console.log("Other Cost:", otherCost);
            console.log("Selected Items:", selectedItems.filter(Boolean));
            console.log("Voucher ID:", voucherSelected?.id);

            sweetAlertLoading();
            let selectedProduct = [];
            selectedItems.filter(Boolean).forEach((item, index) => {
                selectedProduct.push(item);
            });

            let param = {
                'carts': selectedProduct,
                'customer_id': customerId,
                'seller_id': selectedProduct[0].seller.id,
                'customer_address_id': customerAddressId,
                'other_cost': otherCost,
                'voucher_id': voucherSelected?.id ?? null,
				'shipping_cost': $('input[name="shipping_cost"]:checked').val(),
                '_token': '{{ csrf_token() }}'
            };
            $.ajax({
                headers: {
                    'X-API-KEY': '{{ env('API_KEY') }}'
                },
                url: '{{ url('transaction-create') }}',
                method: 'POST',
                data: param,
                success: function(response) {
                    console.log("Response API Create Transaction: ",
                        response);
                    if (response.success) {
                        Swal.close();
                        sweetAlertSuccess("Berhasil membuat transaksi");
                        {{---window.location.href = "{{ url('/waiting-confirmation') }}";   reza-mod ---}}
                        window.location.href = "{{ url('/waiting-payment') }}";
                    } else {
                        Swal.close();
                        sweetAlertDanger("Gagal membuat transaksi, status: " + response
                            .message);
                    }
                },
                error: function(xhr, status, error) {
                    var errorMessage = JSON.parse(xhr.responseText || '')?.message || error
                        .message || status;
                    console.error("Terjadi kesalahan dalam membuat transaksi:",
                        errorMessage);
                    Swal.close();
                    sweetAlertDanger("Terjadi kesalahan dalam membuat transaksi, " +
                        errorMessage);
                }
            });
        });

        // get data voucher
        function getDataVoucher(totalBelanja) {
            $(".continerListVoucher").html(
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
                            let filteredData = dataResponse.filter(item => item
                                .minimum_transaction <= totalBelanja);

                            $(".continerListVoucher").html(`
                                <div  class="card-voucher-checkout shadow-sm border border-1 containerSelectedVoucher d-none"></div>
                                ${filteredData?.slice(0, 2).map((item, index) => {
                                    return `<div class="col" key="${index}">
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
                                                <button class="btn btn-primary btn-voucher" type="button" data-voucher-id="${item.id}" data-voucher-code="${item.id}">Pakai</button>
                                            </div>
                                        </div>`;
                                }).join("")}
                                ${filteredData?.length > 2 ? `<a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                                    data-bs-toggle="collapse" href="#collapsVoucher" role="button" aria-expanded="false"
                                    aria-controls="collapsVoucher" style="font-size: 14px; line-height: 1.5;">
                                    Lihat voucher lainnya
                                </a>` : ""} 
                                <div class="collapse" id="collapsVoucher">
                                    ${filteredData?.slice(2).map((item, index) => {
                                    return `<div class="col" key="${index}">
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
                                                <button class="btn btn-primary btn-voucher" type="button" data-voucher-id="${item.id}" data-voucher-code="${item.id}">Pakai</button>
                                            </div>
                                        </div>`;
                                    }).join("")}
                                </div>
                            `);
                        } else {
                            dataVoucher = [];
                            $(".continerListVoucher").html(
                                `<div class="w-100 p-2 p-md-2 d-flex align-items-center justify-content-center">
                            <p>${"Saat ini belum ada voucher yang tersedia"}</p>
                        </div>`);
                        }
                    } else {
                        dataVoucher = [];
                        $(".continerListVoucher").html(
                            `<div class="w-100 p-2 p-md-2 d-flex align-items-center justify-content-center">
                            <p>${"Terjadi kesalahan mengambil data voucher"}</p>
                        </div>`);
                    }
                },
                error: function(error) {
                    dataVoucher = [];
                    $(".continerListVoucher").html(
                        `<div class="w-100 p-2 p-md-2 d-flex align-items-center justify-content-center">
                        <p>${error.responseJSON.text}</p>
                    </div>`);
                    console.error("Terjadi kesalahan mengambil data voucher:", error);
                }
            });
        }

        $(document).on("click", ".btn-primary.btn-voucher", function() {
            sweetAlertSuccess("Voucher akan digunakan ketika proses pembayaran");
            let voucherId = $(this).data('voucher-id');
            voucherSelected = dataVoucher.find(item => item.id == voucherId);
            $(".containerSelectedVoucher").removeClass("d-none");
            $(".containerSelectedVoucher").html(
                `<svg class="wave-voucher-checkout" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
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
                    ${voucherSelected?.name}
                </p>
                <p class="sub-text">
                    Min. Belanja Rp ${new Intl.NumberFormat("id-ID").format(voucherSelected?.minimum_transaction || 0)}
                </p>
            </div>
            <button class="btn btn-danger btn-voucher" type="button" data-voucher-id="${voucherSelected?.id}" data-voucher-code="${voucherSelected?.id}">Hapus</button>`
            );
            $(".discount-text").text("Berhasil menggunakan voucher");
            console.log("Voucher Selected: ", voucherSelected);

        });

        $(document).on("click", ".btn-danger.btn-voucher", function() {
            sweetAlertSuccess("Voucher berhasil dihapus");
            let voucherId = $(this).data('voucher-id');
            voucherSelected = {};
            $(".containerSelectedVoucher").addClass("d-none");
            $(".containerSelectedVoucher").html(``);
            $(".discount-text").text("Tidak ada voucher");
        });

        $(document).on("click", "#syaratKetentuan", function() {
            let voucherId = $(this).data("voucher-id");
            $('#exampleModalSnK').modal('show');
            voucherDetail = dataVoucher.find(item => item.id == voucherId);
            console.log("Voucher Selected: ", voucherDetail);
            $("#containerDetailVoucher").html(`<h6 class="fw-semibold m-0 p-0">
                Syarat & Ketentuan ${voucherDetail?.name}
                </h6>
                <div class="w-100 d-flex gap-1">
                    <span class="" class="" style="font-size: 14px; line-height: 1.5;">1. </span>
                    <span class="" style="font-size: 14px; line-height: 1.5;">
                        Voucher hanya digunakan untuk ${voucherDetail?.type == "1" ? "ongkos kirim" : "pembelian produk"}
                    </span>
                </div>
            <div class="w-100 d-flex gap-1">
                <span class="" class="" style="font-size: 14px; line-height: 1.5;">2. </span>
                <span class="" style="font-size: 14px; line-height: 1.5;">
                    Minimal transaksi sebesar Rp ${new Intl.NumberFormat("id-ID").format(voucherDetail?.minimum_transaction)}
                </span>
            </div>
            <div class="w-100 d-flex gap-1">
                <span class="" class="" style="font-size: 14px; line-height: 1.5;">3. </span>
                <span class="" style="font-size: 14px; line-height: 1.5;">
                    Maksimal diskon sebesar Rp. ${new Intl.NumberFormat("id-ID").format(voucherDetail?.max_discount)}
                </span>
            </div>
            <div class="w-100 d-flex gap-1">
                <span class="" class="" style="font-size: 14px; line-height: 1.5;">4. </span>
                <span class="" style="font-size: 14px; line-height: 1.5;">
                    Voucher dapat digunakan mulai ${moment(voucherDetail?.start_date).format("DD MMMM YYYY")} sampai ${moment(voucherDetail?.expired_date).format("DD MMMM YYYY")}
                </span>
            </div>`);
        });

        $(document).on("click", ".close-modal-snk", function() {
            voucherDetail = {};
            $('#exampleModalSnK').modal('hide');
        });
		
    });
</script>
