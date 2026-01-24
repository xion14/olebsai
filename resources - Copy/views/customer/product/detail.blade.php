@extends('__layouts.__frontend.main')

@section('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@endsection

@section('body')
    {{-- Tampilan Desktop Start --}}
    <div class="w-100 mt-3 d-none d-lg-block">
        <div class="row w-100">
            <div class="col">
                <div class="w-100" id="containerImageProductDesktop">

                </div>
                <section class="p-0 m-0" id="continerImagePhotoPerSlide">

                </section>
            </div>
            <div class="col-4 p-4 d-flex flex-column gap-2">
                <span class="badge text-bg-primary text-category btn-category" style="width: fit-content; cursor: pointer;">

                </span>
				<span class="badge btn-category" style="background-color:brown; width: fit-content; cursor: pointer;">
				{{ $type }}
                </span>
                <h6 class="text-name" style="font-size: 1.25rem; line-height: 1.5rem">
                    Nama Product
                </h6>
				
                <h4 class="mt-2 fw-bold text-price">
                    Harga Product
                </h4>
                <button type="button" class="lihat-seller d-flex align-items-center gap-2 mt-1"
                    style="cursor: pointer; background-color: transparent; border: none; outline: none;">
                    <i class="fa-solid fa-circle-check" style="color: #229FE1; font-size: 14px;"></i>
                    <span class="fw-semibold supplier-name" style="font-size: 14px;">
                        Nama Supplier
                    </span>
                </button>
                <div class="w-100 border-1 border-top border-bottom mt-2">
                    <h6 class="fw-bold p-2 border-bottom mb-0 text-primary border-primary" style="width: fit-content">
                        Detail Produk
                    </h6>
                </div>
                <p class="text-detail">

                </p>
            </div>
            <div class="col mt-4">
                <div class="w-100 border border-dark-subtle border-1 rounded px-4 py-3">
                    <h6 class="fw-bold" style="font-size: 1.25rem; line-height: 1.5rem;">
                        Pesanan
                    </h6>
                    <span class="fw-semibold">Jumlah</span>
                    <div class="w-100 d-flex justify-content-between align-items-end mt-4">
                        <div class="d-flex justify-content-between align-items-center border border-dark-subtle border-2 rounded"
                            style="width:fit-content;">
                            <button class="button-icon-outline-left">
                                <i class="bi bi-dash" style="font-size: 24px;"></i>
                            </button>
                            <input class="input-checkout" type="number" value="1">
                            <button class="button-icon-outline-right">
                                <i class="bi bi-plus" style="font-size: 24px;"></i>
                            </button>
                        </div>
                        <strong class="text-stock" style="font-size: 1rem; color: #858585; line-height: 1.5rem">
                            Stok: 700
                        </strong>
                    </div>
                    <div class="w-100 d-flex justify-content-between align-items-end mt-4">
                        <h6 class="fw-bold">
                            Total Harga
                        </h6>
                        <h6 class="fw-bold text-total-price" style="color: #EE0000;">
                            Rp 800.000
                        </h6>
                    </div>

                    @if($type_id==3)
                    <section class="flex items-center" style="margin-bottom: 24px; align-items: baseline;">
                        @if($product_subs)<h2 class="Dagtcd">Durasi</h2>@endif
                        <div>
                            <div class="flex items-center j7HL5Q">
                                @if($product_subs)
                                    @php $i=0 @endphp
                                    @foreach($product_subs as $product_sub)
                                        <input type="radio" name="duration" data-price="{{"Rp ".number_format($product_sub['subprice'], 0, ",", ".") }}" value="{{ $i }}" {{ $i==0 ? 'checked' : '' }} /> {{ $product_sub['subtime'] }}
                                        @php $i++ @endphp
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </section>
                    @endif

                    <button type="button"
                        class="d-flex justify-content-center align-items-center btn btn-outline-primary w-100 mt-4 py-0 btn-add-to-cart">
                        <i class="bi bi-plus" style="font-size: 24px;"></i>
                        Keranjang
                    </button>
                    <button type="button" class="btn btn-primary w-100 mt-2 btn-buy-now">Beli Sekarang</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Tampilan Desktop End --}}

    {{-- Tampilan Mobile Start --}}
    <div class="w-100 mt-3 d-flex flex-column d-lg-none gap-3">
        <div class="w-100" id="containerImageProductMobile">

        </div>
        <div class="w-100 p-2 d-flex flex-column gap-2">
            <span class="badge text-bg-primary text-category btn-category" style="width: fit-content; cursor: pointer;">

            </span>
            <h6 class="text-name" style="font-size: 1.25rem; line-height: 1.5rem">

            </h6>
            <h4 class="mt-2 fw-bold text-price">

            </h4>
            <button type="button" class="lihat-seller d-flex align-items-center gap-2 mt-1"
                style="cursor: pointer; background-color: transparent; border: none; outline: none;">
                <i class="fa-solid fa-circle-check" style="color: #229FE1; font-size: 14px;"></i>
                <span class="fw-semibold supplier-name" style="font-size: 14px;">

                </span>
            </button>
            <div class="w-100 border-1 border-top border-bottom mt-2">
                <h6 class="fw-bold p-2 border-bottom mb-0 text-primary border-primary" style="width: fit-content">
                    Detail Produk
                </h6>
            </div>
            <p class="text-detail">

            </p>
        </div>
        <div class="w-100 mt-2">
            <div class="w-100 border border-dark-subtle border-1 rounded px-4 py-3">
                <h6 class="fw-bold" style="font-size: 1.25rem; line-height: 1.5rem;">
                    Pesanan
                </h6>
                <span class="fw-semibold">Jumlah</span>
                <div class="w-100 d-flex justify-content-between align-items-end mt-4">
                    <div class="d-flex justify-content-between align-items-center border border-dark-subtle border-2 rounded"
                        style="width:fit-content;">
                        <button class="button-icon-outline-left">
                            <i class="bi bi-dash" style="font-size: 24px;"></i>
                        </button>
                        <input class="input-checkout" type="number" value="1">
                        <button class="button-icon-outline-right">
                            <i class="bi bi-plus" style="font-size: 24px;"></i>
                        </button>
                    </div>
                    <strong style="font-size: 1rem; color: #858585; line-height: 1.5rem" class="text-stock">

                    </strong>
                </div>
                <div class="w-100 d-flex justify-content-between align-items-end mt-4">
                    <h6 class="fw-bold">
                        Total Harga
                    </h6>
                    <h6 class="fw-bold" style="color: #EE0000;" class="text-total-price">
                        Rp 000.000
                    </h6>
                </div>
                <button type="button"
                    class="d-flex justify-content-center align-items-center btn btn-outline-primary w-100 mt-4 py-0 btn-add-to-cart">
                    <i class="bi bi-plus" style="font-size: 24px;"></i>
                    Keranjang
                </button>
                <button type="button" class="btn btn-primary w-100 mt-2 btn-buy-now">Beli Sekarang</button>
            </div>
        </div>
    </div>
    {{-- Tampilan Mobile Ed --}}

    <div class="w-100 mt-5 px-2 ">
        <h5 id="header-recomendation">Rekomendasi Kami</h5>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 row-cols-xxl-6 gap-y-2 mt-4"
            id="list-recomendation">

        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
		var duration_val = 0;
		$('input[name="duration"]').on('change', function() {
			$('.text-total-price').text($(this).data('price'));
			$('.text-price').text($(this).data('price'));
			duration_val = $(this).val();
		});

        const SLUG = `{{ $slug }}`;
        const apiKey = $('meta[name="api-key"]').attr("content"); // Ambil API Key dari meta tag
        const product_id = '{{ $product_id }}';
        let containerImageMobile = $("#containerImageProductMobile");
        let containerImagePerPhoto = $("#continerImagePhotoPerSlide");
        let containerImageDesktop = $("#containerImageProductDesktop");
        let stockProduct;

        // Fill Data Product
        $.ajax({
            url: "/api/product/" + SLUG,
            type: "GET",
            dataType: "json",
            headers: {
                "X-API-Key": apiKey
            },
            success: function(response) {
                // console.log('response detail', response);

                if (response.success) {
                    const row = response.data;
                    const arrayImage = [row.image_1, row.image_2, row.image_3, row.image_4];
                    console.log("Arrat Image", arrayImage);

                    //  Handle Slider Mobile Start
                    containerImageMobile.html(`
                    <div class="swiper mobile w-100 d-flex justify-content-center align-items-center p-1"
                        style="height: 348px; overflow: hidden;">
                        <div class="swiper-wrapper swiper-wrapper-mobile">
                            ${arrayImage.filter(image => image !== null && image !== "null" && image !== "").map((image, index) =>{
                                let urlImage = '{{ asset('uploads/product') }}/' + image;
                                return `
                                                            <div class="swiper-slide w-100 d-flex justify-content-center align-items-center">
                                                                <img src="${urlImage}" alt="${urlImage}" class="w-75"
                                                                    style="object-fit: cover; object-position: center;">
                                                            </div>`
                            }).join("")}
                        </div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>`);
                    const swiperDetailMobile = new Swiper('.swiper.mobile', {
                        slidesPerView: 1,
                        spaceBetween: 30,
                        loop: false,
                        pagination: {
                            el: ".swiper-pagination",
                            clickable: true,
                        },
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                        zoom: {
                            maxRatio: 2,
                            minRatio: 1
                        },
                    });
                    // Handle Slider Mobile End

                    // Handle Slider Image Per Photo Start
                    containerImagePerPhoto.html(`<div class="swiper detail">
                        <div class="swiper-wrapper swiper-wrapper-desktop" style="width: auto;">
                            ${arrayImage.filter(image => image !== null && image !== "null" && image !== "").map((image, index) =>{
                                let urlImage = '{{ asset('uploads/product') }}/' + image;
                                return `
                                                            <div class="swiper-slide">
                                                                <div class="col text-center d-flex flex-column align-items-center" style="cursor: pointer;">
                                                                    <img src="${urlImage}" class="" alt="${urlImage}" style="width:4rem; height:4rem; object-fit: cover; object-position: center;">
                                                                </div>
                                                            </div>
                                                            `
                            }).join("")}
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>`);

                    const swiperImagePerPhoto = new Swiper('.swiper.detail', {
                        slidesPerView: 5,
                        spaceBetween: 30,
                        loop: false,
                        pagination: {
                            el: ".swiper-pagination",
                            clickable: true,
                        },
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                        zoom: {
                            maxRatio: 2,
                            minRatio: 1
                        },
                        breakpoints: {
                            576: {
                                slidesPerView: 5
                            },
                            768: {
                                slidesPerView: 5
                            },
                            1024: {
                                slidesPerView: 5
                            },
                        },
                    });
                    // Handle Slider Image Per Photo End

                    //  Handle Slider Desktop Start
                    containerImageDesktop.html(`
                    <div class="swiper desktop w-100 d-flex justify-content-center align-items-center p-1"
                        style="height: 348px; overflow: hidden;">
                        <div class="swiper-wrapper swiper-wrapper-desktop">
                            ${arrayImage.filter(image => image !== null && image !== "null" && image !== "").map((image, index) =>{
                                let urlImage = '{{ asset('uploads/product') }}/' + image;
                                return `
                                                            <div class="swiper-slide w-100 d-flex justify-content-center align-items-center p-1"
                                                                style="height: 348px; overflow: hidden;">
                                                                <img src="${urlImage}" alt="${urlImage}" class="w-75 h-75 image-main"
                                                                    style="object-fit: cover; object-position: center">
                                                            </div>`
                            }).join("")}
                        </div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>`);
                    const swiperDetailDesktop = new Swiper('.swiper.desktop', {
                        slidesPerView: 1,
                        spaceBetween: 30,
                        loop: false,
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                        zoom: {
                            maxRatio: 2,
                            minRatio: 1
                        },
                    });
                    // Handle Slider Desktop End


                    $('.text-category').text(row.category.name);
                    $('.text-name').text(row.name);
                    $('.text-price').text('Rp ' + row.price.toLocaleString('id-ID'));
                    $('.text-detail').text(row.description);
                    $('.text-stock').text('Stok: ' + row.stock);
                    stockProduct = row.stock;
                    $('.text-total-price').text('Rp ' + row.price.toLocaleString('id-ID'));
                    $('.supplier-name').text(row.seller.name);

                    $('.lihat-seller').on('click', function() {
                        console.log('click');
                        console.log(row.seller.username);
                        window.location.href = `{{ url('/detail-seller/${row.seller.username}') }}`;
                    });

                    $('.btn-category').on('click', function() {
                        console.log('click');

                        // Pastikan `row` tersedia
                        if (typeof row !== 'undefined' && row.category) {
                            console.log(row.category.slug);

                            // Redirect ke URL yang benar
                            window.location.href =
                                `/shop?category_product_filter=${encodeURIComponent(row.category.slug)}`;
                        } else {
                            console.error('row.category tidak ditemukan');
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data products:", error);
            }
        });

        // Fill Data Recommendations
        $.ajax({
            url: "/api/products/recomendation?product_id=" + product_id,
            type: "GET",
            dataType: "json",
            headers: {
                "X-API-Key": apiKey
            },
            success: function(response) {
                const container = $('#list-recomendation');
                const headerRecom = $('#header-recomendation');
                container.html('');

                if (response.success) {
                    const data = response.data;
                    if (data.length == 0) {
                        headerRecom.addClass('d-none');
                    } else {
                        headerRecom.removeClass('d-none');
                    }

                    for (const key in data) {
                        let row = data[key];
                        let imageUrl = '{{ asset('uploads/product') }}/' + row.image_1;

                        let item = `
                        <div class="col px-1 px-md-2 mb-4">
                            <div class="card product" style="padding-left: 0rem; padding-right: 0rem; cursor:pointer;">
                                <img src="${imageUrl}" class="card-img-top"
                                    alt="Gambar Produk"
                                    style="width: 7rem; height: auto; margin: 0 auto; padding-top: 0.5rem; object-fit: cover; object-position: center;" onclick="window.location.href='{{ url('/product/${row.slug}') }}'">
                                <div class="card-body">
                                    <span class="text-primary fw-semibold" style="font-size: 14px;" onclick="window.location.href='/shop?category_product_filter=${encodeURIComponent(row.category.slug)}'">${row.category.name.length > 15 ? row.category.name.substring(0, 15) + '...' : row.category.name}</span>
                                    <span class="d-block" onclick="window.location.href='{{ url('/product/${row.slug}') }}'">${row.name.length > 15 ? row.name.substring(0, 15) + '...' : row.name}</span>
                                    <div
                                        class="d-flex flex-column flex-md-row align-content-md-center justify-content-md-between mt-1 gap-md-2">
                                        <h5 class="mt-2 fw-bold" style="font-size: 14px;">Rp ${row.price.toLocaleString('id-ID')}</h5>
                                        <a href="{{ url('/product/${row.slug}') }}" class="d-none d-lg-block w-fit btn btn-primary whitespace-nowrap">
                                            <i class="d-inline-block fa-solid fa-cart-shopping"></i>
                                            <span class="d-inline-block mx-1 d-lg-none">Add</span>
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center gap-1 mt-1" onclick="window.location.href='/detail-seller/${row.seller.username}'">
                                        <i class="fa-solid fa-circle-check" style="color: #229FE1; font-size: 12px;"></i>
                                        <span class="fw-semibold" style="font-size: 12px;">
                                            ${
                                                row.seller.name.length > 20
                                                    ? row.seller.name.substring(
                                                          0,
                                                          20
                                                      ) + "..."
                                                    : row.seller.name
                                            }
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>`;

                        container.append(item);
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error("Error Recomendation :", error);
            }
        });

        // Update total price on quantity change
        function updateTotalPrice() {
            const price = parseInt($('.text-price').text().replace('Rp ', '').replace(/\./g, ''));
            const quantity = parseInt($('.input-checkout').val());
            const totalPrice = price * quantity;
            $('.text-total-price').text('Rp ' + totalPrice.toLocaleString('id-ID'));
        }

        // Event listeners for plus and minus buttons
        $('.button-icon-outline-left').on('click', function() {
            let quantityInput = $(this).siblings('.input-checkout');
            let quantity = parseInt(quantityInput.val());
            if (quantity > 1) {
                quantityInput.val(quantity - 1);
                updateTotalPrice();
            }
        });

        $('.button-icon-outline-right').on('click', function() {
            let quantityInput = $(this).siblings('.input-checkout');
            let quantity = parseInt(quantityInput.val());
            if (quantity < stockProduct) {
                quantityInput.val(quantity + 1);
                updateTotalPrice();
            }
        });

        $('.input-checkout').on('input', function() {
            let quantityInput = $(this);
            let quantity = parseInt(quantityInput.val());
            if (isNaN(quantity)) {
                quantityInput.val(1);
                return;
            }

            if (quantity < 1) {
                sweetAlertWarning("Jumlah produk tidak boleh kurang dari 1");
                quantityInput.val(1);
            } else if (quantity > stockProduct) {
                sweetAlertWarning("Jumlah produk tidak boleh melebihi stok");
                quantityInput.val(stockProduct);
            }

            updateTotalPrice();
        });

        // Initial total price calculation
        updateTotalPrice();

        $('.btn-add-to-cart').on('click', function() {
            if ('{{ session('customer_already_login') }}' != true) {
                sweetAlertWarning('Please login first to add product to cart.')
                window.location.href = '{{ url('/login') }}';

                return;
            }

            let duration = $('input[name="duration"]').val();
            const quantity = parseInt($('.input-checkout').val());
            const customerId = '{{ $customer_id }}';
            const productId = '{{ $product_id }}';
            const sellerId = '{{ $seller_id }}';
            const self = this;

            $.ajax({
                url: "/api/customer/add/cart",
                type: "POST",
                dataType: "json",
                headers: {
                    "X-API-Key": apiKey
                },
                data: {
                    customer_id: customerId,
                    seller_id: sellerId,
                    product_id: productId,
                    qty: quantity,
                    duration : duration_val
                },
                success: function(response) {
                    if (response.success) {
                        updateCartNotification();
                        sweetAlertSuccess('Product added to cart successfully!');
                    } else {
                        sweetAlertDanger('Failed to add product to cart.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error adding to cart:", error);
                    sweetAlertDanger('An error occurred while adding the product to the cart.');
                }
            });
        });

        $('.btn-buy-now').on('click', function() {
            if ('{{ session('customer_already_login') }}' != true) {
                sweetAlertWarning('Please login first to add product to cart.')
                window.location.href = '{{ url('/login') }}';

                return;
            }

            let duration = $('input[name="duration"]').val();
            const quantity = parseInt($('.input-checkout').val());
            const customerId = '{{ $customer_id }}';
            const productId = '{{ $product_id }}';
            const sellerId = '{{ $seller_id }}';
            const self = this;

            $.ajax({
                url: "/api/customer/add/cart",
                type: "POST",
                dataType: "json",
                headers: {
                    "X-API-Key": apiKey
                },
                data: {
                    customer_id: customerId,
                    seller_id: sellerId,
                    product_id: productId,
                    qty: quantity,
                    duration : duration_val
                },
                success: function(response) {
                    if (response.success) {
                        updateCartNotification();
                        window.location.href = '{{ url('/checkout-cart') }}';
                    } else {
                        sweetAlertDanger('Failed to add product to cart.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error adding to cart:", error);
                    sweetAlertDanger('An error occurred while adding the product to the cart.');
                }
            });
        });
    </script>
@endsection
