@extends('__layouts.__seller.main')

@section('head')
    <style>
        .activities .activity .activity-icon {
            width: 26px; height: 26px; line-height: 0px; font-size: 15px;
        }
        .activities .activity:before {
            left: 12px;
        }
    </style>
@endsection

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1 id="title"></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#" id="breadcrumb-1"></a></div>
                <div class="breadcrumb-item" ><a href="#" id="breadcrumb-2"></a></div>
            </div>
          </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="transactionsTable" class="table table-striped" id="table-1">
                        <thead>                                 
                        <tr>
                            <th width="5%" class="text-center">#</th>
                            <th class="text-center">Customer</th>
                            <th class="text-center">Order Id</th>
                            <th class="text-center">Other Cost</th>
                            <th class="text-center">SubTotal</th>
                            <th class="text-center">Total</th>
                            <th class="text-center d-none" id="shipping-number">Shipping Number</th>
                            <th class="text-center">Order Date</th>
                            <th class="text-center">Status</th>
                            <th width="20%" class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('modal')
    <!-- Modal Tracking -->
    <div class="modal fade" id="trackingModal" tabindex="-1" role="dialog" aria-labelledby="trackingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="trackingModalLabel">Tracking Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="list-tracking">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        var path = window.location.pathname.trim();
        var status = 1;
        $('#title').html("Confirmation Seller");
        $('#breadcrumb-1').html("Seller");
        $('#breadcrumb-2').html("Confirmation");

        if (path === '/seller/transactions/admin/confirm') {
            $('#title').html("Confirmation Admin");
            $('#breadcrumb-1').html("Admin");
            $('#breadcrumb-2').html("Confirmation");
            status = 2;
        }else if (path === '/seller/transactions/waiting_payment') {
            $('#title').html("Waiting Payment");
            $('#breadcrumb-1').html("Seller");
            status = 3;
        }else if (path === '/seller/transactions/payment_done') {
            $('#title').html("Payment Done");
            $('#breadcrumb-1').html("Seller");
            status = 4;
        }else if (path === '/seller/transactions/on_packing') {
            $('#title').html("On Packing");
            $('#breadcrumb-1').html("Seller");
            status = 5;
        }else if (path === '/seller/transactions/on_delivery') {
            $('#title').html("On Delivery");
            $('#breadcrumb-1').html("Seller");
            $('#shipping-number').removeClass('d-none');
            status = 6;
        }else if (path === '/seller/transactions/received') {
            $('#title').html("Received");
            $('#breadcrumb-1').html("Seller");
            status = 7;
        }else if (path === '/seller/transactions/cancelled') {
            $('#title').html("Cancelled");
            $('#breadcrumb-1').html("Seller");
            status = 8;
        }else if (path === '/seller/transactions/expired') {
            $('#title').html("Expired");
            $('#breadcrumb-1').html("Seller");
            status = 9;
        }
        

        var table = $('#transactionsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('seller.transactions') }}",
                type: "GET",
                data: function (d) {
                    d.status = status;
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false ,className: 'align-middle text-center'},
                { data: 'customer', name: 'customer', searchable: true ,className: 'align-middle text-center'},
                { data: 'code', name: 'Order Id', searchable: true ,className: 'align-middle text-center'},
                {
                    data: 'other_cost', 
                    name: 'other_cost', 
                    searchable: true,
                    className: 'whitespace-nowrap align-middle text-center',
                    render: function(data, type, row ) {
                        if (data !== null) {
                            return 'Rp.' + data.toLocaleString('id-ID');  
                        }
                        return '';  
                    }
                },
                {
                    data: 'subtotal', 
                    name: 'subtotal', 
                    searchable: true,
                    className: 'whitespace-nowrap align-middle text-center',
                    render: function(data, type, row ) {
                        if (data !== null) {
                            return 'Rp.' + data.toLocaleString('id-ID');  
                        }
                        return '';  
                    }
                },
                {
                    data: 'total', 
                    name: 'total', 
                    searchable: true,
                    className: 'whitespace-nowrap align-middle text-center',
                    render: function(data, type, row ) {
                        if (data !== null) {
                            return 'Rp.' + data.toLocaleString('id-ID');  
                        }
                        return '';  
                    }
                },
                
                {
                    data: 'shipping_number',
                    name: 'shipping_number',
                    searchable: true,
                    orderable: false,
                    className: 'align-middle text-center',
                    render: function(data, type, row) {
                        if (row.status.raw_status == 5 ) { 
                            return data ? `<span class="badge badge-success">${data}</span>` : '-';
                        }
                        return ''; 
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    searchable: true,
                    className: 'align-middle text-center',
                    render: function (data, type, row) {
                        if (!data) return '-'; // Jika data null
                        let date = new Date(data);
                        let year = date.getFullYear();
                        let month = ('0' + (date.getMonth() + 1)).slice(-2);
                        let day = ('0' + date.getDate()).slice(-2);
                        let hours = ('0' + date.getHours()).slice(-2);
                        let minutes = ('0' + date.getMinutes()).slice(-2);
                        let seconds = ('0' + date.getSeconds()).slice(-2);
                        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
                    }
                },
                {
                    data: 'status.formatted', 
                    name: 'status',
                    className: 'align-middle text-center',
                    orderable: false, 
                    searchable: false,
                    render: function(data, type, row) {
                        return  $('<div/>').html(data).text();
                    }
                },

                {
                    data: 'status.raw_status', // Digunakan untuk pengecekan status
                    name: 'raw_status',
                    visible: false // Disembunyikan dari tabel
                },
            
                { data: 'action', name: 'action', searchable: false, orderable: false, className: 'text-center',className: 'align-middle text-center' }
            ]
        });

        // Open Modal Tracking
        $('#transactionsTable').on('click', '.btn-tracking', function() {
            let id = $(this).data('id');
            let shipping_number = $(this).data('shipping_number');

            $('#trackingForm').trigger('reset');
            $('#trackingModal').modal('show');
            $('#transaction_id').val(id);
            $('#shipping_number').val(shipping_number);

            getTracking(id);
        });

        function getTracking (id) {
            $.ajax({
                headers: {
                    'X-API-KEY': '{{ env('API_KEY') }}'
                },
                url: '/api/delivery?transaction_id=' + id,
                type: 'GET',
                processData: false,
                contentType: false,
                success: function(response) {
                    var ui = ``;
                    if (response.success) {
                        var data = response.data;

                        data.forEach(row => {
                            ui += `
                                <div class="activities">
                                    <div class="activity">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                            <i class="fas fa-comment-alt mt-2"></i>
                                        </div>
                                        <div class="activity-detail">
                                            <div class="mb-2">
                                                <span class="bullet"></span>
                                                <span class="text-job text-primary">${new Date(row.created_at).toLocaleString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' }).replace(',', '')}</span>
                                            </div>
                                            <p>${row.note}</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                    }

                    $('#list-tracking').html(ui);
                }
            });
        }
    });
</script>
@endsection
