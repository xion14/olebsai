$(document).ready(function () {
    function formatRupiah(amount) {
        return "Rp " + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // GET Banner
    let apiKey = $('meta[name="api-key"]').attr("content"); // Ambil API Key dari meta tag

    $.ajax({
        headers: {
            "X-API-KEY": window.API_KEY,
        },
        url: "/api/banner",
        type: "GET",
        dataType: "json",
        headers: {
            "X-API-Key": apiKey,
        },
        success: function (response) {
            if (response.success) {
                let imageUrl = "/uploads/banner/" + response.data;
                $(".banner-image").attr("src", imageUrl);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching banner:", error);
        },
    });

    // GET categories
    $.ajax({
        headers: {
            "X-API-KEY": window.API_KEY,
        },
        url: "/api/categories",
        type: "GET",
        dataType: "json",
        headers: {
            "X-API-Key": apiKey,
        },
        success: function (response) {
            if (response.success) {
                console.log("Categori :", response.data);
                let containers = $(".swiper-wrapper");
                containers.html("");

                for (const key in response.data) {
                    let row = response.data[key];
                    let imageUrl = "/uploads/category/" + row.image;
                    containers.append(`
                        <div class="swiper-slide">
                            <div class="col text-center d-flex flex-column align-items-center"
                            onclick="window.location.href='/shop?category_product_filter=${encodeURIComponent(
                                row.slug
                            )}'"
                            >
                                <div class="card-category-wrapper">
                                    <img src="${imageUrl}" class="card-category" 
                                        alt="Kategori Produk">
                                </div>
                                <h6 class="fw-medium mt-3 text-center" style="font-size: 14px;">
                                    ${row.name}
                                </h6>
                            </div>
                        </div>
                    `);

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
                }
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching banner:", error);
        },
    });

    // GET best-sellers
    $.ajax({
        headers: {
            "X-API-KEY": window.API_KEY,
        },
        url: "/api/products/best-sellers",
        type: "GET",
        dataType: "json",
        headers: {
            "X-API-Key": apiKey,
        },
        success: function (response) {
            console.log("response", response);
            if (response.success) {
                let containers = $("#best_seller");
                containers.html("");

                for (const key in response.data) {
                    let row = response.data[key];
                    let imageUrl = "/uploads/product/" + row.image_1;
                    containers.append(`
                        <div class="col px-1 px-md-2 mb-4">
                            <div class="card product" style="padding-left: 0rem; padding-right: 0rem; cursor:pointer;">
                                <img src="${imageUrl}" class="card-img-top"
                                    alt="${row.name}"
                                    style="width: 7rem; height: auto; margin: 0 auto; padding-top: 0.5rem; object-fit: cover; object-position: center;" onclick="window.location.href='product/${
                                        row.slug
                                    }'">
                                <div class="card-body">
                                    <span class="text-primary fw-semibold" style="font-size: 14px;" onclick="window.location.href='/shop?category_product_filter=${encodeURIComponent(
                                        row.category.slug
                                    )}'">${row.category?.name || "-"}</span>
                                    <span class="d-block" onclick="window.location.href='product/${
                                        row.slug
                                    }'">${row.name}</span>
                                    <div
                                        class="d-flex flex-column flex-md-row align-content-md-center justify-content-md-between mt-1 gap-md-2">
                                        <h5 class="mt-2 fw-bold"style="font-size: 14px;">${formatRupiah(
                                            row.price
                                        )}</h5>
                                        <a href="product/${
                                            row.slug
                                        }" class="d-none d-lg-block w-fit btn btn-primary whitespace-nowrap">
                                            <i class="d-inline-block fa-solid fa-cart-shopping"></i>
                                            <span class="d-inline-block mx-1 d-lg-none">Add</span>
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center gap-1 mt-2" onclick="window.location.href='/detail-seller/${
                                        row.seller.username
                                    }'">
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
                        </div>
                    `);
                }
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching banner:", error);
        },
    });

    // GET product based categories
    $.ajax({
        headers: {
            "X-API-KEY": window.API_KEY,
        },
        url: "/api/categories/products",
        type: "GET",
        dataType: "json",
        headers: {
            "X-API-Key": apiKey,
        },
        success: function (response) {
            console.log("response", response);
            if (response.success) {
                let container = $("#recomendation-product");
                container.html("");

                // looping categories
                for (const key in response.data) {
                    let category = response.data[key];
                    if (category.products.length > 0) {
                        let ui = ``;

                        // looping category from each product
                        for (const key_product in category.products) {
                            let row = category.products[key_product];
                            let imageUrl = "/uploads/product/" + row.image_1;
                            ui += `
                                <div class="col px-1 px-md-2 mb-4">
                                    <div class="card product" style="padding-left: 0rem; padding-right: 0rem; cursor:pointer;">
                                        <img src="${imageUrl}" class="card-img-top" alt="Gambar Produk" style="width: 7rem; height: auto; margin: 0 auto; padding-top: 0.5rem; object-fit: cover; object-position: center;" onclick="window.location.href='product/${
                                row.slug
                            }'">
                                        <div class="card-body">
                                            <span class="text-primary fw-semibold" style="font-size: 14px;" onclick="window.location.href='/shop?category_product_filter=${encodeURIComponent(
                                                category.slug
                                            )}'">${category.name}</span>
                                            <span class="d-block" onclick="window.location.href='product/${
                                                row.slug
                                            }'">${row.name}</span>
                                            <div class="d-flex flex-column flex-md-row align-content-md-center justify-content-md-between mt-1 gap-md-2">
                                                <h5 class="mt-2 fw-bold"style="font-size: 14px;">${formatRupiah(
                                                    row.price
                                                )}</h5>
                                                <a href="product/${
                                                    row.slug
                                                }" class="d-none d-lg-block w-fit btn btn-primary whitespace-nowrap">
                                                    <i class="d-inline-block fa-solid fa-cart-shopping"></i>
                                                    <span class="d-inline-block mx-1 d-lg-none">Add</span>
                                                </a>
                                            </div>
                                            <div class="d-flex align-items-center gap-1 mt-2" onclick="window.location.href='/detail-seller/${
                                                row.seller.username
                                            }'">
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
                                </div>
                            `;
                        }

                        // show data
                        ui = `<div class="w-100 my-3">
                                <h5>${category.name}</h5>
                                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 mt-3 row-cols-xl-5 row-cols-xxl-6 px-2 gap-y-2">
                                    ${ui}
                                </div>
                            </div>`;

                        container.append(ui);
                    }
                }
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching banner:", error);
        },
    });
});
