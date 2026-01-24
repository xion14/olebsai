@extends('__layouts.__frontend.main')

@section('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script type="text/javascript">
        window.API_KEY = '{{ env('API_KEY') }}';
    </script>
@endsection

@section('body')
    {{-- Banner Content Start --}}
    <div class="w-100 mt-3">
        <img src="{{ asset('assets/image/brand/banner-brand.jpg') }}" alt="Banner Brand" class="banner-image">
    </div>
    {{-- Banner Content End --}}

    {{-- Kategori Produk Start --}}
    <div class="w-100 mt-5">
        <h5>#OriginalFromMerauke</h5>
        {{-- Laptop Start --}}
        <div class="swiper w-100 mt-4">
            <div class="swiper-wrapper" style="width: auto;">
                @foreach (['Accessories', 'Design Interior', 'Fashion', 'Archer', 'Other', 'Accessories', 'Design Interior', 'Archer', 'Other', 'Accessories', 'Design Interior'] as $index => $category)
                    <div class="swiper-slide">
                        <div class="col text-center d-flex flex-column align-items-center d-none d-md-block">
                            <img src="{{ asset('assets/image/brand/asset-kategori.png') }}" class="card-category"
                                alt="Kategori Produk" style="width: 8rem;">
                            <h6 class="card-title mt-3">{{ $category }}</h6>
                        </div>
                        <div class="col text-center d-flex flex-column align-items-center d-block d-md-none">
                            <img src="{{ asset('assets/image/brand/asset-kategori.png') }}" class="card-category"
                                alt="Kategori Produk" width="56">
                            <h6 class="fw-medium mt-3 text-center" style="font-size: 14px;">{{ $category }}</h6>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
        {{-- Laptop End --}}
    </div>
    {{-- Kategori Produk End --}}

    {{-- Best Seller Start --}}
    <div class="w-100 my-5">
        <h5>Best Seller</h5>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 row-cols-xxl-6 mt-5 px-2 gap-y-2">
            @foreach (range(1, 6) as $index)
                <div class="col px-1 px-md-2 mb-4">
                    <div class="card product" style="padding-left: 0rem; padding-right: 0rem; cursor:pointer;"
                        onclick="window.location.href='{{ url('/detail-product') . '?' . http_build_query(['name' => 'Kalung Merauke', 'id_product' => $index]) }}'">
                        <img src="{{ asset('assets/image/brand/image-product.png') }}" class="card-img-top"
                            alt="Gambar Produk"
                            style="width: 7rem; height: auto; margin: 0 auto; padding-top: 0.5rem; object-fit: cover; object-position: center;">
                        <div class="card-body">
                            <span class="text-primary fw-semibold" style="font-size: 14px;">Fashion</span>
                            <span class="d-block">Kalung Merauke</span>
                            <div
                                class="d-flex flex-column flex-md-row align-content-md-center justify-content-md-between mt-1 gap-md-2">
                                <h5 class="mt-2 fw-bold" style="font-size: 14px;">Rp 200.000</h5>
                                <a href="#" class="d-none d-lg-block w-fit btn btn-primary whitespace-nowrap">
                                    <i class="d-inline-block fa-solid fa-cart-shopping"></i>
                                    <span class="d-inline-block mx-1 d-lg-none">Add</span>
                                </a>
                            </div>
                            <div class="d-flex align-items-center gap-1 mt-1">
                                <i class="fa-solid fa-circle-check" style="color: #229FE1; font-size: 12px;"></i>
                                <span class="fw-semibold" style="font-size: 12px;">Kamera Gadget Official</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{-- Best Seller End --}}

    {{-- Banner Session 2 Start --}}
    <div class="w-100 p-3 p-lg-5 mb-5 rounded-lg rounded-3 position-relative" style="background-color: #bfe3f8;">
        <h5 class="card-title">Check New Merauke’s Product!</h5>
        <h6 class="mt-3">Check the product now</h6>
        <button onclick="window.location.href='{{ url('/shop') }}'" type="button"
            class="btn btn-outline-dark mt-3 mt-md-5">
            New Product
            <i class="d-inline px-2 fa-solid fa-arrow-right ml-3"></i>
        </button>
        <div class="d-none position-absolute d-md-flex justify-content-end bottom-0 end-0">
            <img src="{{ asset('assets/image/brand/alat musik papua 1.png') }}" alt="Asset Banner" style="width: 9rem;">
        </div>
        <div class="d-none position-absolute d-md-flex justify-content-end" style="right: 10rem; top:50%;">
            <img src="{{ asset('assets/image/brand/papua_accs-removebg-preview 1.png') }}" alt="Asset Banner"
                style="width: 6rem;">
        </div>
        <div class="d-none position-absolute d-md-flex justify-content-end" style="right: 5rem; top:1rem;">
            <img src="{{ asset('assets/image/brand/asset-kategori.png') }}" alt="Asset Banner" style="width: 8rem;">
        </div>
    </div>
    {{-- Banner Session 2 End --}}

    {{-- Our Recommendations Start --}}
    <div class="w-100 mt-3">
        <h5>Our Recommendations</h5>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 row-cols-xxl-6 mt-5 px-2 gap-y-2">
            @foreach (range(1, 6) as $index)
                <div class="col px-1 px-md-2 mb-4">
                    <div class="card product" style="padding-left: 0rem; padding-right: 0rem; cursor:pointer;"
                        onclick="window.location.href='{{ url('/detail-product') . '?' . http_build_query(['name' => 'Kalung Merauke', 'id_product' => $index]) }}'">
                        <img src="{{ asset('assets/image/brand/image-product.png') }}" class="card-img-top"
                            alt="Gambar Produk"
                            style="width: 7rem; height: auto; margin: 0 auto; padding-top: 0.5rem; object-fit: cover; object-position: center;">
                        <div class="card-body">
                            <span class="text-primary fw-semibold" style="font-size: 14px;">Fashion</span>
                            <span class="d-block">Kalung Merauke</span>
                            <div
                                class="d-flex flex-column flex-md-row align-content-md-center justify-content-md-between mt-1 gap-md-2">
                                <h5 class="mt-2 fw-bold" style="font-size: 14px;">Rp 200.000</h5>
                                <a href="#" class="d-none d-lg-block w-fit btn btn-primary whitespace-nowrap">
                                    <i class="d-inline-block fa-solid fa-cart-shopping"></i>
                                    <span class="d-inline-block mx-1 d-lg-none">Add</span>
                                </a>
                            </div>
                            <div class="d-flex align-items-center gap-1 mt-1">
                                <i class="fa-solid fa-circle-check" style="color: #229FE1; font-size: 12px;"></i>
                                <span class="fw-semibold" style="font-size: 12px;">Kamera Gadget Official</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{-- Our Recommendations End --}}
@endsection

@section('script')
    <script type="text/javascript">
        const swiper = new Swiper('.swiper', {
            slidesPerView: 4,
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
                    slidesPerView: 4,
                    spaceBetween: 16
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 16
                },
                1024: {
                    slidesPerView: 8
                },
                1200: {
                    slidesPerView: 8
                }
            },
        });
    </script>
@endsection
