$(document).ready(function () {
    // mengambil dari data controller
    const idSeller = $("#idSeller").val();
    let dataProductAll = [];
    let currentPage = 1;
    let itemsPerPage = 25;
    let filteredData = dataProductAll;

    function formatRupiah(amount) {
        return "Rp " + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // GET categories
    $.ajax({
        headers: {
            "X-API-KEY": window.API_KEY,
        },
        url: "/api/categories",
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                let containers = $("#categoryContainer");
                containers.html(
                    `
                        <li><button class="dropdown-item" type="button" style="cursor: pointer; font-size: 14px; line-height: 1.5;" data-categories="">Semua Kategori</button></li>
                    `
                );

                for (const key in response.data) {
                    let product = response.data[key];
                    containers.append(`
                        <li><button class="dropdown-item" type="button" style="cursor: pointer; font-size: 14px; line-height: 1.5;" data-categories="${product.name}">${product.name}</button></li>
                    `);
                }
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching categories:", error);
        },
    });

    // GET products by category
    $.ajax({
        headers: {
            "X-API-KEY": window.API_KEY,
        },
        url: `/api/seller/product?seller_id=${idSeller}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                // console.log(response.data);
                let dataProduct = response.data;
                let containers = $("#productByCategory");

                containers.html(
                    `${Object.keys(dataProduct)
                        .map((categories) => {
                            return `<div  class="w-100 mb-3">
                            <h6>${categories}</h6>
                            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 row-cols-xxl-6 mt-4 px-2 gap-y-2">
                            ${
                                dataProduct[categories].length > 0 &&
                                dataProduct[categories]
                                    .map((product) => {
                                        let imageUrl =
                                            "/uploads/product/" +
                                            product.image_1;
                                        return `<div class="col px-1 px-md-2 mb-4">
                                    <div class="card product" style="padding-left: 0rem; padding-right: 0rem; cursor:pointer;">
                                        <img src="${imageUrl}"
                                            class="card-img-top" alt="${
                                                product.name
                                            }"
                                            style="width: 7rem; height: auto; margin: 0 auto; padding-top: 0.5rem; object-fit: cover; object-position: center;" onclick="window.location.href='/product/${
                                                product.slug
                                            }'">
                                        <div class="card-body">
                                            <span class="text-primary fw-semibold"
                                                style="font-size: 14px;" onclick="window.location.href='/shop?category_product_filter=${encodeURIComponent(
                                                    product.category.slug
                                                )}'">${
                                            product.category?.name.length > 15
                                                ? product.category.name.slice(
                                                      0,
                                                      15
                                                  ) + "..."
                                                : product.category.name || "-"
                                        }</span>
                                            <span class="d-block" onclick="window.location.href='/product/${
                                                product.slug
                                            }'">${
                                            product.name.length > 15
                                                ? product.name.slice(0, 15) +
                                                  "..."
                                                : product.name
                                        }</span>
                                            <div
                                            class="d-flex flex-column flex-md-row align-content-md-center justify-content-md-between mt-1 gap-md-2">
                                                <h5 class="mt-2 fw-bold" style="font-size: 14px;">
                                                    ${formatRupiah(
                                                        product.price
                                                    )}
                                                </h5>
                                                <a href="/product/${
                                                    product.slug
                                                }"
                                                    class="d-none d-lg-block w-fit btn btn-primary whitespace-nowrap">
                                                    <i class="d-inline-block fa-solid fa-cart-shopping"></i>
                                                    <span class="d-inline-block mx-1 d-lg-none">Add</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                                    })
                                    .join("")
                            }
                            </div>
                            
                        </div>`;
                        })
                        .join("")}`
                );
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching product by category:", error);
        },
    });

    // Get Product All
    $.ajax({
        headers: {
            "X-API-KEY": window.API_KEY,
        },
        url: `/api/seller/products?seller_id=${idSeller}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                // console.log("All Products:", response.data);
                dataProductAll = response.data;
                renderAllProduct(dataProductAll);
            } else {
                dataProductAll = [];
                renderAllProduct(dataProductAll);
            }
        },
        error: function (xhr, status, error) {
            dataProductAll = [];
            renderAllProduct(dataProductAll);
            console.error("Error fetching all products:", error);
        },
    });

    function renderAllProduct(dataProduct) {
        filteredData = dataProduct;
        let startIndex = (currentPage - 1) * itemsPerPage;
        let endIndex = startIndex + parseInt(itemsPerPage);
        let paginatedData = dataProduct.slice(startIndex, endIndex);

        if (paginatedData.length > 0) {
            $("#listProductSeller").html(
                paginatedData
                    .map((product, index) => {
                        let imageUrl = "/uploads/product/" + product.image_1;
                        return `
                            <div class="col px-1 px-md-2 mb-4" id="product-${index}">
                                <div class="card product" style="padding-left: 0rem; padding-right: 0rem; cursor:pointer;">
                                    <img src="${imageUrl}" class="card-img-top"
                                        alt="${imageUrl}"
                                        style="width: 7rem; height: auto; margin: 0 auto; padding-top: 0.5rem; object-fit: cover; object-position: center;" onclick="window.location.href='/product/${
                                            product.slug
                                        }'">
                                    <div class="card-body">
                                        <span class="text-primary fw-semibold" style="font-size: 14px;" onclick="window.location.href='/shop?category_product_filter=${encodeURIComponent(
                                            product.category.slug
                                        )}'">
                                        ${
                                            product.category?.name.length > 15
                                                ? product.category.name.slice(
                                                      0,
                                                      15
                                                  ) + "..."
                                                : product.category.name || "-"
                                        }
                                        </span>
                                        <span class="d-block" onclick="window.location.href='/product/${
                                            product.slug
                                        }'">
                                        ${
                                            product.name.length > 15
                                                ? product.name.slice(0, 15) +
                                                  "..."
                                                : product.name
                                        }
                                        </span>
                                        <div
                                            class="d-flex flex-column flex-md-row align-content-md-center justify-content-md-between mt-1 gap-md-2">
                                            <h5 class="mt-2 fw-bold" style="font-size: 14px;">
                                             ${formatRupiah(product.price)}
                                            </h5>
                                            <a href="/product/${product.slug}"
                                                class="d-none d-lg-block w-fit btn btn-primary whitespace-nowrap">
                                                <i class="d-inline-block fa-solid fa-cart-shopping"></i>
                                                <span class="d-inline-block mx-1 d-lg-none">Add</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                    })
                    .join("")
            );
        } else {
            $("#listProductSeller")
                .html(`<div class="w-100 d-flex align-items-center justify-content-center">
                    <p>Data Produk Kosong</p>
                </div>`);
        }
        updatePaginationButtons();
    }

    function updatePaginationButtons() {
        let totalPages = Math.ceil(filteredData.length / itemsPerPage);
        var startEntry = (currentPage - 1) * itemsPerPage + 1;
        var endEntry = Math.min(
            currentPage * itemsPerPage,
            filteredData.length
        );
        console.log("Start Entry:", startEntry);
        console.log("End Entry:", endEntry);

        if (filteredData.length <= itemsPerPage) {
            $("#prev-page, #next-page").prop("disabled", true);
        } else {
            $("#prev-page").prop("disabled", currentPage === 1);
            $("#next-page").prop("disabled", currentPage >= totalPages);
        }
        $("#pagination-info").text(
            `Showing ${startEntry} to ${endEntry} of ${filteredData.length} entries`
        );
    }

    $(document).on("input", ".search-input", function () {
        let query = $(this).val().toLowerCase();

        filteredData = dataProductAll.filter((product) => {
            let nameProduct = product.name.toLowerCase() || "";
            let categories = product.category?.name?.toLowerCase() || "";

            return nameProduct.includes(query) || categories.includes(query);
        });

        renderAllProduct(filteredData);
        currentPage = 1;

        $(".dropdown-item").removeClass("active");
    });

    $(document).on("click", ".page-item", function () {
        let qtyItem = $(this).attr("data-item");
        itemsPerPage = qtyItem;
        currentPage = 1;

        $(".search-input").val("");
        $(".dropdown-item").removeClass("active");
        $(".page-item").removeClass("active");
        $(this).addClass("active");

        renderAllProduct(dataProductAll);
    });

    $(document).on("click", "#prev-page", function () {
        $(".search-input").val("");
        $(".dropdown-item").removeClass("active");
        if (currentPage > 1) {
            currentPage--;
            renderAllProduct(filteredData);
        }
    });

    $(document).on("click", "#next-page", function () {
        $(".search-input").val("");
        $(".dropdown-item").removeClass("active");
        let totalPages = Math.ceil(dataProductAll.length / itemsPerPage);

        if (currentPage < totalPages) {
            currentPage++;
            renderAllProduct(filteredData);
        }
    });

    $(document).on("click", ".dropdown-item", function () {
        let categories = $(this).data("categories");
        let filterDataCategories = dataProductAll.filter(
            (product) => product.category.name == categories
        );

        currentPage = 1;
        renderAllProduct(
            categories == "" ? dataProductAll : filterDataCategories
        );

        $(".dropdown-item").removeClass("active");
        $(this).addClass("active");
        $(".search-input").val("");
    });
});
