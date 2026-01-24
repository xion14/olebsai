@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1 id="title">Transaction Report</h1>
            <div class="section-header-breadcrumb">
                <button id="exportBtn" class="btn btn-primary mr-1 col-sm-12">
                    <i class="fas fa-download"></i> Export
                </button>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="reportTable" class="table table-striped mt-3">
                            <thead>
                            <tr>
                                <th width="5%" class="text-center">#</th>
                                <th class="text-center">Seller Name</th>
                                <th class="text-center">Customer</th>
                                <th class="text-center">Order Id</th>
                                <th class="text-center">Products</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Order Date</th>
                                <th class="text-center">Status</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
    var startDate = '';
    var endDate = '';
    var sellerId = '';


    var table = $('#reportTable').DataTable({
        processing: true,
        serverSide: true,
        // searching: false,
        ajax: {
            url: "{{ route('admin.transactions.report') }}",
            type: "GET",
            data: function(d) {
                d.seller_id = sellerId;
                d.status = $('#typeFilter').val();
                d.start_date = startDate;
                d.end_date = endDate;
            },
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false, className: 'align-middle text-center' },
            { data: 'seller', name: 'seller', searchable: true, className: 'align-middle text-center' },
            { data: 'customer', name: 'customer', searchable: true ,className: 'align-middle text-center'},
                { data: 'code', name: 'Order Id', searchable: true ,className: 'align-middle text-center'},
                {
                    data: 'transaction_product', 
                    name: 'products', 
                    searchable: true,
                    className: 'whitespace-nowrap align-middle text-center',
                    render: function(data, type, row ) {
                        if (data !== null) {
                            return data;  
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
                    data: 'status.raw_status', 
                    name: 'raw_status',
                    visible: false
                },
            
        ]
    });


    $('.dt-search').prepend(
    '<div class="row align-items-end gx-3 mt-1">' +

        // Filter Tipe
        '<div class="col-md-4 col-lg-2">' +
            '<label for="typeFilter" class="form-label">Status:</label>' +
            '<select id="typeFilter" class="form-control w-100">' +
                '<option value="">All</option>' +
                '<option value="1">Waiting Seller</option>' +
                '<option value="2">Waiting Admin</option>' +
                '<option value="3">Waiting Payment</option>' +
                '<option value="4">Paid</option>' +
                '<option value="5">On Packing</option>' +
                '<option value="6">On Delivery</option>' +
                '<option value="7">Delivered</option>' +
                '<option value="8">Canceled</option>' +
                '<option value="9">Expired</option>' +
            '</select>' +
        '</div>' +

          // Filter Seller (Dropdown bisa dicari)
          '<div class="col-md-4 col-lg-3">' +
                '<select id="sellerFilter" class="form-control text-whitespace-nowrap">' +
                    '<option value="">All Seller</option>' +
                '</select>' +
            '</div>' +

            // Filter Date Range (Lebih luas)
            '<div class="col-md-4 col-lg-4">' +
                '<input type="text" id="dateRange" class="form-control w-100" placeholder="Select date range">' +
            '</div>' +

            // Tombol Filter & Reset (Sejajar di kanan)
            '<div class="col-lg-3 d-flex flex-wrap justify-content-end mt-2 mt-lg-0 gap-2">' +
                '<button id="filterBtn" class="btn btn-primary mr-1">Filter</button>' +
                '<button id="resetBtn" class="btn btn-secondary">Reset</button>' +
            '</div>' +

    '</div>'
);

    // Menghilangkan filter bawaan DataTables
    $('#dt-search-0').addClass('d-none');
    $('label[for="dt-search-0"]').hide();
    $('.dt-length').addClass('mt-2');
    // Inisialisasi Select2 agar dropdown bisa di-search
    $('#sellerFilter').select2({
            placeholder: "Pilih Seller",
            allowClear: true,
            width: '100%' // Pastikan sesuai dengan elemen parent
        });

    $('#sellerFilter').on('change', function() {
        sellerId = $(this).val();
    });
    // Ambil data seller dari API
    $.ajax({
    url: '/admin/get/sellers',  // Ganti dengan API endpoint yang benar
    method: 'GET',
    success: function(data) {
        console.log("Response API Get Sellers: ", data.data);
        let sellerDropdown = $('#sellerFilter');
        data.data.forEach(function(seller) {
            let newOption = new Option(seller.name, seller.id, false, false);
            sellerDropdown.append(newOption);
        });
        sellerDropdown.trigger('change'); // Update Select2 setelah menambahkan opsi
    }
    });

    $('#dateRange').daterangepicker({
        autoUpdateInput: false,
        locale: { cancelLabel: 'Clear' }
    });

    $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
        startDate = picker.startDate.format('YYYY-MM-DD');
        endDate = picker.endDate.format('YYYY-MM-DD');
        $(this).val(startDate + ' - ' + endDate);
    });

    $('#dateRange').on('cancel.daterangepicker', function(ev, picker) {
        startDate = '';
        endDate = '';
        $(this).val('');
    });

    $('#filterBtn').on('click', function() {
        table.ajax.reload();
    });

    $('#resetBtn').on('click', function() {
        $('#typeFilter').val('').trigger('change');
        $('#dateRange').val('');
        startDate = '';
        endDate = '';
        table.ajax.reload();
    });
    
    $('#exportBtn').on('click', function() {
        let status = $('#typeFilter').val();
        let startDate = $('#dateRange').val().split(' - ')[0];
        let endDate = $('#dateRange').val().split(' - ')[1];

        window.location.href = "{{ route('admin.transactions.export') }}?seller_id=" + sellerId + "&status=" + status + "&start_date=" + startDate + "&end_date=" + endDate;
    });
});
</script>
@endsection