@extends('__layouts.__frontend.main')

@section('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script type="text/javascript">
        window.API_KEY = '{{ env('API_KEY') }}';
    </script>
@endsection


@section('body')
    <div class="w-100 mt-3">
        <img onclick="window.location.href='/shop'" src="" alt="Banner Brand" class="banner-image">
    </div>

    {{-- Kategori Produk Start --}}
    <div class="w-100 mt-5">
        <h5>#AsilDariMarauke alpha testing</h5>
        {{-- Laptop Start --}}
        <div class="swiper w-100 mt-4">
            <div class="swiper-wrapper" style="width: auto;">
                @foreach (['Accessories', 'Design Interior', 'Fashion', 'Archer', 'Other', 'Accessories', 'Design Interior', 'Archer', 'Other', 'Accessories', 'Design Interior'] as $index => $category)
                    <div class="swiper-slide">
                        <div class="col text-center d-flex flex-column align-items-center d-none d-md-block">
                            <img src="{{ asset('assets/image/brand/asset-kategori.png') }}" class="card-category"
                                alt="Kategori Produk">
                            <h6 class="card-title mt-3">{{ $category }}</h6>
                        </div>
                        <div class="col text-center d-flex flex-column align-items-center d-block d-md-none">
                            <img src="{{ asset('assets/image/brand/asset-kategori.png') }}" class="card-category"
                                alt="Kategori Produk">
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
        <h5>Produk Terbaik</h5>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 row-cols-xxl-6 mt-4 px-2" id="best_seller">

        </div>
    </div>
    {{-- Best Seller End --}}

    {{-- Banner Session 2 Start --}}
    <div class="w-100 p-3 p-lg-5 mb-5 rounded-lg rounded-3 position-relative" style="background-color: #bfe3f8;">
        <h5 class="card-title">Cek yuk produyk baru!</h5>
        <h6 class="mt-3">Beli produk baru dengan harga terbaik</h6>
        <button onclick="window.location.href='{{ url('/shop') }}'" type="button"
            class="btn btn-outline-dark mt-3 mt-md-5">
            Beli Sekarang
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
    <div class="w-100" id="recomendation-product">

        {{-- <h5>Our Recommendations</h5>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 row-cols-xxl-6 mt-5 px-2 gap-y-2">
            <div class="col px-1 px-md-2 mb-4">

            </div>
        </div> --}}
    </div>
    {{-- Our Recommendations End --}}
@endsection

@section('script')
    <script type="text/javascript">
        const swiper = new Swiper('.swiper', {
            slidesPerView: 3,
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
    <script type="module" src="{{ asset('js/homepage.js') }}"></script>
@endsection
