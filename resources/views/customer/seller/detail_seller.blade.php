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
        <input type="hidden" name="idSeller" id="idSeller" value="{{ $seller->id }}">
        <div
            class="w-full d-flex flex-column flex-md-row align-items-md-center gap-3 p-3 rounded-lg bg-white border border-1 rounded-2">
            <img src="{{ asset('assets/image/brand/asset-kategori.png') }}" alt="Logo Saller"
                style="width: 6rem; height: 6rem; object-fit: cover; object-position: center; border-radius:9999px; overflow:hidden;">
            <div class="d-flex flex-column">
                <div class="d-flex align-items-center gap-1">
                    <h5 class="fw-bold">{{ $seller->name }}</h5>
                    <i class="fa-solid fa-circle-check" style="color: #229FE1; font-size: 16px;"></i>
                </div>
                <span class="fw-medium text-body-secondary fs-6">
                    {{ $seller->address }}
                </span>
            </div>
        </div>
        <div class="w-100 mt-3">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active text-body-secondary fw-semibold" id="beranda-tab" data-bs-toggle="tab"
                        data-bs-target="#beranda-tab-pane" type="button" role="tab" aria-controls="beranda-tab-pane"
                        aria-selected="true">Beranda</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-body-secondary fw-semibold" id="product-tab" data-bs-toggle="tab"
                        data-bs-target="#product-tab-pane" type="button" role="tab" aria-controls="product-tab-pane"
                        aria-selected="true">Produk Kami</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="beranda-tab-pane" role="tabpanel" aria-labelledby="beranda-tab"
                    tabindex="0">
                    <div class="w-100 mt-4">
                        {{-- Tanpa Swiper Js --}}
                        {{-- <img class="w-100 rounded-3 object-fit-cover"
                            src="{{ asset('assets/image/brand/banner_seller.webp') }}" alt="Banner Saller"
                            style="max-height: 32rem; height:100%;"> --}}
                        {{-- Menggunakan Swiper Js --}}
                        <div class="swiper rounded-3 w-100 mt-4">
                            <div class="swiper-wrapper rounded-3" style="width: auto;">
                                @foreach ($seller_banners as $banner)
                                    <div class="swiper-slide rounded-3">
                                        <a href="{{ $banner->link }}"><img class="w-100 rounded-3 object-fit-cover"
                                                src="{{ asset('uploads/banner/' . $banner->image) }}"
                                                alt="{{ $banner->title }}" style="max-height: 32rem; height:100%;"></a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                        <section id="productByCategory" class="w-100 mt-5"></section>

                    </div>
                </div>
                <div class="tab-pane fade show" id="product-tab-pane" role="tabpanel" aria-labelledby="product-tab"
                    tabindex="1">
                    <div class="w-100 d-flex align-items-center justify-content-end gap-2 mt-4">
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle py-2" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Kategori
                            </button>
                            <ul id="categoryContainer" class="dropdown-menu">

                            </ul>
                        </div>
                        <div class="search-container w-100 d-lg-none">
                            <input type="text" class="search-input" placeholder="Cari produk yang ingin dibeli">
                            <i class="fas fa-search search-icon"></i>
                        </div>
                        <div class="search-container w-50 d-none d-lg-block">
                            <input type="text" class="search-input" placeholder="Cari produk yang ingin dibeli">
                            <i class="fas fa-search search-icon"></i>
                        </div>
                    </div>
                    <div id="listProductSeller"
                        class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 row-cols-xxl-6 px-2 gap-y-2 mt-4">

                    </div>
                    <div class="d-flex align-items-end justify-content-between gap-5">
                        <div class="w-75">
                            <span id="pagination-info" class="" style="font-size: 14px; line-height: 1.5;">

                            </span>
                            <nav aria-label="..." class="mt-2">
                                <ul class="pagination my-0 mb-0">
                                    <li class="page-item active" data-item="25"><a class="page-link" href="#">25</a>
                                    </li>
                                    <li class="page-item" data-item="40">
                                        <a class="page-link" href="#">40</a>
                                    </li>
                                    <li class="page-item" data-item="80"><a class="page-link" href="#">80</a></li>
                                </ul>
                            </nav>
                        </div>
                        <div class="w-25 d-flex align-items-center justify-content-end gap-2">
                            <button id="prev-page" type="button"
                                class="btn btn-outline-secondary border-1 rounded-circle">
                                <i class="fa-solid fa-chevron-left" style="font-size: 16px;"></i>
                            </button>
                            <button id="next-page" type="button"
                                class="btn btn-outline-secondary border-1 rounded-circle">
                                <i class="fa-solid fa-chevron-right" style="font-size: 16px;"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        const swiper = new Swiper('.swiper', {
            slidesPerView: 1,
            spaceBetween: 12,
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
    </script>
    <script src="{{ asset('js/detail_seller.js') }}"></script>
@endsection
