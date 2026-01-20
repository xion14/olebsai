@extends('__layouts.__seller.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1 id="title">Balance History</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#" id="breadcrumb-1">Balance</a></div>
                <div class="breadcrumb-item"><a href="#" id="breadcrumb-2">History</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="row mt-4 g-3">
                    <div class="col-md-4">
                        <div class="card shadow card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-arrow-down"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h6>IN</h6>
                                </div>
                                <div class="card-body">
                                    <h5 class="fw-bold" id="balance_in">Rp 0</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- OUT -->
                    <div class="col-md-4">
                        <div class="card shadow card-statistic-1">
                            <div class="card-icon bg-danger">
                                <i class="fas fa-arrow-up"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h6>OUT</h6>
                                </div>
                                <div class="card-body">
                                    <h5 class="fw-bold" id="balance_out">Rp 0</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TOTAL -->
                    <div class="col-md-4">
                        <div class="card shadow card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h6>TOTAL</h6>
                                </div>
                                <div class="card-body">
                                    <h5 class="fw-bold" id="total_balance">Rp 0</h5>
                                </div>
                            </div>
                        </div>
                    </div>



                    </div>
                
                    <div class="table-responsive">
                        
                        <table id="balanceTable" class="table table-striped mt-3">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">#</th>
                                    <th class="text-center">Transaction Number</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">DateTime</th>
                                    <!-- <th width="20%" class="text-center">Actions</th> -->
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


    var table = $('#balanceTable').DataTable({
        processing: true,
        serverSide: true,
        // searching: false,
        ajax: {
            url: "{{ route('seller.balance') }}",
            type: "GET",
            data: function(d) {
                d.type = $('#typeFilter').val();
                d.start_date = startDate;
                d.end_date = endDate;
            },
            complete: function (response) {
                // Ambil data balance dari response
                let balance_in = response.responseJSON.balance_in || "Rp 0";
                let balance_out = response.responseJSON.balance_out || "Rp 0";
                let total_balance = response.responseJSON.total_balance || "Rp 0";

                // Update tampilan balance di frontend
                $('#balance_in').text(balance_in);
                $('#balance_out').text(balance_out);
                $('#total_balance').text(total_balance);
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false, className: 'align-middle text-center' },
            { 
                data: 'transaction_code', 
                name: 'transaction_code', 
                searchable: true, 
                className: 'align-middle text-center',
                render: function(data, type, row) {
                    if (row.type == 'in') {
                        return data ? `<span class="badge bg-success text-white">${data}</span>` : '-';
                    }else{
                        return data ? `<span class="badge bg-danger text-white">${data}</span>` : '-';
                    }
                    ;
                }
            },

            { data: 'amount', name: 'amount', searchable: true, className: 'align-middle text-center' },
            { 
                data: 'type', 
                name: 'type', 
                searchable: true, 
                className: 'align-middle text-center',
                render: function(data) {
                    return data === 'in' ? '<span class="badge badge-success">IN</span>' :
                           data === 'out' ? '<span class="badge badge-danger">OUT</span>' : data;
                }
            },
            { data: 'updated_at', name: 'updated_at', searchable: true, className: 'align-middle text-center' },
            // { data: 'action', name: 'action', searchable: false, orderable: false, className: 'align-middle text-center' }
        ]
    });


    $('.dt-search').prepend(
    '<div class="row align-items-end mt-1">' +

        // Filter Tipe
        '<div class="col-md-6 col-lg-3">' +
            '<label for="typeFilter" class="form-label">Type:</label>' +
            '<select id="typeFilter" class="form-control w-100">' +
                '<option value="">All</option>' +
                '<option value="in">In</option>' +
                '<option value="out">Out</option>' +
            '</select>' +
        '</div>' +

        // Perbesar Filter Date Range
        '<div class="col-md-6 col-lg-6">' +
            '<label for="dateRange" class="form-label ml-2">Date Range:</label>' +
            '<input type="text" id="dateRange" class="form-control w-100" placeholder="Select date range">' +
        '</div>' +

        // Tombol Filter & Reset (Sejajar di kanan)
        '<div class="col-lg-3 d-flex justify-content-end mt-2 mt-lg-0 gap-2">' +
            '<button id="filterBtn" class="btn btn-primary mr-2">Filter</button>' +
            '<button id="resetBtn" class="btn btn-secondary">Reset</button>' +
        '</div>' +

    '</div>'
);

    // Menghilangkan filter bawaan DataTables
    $('#dt-search-0').addClass('d-none');
    $('label[for="dt-search-0"]').hide();
    $('.dt-length').addClass('mt-2');

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
});
</script>
@endsection