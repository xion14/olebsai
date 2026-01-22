@extends('__layouts.__frontend.main')

@section('body')
    <div class="w-100 mt-3">
        <div class="row px-2">
            <div class="col-12 col-lg-3 p-lg-4 py-2">
                <button type="button"
                    class="d-flex d-lg-none flex-row align-items-center btn btn-primary text-white mb-2 mb-lg-0 mx-0 mx-lg-2 text-nowrap"
                    data-bs-toggle="modal" data-bs-target="#modalFilter">
                    <i class="bi bi-funnel" style="font-size: 16px;"></i>
                    <span class="d-inline-block mx-1">Filter</span>
                </button>
                <div class="w-100 d-none d-lg-block">
                    <h5 class="fw-semibold pb-2 border-bottom border-2">Filter Produk</h5>
                    <h5 class="fw-semibold mt-3">
                        Kategori
                    </h5>
                    <div class="w-100 mt-3 px-2">
                        @foreach ($categories as $category)
                            <div class="form-check mb-2">
                                <input class="form-check-input" name="{{ $category->id }}" id="{{ $category->id }}"
                                    type="checkbox" value="{{ $category->slug }}"
                                    data-categori-slug="{{ $category->slug }}">
                                <label class="form-check-label fw-medium" for="{{ $category->id }}">
                                    {{ $category->name }}
                                </label>
                                <ul>
                                    @foreach ($category->subcat as $subcategory)
                                        <li style="list-style: none;">
                                            
                                            <input class="form-check-input" name="{{ $subcategory->id }}" id="{{$subcategory->id}}" type="checkbox" value="{{ $subcategory->name }}" data-categori-slug="{{ $subcategory->code }}">
                                            <label class="form-check-label fw-medium" for="{{ $subcategory->id }}">
                                                {{ $subcategory->name }}
                                            </label>

                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-9 p-lg-4 mt-2 mt-lg-0">
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 row-cols-xxl-4 gap-y-2"
                    id="list-product">

                </div>
                <div class="d-flex align-items-end justify-content-between gap-5">
                    <div class="w-75">
                        <span id="data-info" class="" style="font-size: 14px; line-height: 1.5;">
                            Showing 0 of 0
                        </span>
                        <nav aria-label="..." class="mt-2">
                            <ul class="pagination my-0 mb-0">
                                <li class="page-item active" data-item="20"><a class="page-link" href="#">20</a>
                                </li>
                                <li class="page-item" data-item="40">
                                    <a class="page-link" href="#">40</a>
                                </li>
                                <li class="page-item" data-item="80"><a class="page-link" href="#">80</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="w-25 d-flex  flex-column align-items-end gap-2">
                        <span id="page-info" class="" style="font-size: 14px; line-height: 1.5; text-align: end;">
                            Page 0 of 0
                        </span>
                        <div class="d-flex align-items-center justify-content-end gap-2">
                            <button id="prev-page" type="button" class="btn btn-outline-primary border-1 rounded-circle">
                                <i class="fa-solid fa-chevron-left" style="font-size: 16px;"></i>
                            </button>
                            <button id="next-page" type="button" class="btn btn-outline-primary border-1 rounded-circle">
                                <i class="fa-solid fa-chevron-right" style="font-size: 16px;"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="modalFilter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Filter Produk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <h5 class="fw-semibold">Kategori</h5>
                    <div class="w-100 mt-3 px-2">
                        @foreach ($categories as $category)
                            <div class="form-check mb-2">
                                <input class="form-check-input" name="mobile-{{ $category->id }}"
                                    id="mobile-{{ $category->id }}" type="checkbox" value="{{ $category->slug }}"
                                    data-categori-slug="{{ $category->slug }}">
                                <label class="form-check-label fw-medium" for="mobile-{{ $category->id }}">
                                    {{ $category->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const apiKey = $('meta[name="api-key"]').attr("content");
            const categoryCheckboxes = $('.form-check-input');
            const productList = $('#list-product');
            let querySearch = "{{ @$_GET['search_filter_shop'] }}";
            let filterCategorySerach = "{{ @$_GET['category_product_filter'] }}";
            let selectedCategories = filterCategorySerach ? filterCategorySerach.split(',') : [];
            let totalData;
            let currentPage = 1;
            let totalPage = 1;
            let itemPerPage = 20;

            categoryCheckboxes.each(function() {
                const slugCategory = $(this).data('categori-slug');
                if (selectedCategories.includes(slugCategory)) {
                    $(this).prop('checked', true);
                }
            });


            categoryCheckboxes.on('change', function() {
                const slugCategory = $(this).data('categori-slug');

                if ($(this).prop('checked')) {
                    if (!selectedCategories.includes(slugCategory)) {
                        selectedCategories.push(slugCategory);
                    }
                } else {
                    selectedCategories = selectedCategories.filter(category => category !== slugCategory);

                    if (filterCategorySerach.includes(slugCategory)) {
                        filterCategorySerach = '';
                    }
                }

                filterProducts();
            });

            function filterProducts() {
                // console.log("Final Selected Categories:", selectedCategories);
                // console.log("Search Query:", querySearch);
                // console.log("Filter Category:", filterCategorySerach);

                showLoading();

                fetchProducts(selectedCategories)
                    .then(response => {
                        console.log('Response Shop Data:', response.data);

                        if (response.success) {  
                            let totalDataPerPage = Number(currentPage * itemPerPage)
                            totalData = response.data.total;
                            currentPage = response.data.current_page;
                            totalPage = response.data.last_page;
                            renderProducts(response.data.data);

                            // Update pagination info
                            $('#page-info').text(`Halaman ${currentPage} dari ${totalPage}`);
                            $('#data-info').text(
                                `Total Data ${totalDataPerPage > totalData ? totalData : totalDataPerPage} dari ${Number(totalData)}`
                            );
                            $('#prev-page').attr('disabled', currentPage == 1);
                            $('#next-page').attr('disabled', currentPage == totalPage);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching products:', error);
                    })
                    .finally(() => {
                        hideLoading();
                    });
            }

            function fetchProducts(categories) {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: `{{ url('/api/products/shop') }}?page=${currentPage}`,
                        method: 'GET',
                        data: {
                            search: querySearch == null ? "" : querySearch,
                            categories: categories,
                            item_per_page: itemPerPage
                        },
                        headers: {
                            "X-API-Key": apiKey
                        },
                        success: function(data) {
                            resolve(data);
                        },
                        error: function(error) {
                            reject(error);
                        }
                    });
                });
            }

            function showLoading() {
                productList.html('<div class="loading">Loading...</div>');
            }

            function hideLoading() {
                productList.find('.loading').remove();
            }

            function renderProducts(products) {
                productList.empty();
                products.forEach(product => {
                    const productImage = '{{ asset('uploads/product') }}' + '/' + product.image_1;
                    const formattedPrice = new Intl.NumberFormat('id-ID').format(product.price);
                    const productCard = `
                        <div class="col px-1 px-md-2 mb-4">
                            <div class="card product" style="padding-left: 0rem; padding-right: 0rem; cursor:pointer;">
                                <img src="${productImage}" class="card-img-top" alt="Product Image"
                                    style="width: 7rem; height: auto; margin: 0 auto; padding-top: 0.5rem; object-fit: cover; object-position: center;" onclick="window.location.href='product/${product.slug}'">
                                <div class="card-body">
                                    <span class="text-primary fw-semibold" style="font-size: 14px;" onclick="window.location.href='/shop?category_product_filter=${encodeURIComponent(product.category.slug)}'">
                                        ${product.category.name.length > 15 ? product.category.name.substring(0, 15) + '...' : product.category.name}
                                    </span>
                                    <span class="d-block" onclick="window.location.href='product/${product.slug}'">${product.name.length > 15 ? product.name.substring(0, 15) + '...' : product.name}</span>
                                    <div class="d-flex flex-column flex-md-row align-content-md-center justify-content-md-between mt-1 gap-md-2">
                                        <h5 class="mt-2 fw-bold" style="font-size: 14px;">${'Rp. ' + formattedPrice}</h5>
                                        <a href="product/${product.slug}" class="d-none d-lg-block w-fit btn btn-primary whitespace-nowrap">
                                            <i class="d-inline-block fa-solid fa-cart-shopping"></i>
                                            <span class="d-inline-block mx-1 d-lg-none">Add</span>
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center gap-1 mt-2" onclick="window.location.href='/detail-seller/${product.seller.username}'">
                                        <i class="fa-solid fa-circle-check" style="color: #229FE1; font-size: 12px;"></i>
                                        <span class="fw-semibold" style="font-size: 12px;">
                                            ${product.seller.name.length > 20 ? product.seller.name.substring(0, 20) + '...' : product.seller.name}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    productList.append(productCard);
                });
            }

            filterProducts();

            $(document).on('click', '#prev-page', function() {
                if (currentPage > 1) {
                    currentPage--;
                    filterProducts();
                }
            });

            $(document).on('click', '#next-page', function() {
                if (currentPage < totalPage) {
                    currentPage++;
                    filterProducts();
                }
            });

            $(document).on("click", ".page-item", function() {
                let qtyItem = $(this).attr("data-item");
                itemPerPage = qtyItem;
                currentPage = 1;
                querySearch = "";

                $(".search-input").val("");
                $(".page-item").removeClass("active");
                $(this).addClass("active");
                filterProducts();
            });
        });
    </script>
@endsection
