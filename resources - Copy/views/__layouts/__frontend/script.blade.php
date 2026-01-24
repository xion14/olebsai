<script type="text/javascript">
    $(document).ready(function() {
        var $btnLogoutMain = $('#btnLogout');

        function logoutCostumer() {
            return new Promise((resolve, reject) => {
                sweetAlertLoading()

                $.ajax({
                    headers: {
                        'X-API-KEY': '{{ env('API_KEY') }}'
                    },
                    url: '{{ route('api.customers.logout') }}',
                    type: 'GET',
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

        $btnLogoutMain.on('click', function() {
            Swal.fire({
                title: "Are you sure want to logout?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#229FE1",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, logout!"
            }).then((result) => {
                if (result.isConfirmed) {
                    logoutCostumer()
                        .then((response) => {
                            console.log("Response API Logout: ", response);
                            if (response.status === 200 && response.text ==
                                'Logout Success') {

                                sessionStorage.setItem('flashMessage',
                                    'Thank you for using our services. See you next time.'
                                );
                                window.location.href =
                                    "{{ url('/customer-end-session') }}";
                            } else {
                                Swal.close();
                                sweetAlertDanger(response.text);
                            }
                        })
                        .catch((error) => {
                            Swal.close();
                            console.error('Terjadi Masalah Saat Logout: ',
                                error);
                            sweetAlertDanger(error.response.text);
                        });
                }
            });
        });

        function sweetAlertLoading() {
            Swal.fire({
                title: "Loading...",
                html: "Please wait a moment",
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        }

        function sweetAlertSuccess(message) {
            Swal.fire({
                title: "Success",
                text: message,
                icon: "success",
                confirmButtonColor: "#229FE1"
            });
        }

        function sweetAlertDanger(message) {
            Swal.fire({
                title: "Failed",
                text: message,
                icon: "error",
                confirmButtonColor: "#229FE1"
            });
        }

        $("#searchInput").on("input", function() {
            let query = $(this).val().trim();

            if (query.length >= 3) {
                $.ajax({
                    headers: {
                        'X-API-KEY': '{{ env('API_KEY') }}'
                    },
                    url: "api/products/search-recomendation",
                    type: "GET",
                    data: {
                        query: query
                    },
                    success: function(response) {
                        $("#searchSuggestions").empty();
                        if (response.data.length > 0) {
                            $("#searchSuggestions").removeClass("d-none").addClass('show');
                            $.each(response.data, function(index, product) {
                                $("#searchSuggestions").append(`
                                    <li class="dropdown-item">
                                        <a href="{{ url('shop?search_filter_shop=${product.name}') }}" class="d-block text-decoration-none" style="font-size:14px;">${product.name}</a>
                                    </li>
                                `);
                            });
                        } else {
                            $("#searchSuggestions").addClass("d-none").removeClass('show');
                        }
                    }
                });
            } else {
                $("#searchSuggestions").addClass("d-none").removeClass('show');
            }
        });

        // Menutup dropdown jika klik di luar area pencarian
        $(document).on("click", function(e) {
            if (!$("#searchInput").is(e.target) && !$("#searchSuggestions").is(e.target) && $(
                    "#searchSuggestions").has(e.target).length === 0) {
                $("#searchSuggestions").addClass("d-none").removeClass('show');
            }
        });

        // Load Information Bar
        $.ajax({
            headers: {
                'X-API-KEY': '{{ env('API_KEY') }}'
            },
            url: '{{ url('api/information-bar') }}',
            type: 'GET',
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    var information_bar = response.data;
                    $('#information-bar').html(information_bar.text);
                }
            },
            error: function(xhr, status, error) {
                reject(xhr);
            }
        });
    });

    function updateCartNotification() {
        var customer_id = '{{ session('customer_id') }}';
        $.ajax({
            headers: {
                'X-API-KEY': '{{ env('API_KEY') }}'
            },
            url: '{{ url('api/customer/get/cart') }}?customer_id=' + customer_id,
            type: 'GET',
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    var total_cart = response.data.length;
                    if (total_cart > 0) {
                        $('.btn-cart').removeClass('d-none');
                        $('.text-qty-cart').text(total_cart);
                    } else {
                        $('.btn-cart').addClass('d-none');
                        $('.text-qty-cart').text('');
                    }
                }
            },
            error: function(xhr, status, error) {
                reject(xhr);
            }
        });
    }

    // Call Function
    updateCartNotification();

    function getDetailsProfile() {
        $.ajax({
            headers: {
                'X-API-KEY': '{{ env('API_KEY') }}'
            },
            url: `{{ url('api/customer/detail/') }}/{{ session('customer_id') }}`,
            method: 'GET',
            processData: false,
            contentType: false,
            success: function(response) {
                // console.log("Response API Get Detail Customer: ", response.data);
                let responseData = response.data;
                if (responseData !== null || responseData !== undefined || responseData !==
                    '') {
                    $("#profileNameMain").text(responseData.name);
                    $("#profileEmailMain").text(responseData.email);
                    $('#imageProfileMain').attr('src', responseData.image_user_profile === null ?
                        `{{ asset('assets/image/profile/profile.jpeg') }}` :
                        "/uploads/customer/" + responseData
                        .image_user_profile)
                } else {
                    $("#profileNameMain, #profileEmailMain").text("-");
                    $('#imageProfileMain').attr('src',
                        `{{ asset('assets/image/profile/profile.jpeg') }}`);
                }
            },
            error: function(error) {
                $("#firstName, #birthDate, #gender, #email, #phone, #wallet")
                    .val("");
                $('#imageProfileMain').attr('src',
                    `{{ asset('assets/image/profile/profile.jpeg') }}`);
                console.error("Terjadi kesalahan dalam mengambil data detail customer:", xhr);
            }
        });
    }
</script>

@if (session('customer_already_login') === true)
    <script>
        getDetailsProfile();
    </script>
@endif

@if (session('success'))
    <script>
        Swal.fire({
            title: "Success",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonColor: "#229FE1"
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            title: "Failed",
            text: "{{ session('error') }}",
            icon: "error",
            confirmButtonColor: "#229FE1"
        });
    </script>
@endif
