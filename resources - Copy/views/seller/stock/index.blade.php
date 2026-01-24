@extends('__layouts.__seller.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1 id="title"></h1>
            <div class="section-header-breadcrumb">
            <form action="{{ route('seller.stock.export') }}" method="GET">
                <button type="submit" class="btn btn-primary mr-1 col-sm-12">
                    <i class="fas fa-download"></i> Export
                </button>
            </form>
            </div>
          </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="stockTable" class="table table-striped" id="table-1">
                        <thead>                                 
                        <tr>
                            <th width="5%" class="text-center">#</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Unit</th>
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

@section('script')
<script>
$(document).ready(function() {
    $('#title').html("Report Stock");
    var table = $('#stockTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('seller.stock') }}",
            type: "GET",
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false ,className: 'align-middle text-center'},
            { data: 'name', name: 'name', searchable: true ,className: 'align-middle text-center'},
            { data: 'stock', name: 'stock', searchable: true , className: 'align-middle text-center'},
            { data: 'unit', name: 'unit', searchable: true ,className: 'align-middle text-center' },
        ]
    });
});

      
</script>
@endsection
