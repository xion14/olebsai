@extends('__layouts.__admin.main')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/panel/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/panel/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/panel/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/panel/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/brands.min.css"
        integrity="sha512-58P9Hy7II0YeXLv+iFiLCv1rtLW47xmiRpC1oFafeKNShp8V5bKV/ciVtYqbk2YfxXQMt58DjNfkXFOn62xE+g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('body')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Admin Dashboard</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="far fa-user"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Seller</h4>
                                </div>
                                <div class="card-body" id="total-seller">
                                    25
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="far fa-user"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Customer</h4>
                                </div>
                                <div class="card-body" id="total-customer">
                                    42
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fa-solid fa-cart-shopping" style="font-size: 1.5rem; color: #fff;"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Product</h4>
                                </div>
                                <div class="card-body" id="total-product">
                                    115
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger" style="font-size: 1.5rem; color: #fff;">
                                <i class="fa-solid fa-money-bill-transfer"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Transaction Waiting Admin</h4>
                                </div>
                                <div class="card-body" id="total-transaction-wait-admin">
                                    5
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card card-statistic-2">
                            <div class="card-stats">
                                <div class="card-stats-title">
                                    <div class="mb-2">
                                        Transaction Statistics
                                    </div>
                                    <div class="dropdown d-inline mt-2">
                                        <select name="date-month" id="date-month"
                                            class="form-control form-control-sm col-md-3">
                                            @php
                                                $currentMonth = now()->subMonth();
                                                for ($i = 0; $i < 12; $i++) {
                                                    $month = $currentMonth->copy()->subMonths($i);
                                                    $selected = $i === 0 ? 'selected' : '';
                                                    echo "<option value=\"{$month->format(
        'm-Y',
    )}\" {$selected}>{$month->format('F Y')}</option>";
                                                }
                                            @endphp
                                        </select>
                                    </div>
                                </div>
                                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 mx-2 mx-md-3 mx-lg-5">
                                    <div class="col-6 col-md-4 col-lg-3 my-3">
                                        <div class="w-100 d-flex flex-column gap-2">
                                            <h4 class="fs-3 fw-bold" id="total_waiting_seller"></h4>
                                            <span class="card-stats-item-label">Seller Confirmation</span>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4 col-lg-3 my-3">
                                        <div class="w-100 d-flex flex-column gap-2">
                                            <h4 class="fs-3 fw-bold" id="total_waiting_admin"></h4>
                                            <span class="card-stats-item-label">Admin Confirmation</span>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4 col-lg-3 my-3">
                                        <div class="w-100 d-flex flex-column gap-2">
                                            <h4 class="fs-3 fw-bold" id="total_waiting_payment"></h4>
                                            <span class="card-stats-item-label">Waiting Payment</span>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4 col-lg-3 my-3">
                                        <div class="w-100 d-flex flex-column gap-2">
                                            <h4 class="fs-3 fw-bold" id="total_waiting_packing"></h4>
                                            <span class="card-stats-item-label">Waiting Packing</span>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4 col-lg-3 my-3">
                                        <div class="w-100 d-flex flex-column gap-2">
                                            <h4 class="fs-3 fw-bold" id="total_waiting_delivery"></h4>
                                            <span class="card-stats-item-label">On Packing</span>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4 col-lg-3 my-3">
                                        <div class="w-100 d-flex flex-column gap-2">
                                            <h4 class="fs-3 fw-bold" id="total_on_delivery"></h4>
                                            <span class="card-stats-item-label">On Delivery</span>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4 col-lg-3 my-3">
                                        <div class="w-100 d-flex flex-column gap-2">
                                            <h4 class="fs-3 fw-bold" id="total_success"></h4>
                                            <span class="card-stats-item-label">Received</span>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4 col-lg-3 my-3">
                                        <div class="w-100 d-flex flex-column gap-2">
                                            <h4 class="fs-3 fw-bold" id="total_cancel">5</h4>
                                            <span class="card-stats-item-label">Cancelled & Expired</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-icon shadow-primary bg-primary">
                                <i class="fas fa-archive"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Orders</h4>
                                </div>
                                <div class="card-body" id="total_all">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="card card-statistic-2">
                            <div class="card-chart">
                                <canvas id="balance-chart"></canvas>
                            </div>
                            <div class="card-icon shadow-primary bg-primary">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>6 Bulan Terakhir</h4>
                                </div>
                                <div class="card-body">
                                    Balance
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="card card-statistic-2">
                            <div class="card-chart">
                                <canvas id="sales-chart"></canvas>
                            </div>
                            <div class="card-icon shadow-primary bg-primary">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>6 Bulan Terakhir</h4>
                                </div>
                                <div class="card-body">
                                    Penjualan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Budget vs Sales</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="myChart" height="158"></canvas>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/panel/modules/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/panel/js/page/modules-sparkline.js') }}"></script>
    <script src="{{ asset('assets/panel/modules/chart.min.js') }}"></script>
    <script src="{{ asset('assets/panel/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/panel/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('assets/panel/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
    <script src="{{ asset('js/dashboard_admin.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{ url('admin/get-data-dashboard') }}",
                type: 'GET',
                success: function(response) {
                    var data = response.data;
                    $('#total-seller').text(data.total_seller);
                    $('#total-customer').text(data.total_customer);
                    $('#total-product').text(data.total_product);
                    $('#total-transaction-wait-admin').text(data.total_transaction_wait_admin);
                }
            });

            function getStatistics(month, year) {
                $.ajax({
                    url: "{{ url('admin/get-transaction-statistics') }}",
                    type: 'GET',
                    data: {
                        month: month,
                        year: year
                    },
                    success: function(response) {
                        var data = response.data;
                        $('#total_waiting_seller').text(data.total_waiting_seller);
                        $('#total_waiting_admin').text(data.total_waiting_admin);
                        $('#total_waiting_payment').text(data.total_waiting_payment);
                        $('#total_waiting_packing').text(data.total_waiting_packing);
                        $('#total_waiting_delivery').text(data.total_waiting_delivery);
                        $('#total_on_delivery').text(data.total_on_delivery);
                        $('#total_success').text(data.total_success);
                        $('#total_cancel').text(parseInt(data.total_cancel) + parseInt(data
                            .total_expired));
                        $('#total_all').text(data.total_all);
                    }
                })
            }

            $('#date-month').on('change', function() {
                var data = $(this).val();
                data = data.split('-');

                getStatistics(data[0], data[1]);
            });

            getStatistics('{{ now()->format('m') }}', '{{ now()->format('Y') }}');
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.btn-success').on('click', function() {
                sweetAlertSuccess('Hello');
            });
            $('.btn-danger').on('click', function() {
                sweetAlertDanger('danger');
            });
            $('.btn-danger').on('click', function() {
                sweetAlertDanger('danger');
            });
        });
    </script>

    <script>
        function getCardDataAdmin() {
            $.ajax({
                url: '{{ route('api.dashboard.admin-card-data') }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if(response.success){
                        // set ke card
                        let data = response.data;

                        $('#totalSeller').text(data.totalSeller);
                        $('#totalCustomer').text(data.totalCustomer);
                        $('#totalUser').text(data.totalUser);
                        $('#totalProduct').text(data.totalProduct);
                        $('#totalCategory').text(data.totalCategory);
                        $('#totalProductConfirm').text(data.totalProductConfirm);
                        $('#sellerConfirm').text(data.totalSellerConfirm);
                        $('#totalWaitingAdmin').text(data.totalAdminConfirm);
                    }
                },
                error: function(xhr, status, error){
                    console.error('Error:',error);
                    Swal.fire({
                        icon: "error",
                        title: "Error Get Data Card",
                        text: "Error Terjadi saat memanggil data card.",
                    });
                }
            });
        }

        function getCardData() {
            $.ajax({
                url: '{{ route('api.dashboard.card-data') }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if(response.success){
                        // set ke card
                        let data = response.data;
                        $('#sellerConfirmationNum').text(data.totalSellerConfirm);
                        $('#adminConfirmationNum').text(data.totalAdminConfirm);
                        $('#waitingPaymentNum').text(data.totalWaitingPayment);
                        $('#paymentDoneNum').text(data.totalPaymentDone);
                        $('#onPackingNum').text(data.totalPacking);
                        $('#onDeliveryNum').text(data.totalOnDelivery);
                        $('#receivedNum').text(data.totalReceived);
                        $('#cancelledNum').text(data.totalCancelled);
                        $('#totalTransactionNum').text(data.totalTransaction);
                    }
                },
                error: function(xhr, status, error){
                    console.error('Error:',error);
                    Swal.fire({
                        icon: "error",
                        title: "Error Get Data Card",
                        text: "Error Terjadi saat memanggil data card.",
                    });
                }
            });
        }

        function getBalanceInfo() {
            $.ajax({
                url: '{{ route('api.dashboard.balance-data-admin') }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if(response.success){
                        // set ke card
                        let data = response.data;
                        $('#sellerBalance').html("Rp."+ data.totalSellerBalance);
                        $('#sellerWithdraw').html("Rp."+ data.totalSellerWithdraw);

                    }
                },
                error: function(xhr, status, error){
                    console.error('Error:',error);
                    Swal.fire({
                        icon: "error",
                        title: "Error Get Data Card",
                        text: "Error Terjadi saat memanggil data card.",
                    });
                }
            });
        }

        function getProductConfirmationInfo() {
            $.ajax({
                url: '{{ route('api.dashboard.admin-product-confirmation') }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if(response.success){
                        // set ke card
                        let data = response.data;
                        let tbody = $('#productConfirmation tbody');
                        if(data.length > 0){
                            $.each(data,function(index,row) {
                                tbody.append(`
                                <tr>
                                    <td>${row.seller}</td>
                                    <td>${row.code}</td>
                                    <td>${row.name}</td>
                                    <td>${row.category}</td>                           
                                </tr>`);
                            });
                        } else {
                            tbody.append('<tr><td colspan=4 class="text-center">Data Kosong</td></tr>');
                        }
                    }
                },
                error: function(xhr, status, error){
                    console.error('Error:',error);
                    Swal.fire({
                        icon: "error",
                        title: "Error Get Data Card",
                        text: "Error Terjadi saat memanggil data card.",
                    });
                }
            });
        }

        function getSellerConfirmationInfo() {
            $.ajax({
                url: '{{ route('api.dashboard.admin-seller-confirmation') }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if(response.success){
                        // set ke card
                        let data = response.data;
                        console.log(data);
                        let tbody = $('#sellerConfirmation tbody');
                        if(data.length > 0){
                            $.each(data,function(index,row) {
                                tbody.append(`
                                <tr>
                                    <td>${row.name}</td>
                                    <td>${row.email}</td>
                                    <td>${row.phone}</td>
                                    <td>${row.location}</td>                           
                                </tr>`);
                            });
                        } else {
                            tbody.append('<tr><td colspan=4 class="text-center">Data Kosong</td></tr>');
                        }
                    }
                },
                error: function(xhr, status, error){
                    console.error('Error:',error);
                    Swal.fire({
                        icon: "error",
                        title: "Error Get Data Card",
                        text: "Error Terjadi saat memanggil data card.",
                    });
                }
            });
        }

        $(document).ready(function() {
            getCardDataAdmin();
            getCardData();
            getBalanceInfo();
            getProductConfirmationInfo();
            getSellerConfirmationInfo();
        });
    </script>
@endsection
