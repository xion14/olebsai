@extends('__layouts.__seller.main')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/panel/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/panel/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/panel/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/panel/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">
@endsection

@section('body')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Seller Dashboard</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col">
                        <div class="card card-statistic-2">
                            <div class="card-stats">
                                <div class="card-stats-title">
                                    <div class="mb-2">
                                        Transaction Statistics 
                                    </div>
                                    <div class="dropdown d-inline mt-2">
                                        <select name="date-month" id="date-month" class="form-control form-control-sm col-md-3">
                                            @php
                                                $currentMonth = now()->subMonth();
                                                for ($i = 0; $i < 12; $i++) {
                                                    $month = $currentMonth->copy()->subMonths($i);
                                                    $selected = $i === 0 ? 'selected' : '';
                                                    echo "<option value=\"{$month->format('m-Y')}\" {$selected}>{$month->format('F Y')}</option>";
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
    <script src="{{ asset('js/dasboard_seller.js') }}"></script>

    <script>
        $(document).ready(function() {
            function getStatistics (month, year) {
                $.ajax({
                    url: "{{ url('seller/get-transaction-statistics') }}",
                    type: 'GET',
                    data: {
                        month : month,
                        year : year
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
                        $('#total_cancel').text(parseInt(data.total_cancel) + parseInt(data.total_expired));
                        $('#total_all').text(data.total_all);
                    }
                })
            }

            $('#date-month').on('change', function () {
                var data = $(this).val();
                data = data.split('-');
                
                getStatistics(data[0], data[1]);
            });

            getStatistics('{{ now()->format('m') }}', '{{ now()->format('Y') }}');
        });
    </script>
@endsection
