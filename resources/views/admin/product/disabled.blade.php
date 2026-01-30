@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Produk Dinonaktifkan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('admin.products') }}">Produk</a></div>
                <div class="breadcrumb-item active">Dinonaktifkan</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="disabledProductsTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Seller</th>
                                    <th>Kategori</th>
                                    <th>Unit</th>
                                    <th>Aksi</th>
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
    const table = $('#disabledProductsTable').DataTable({
        ajax: "{{ route('admin.products.disabled.list') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'code', name: 'code' },
            { data: 'name', name: 'name' },
            { data: 'seller', name: 'seller', orderable: false, searchable: false },
            { data: 'category', name: 'category', orderable: false, searchable: false },
            { data: 'unit', name: 'unit', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' },
        ]
    });

    $('#disabledProductsTable').on('click', '.btn-enable', function() {
        const id = $(this).data('id');
        $.post("{{ url('/admin/products') }}/" + id + "/enable", {_token: "{{ csrf_token() }}"}, function(data) {
            Swal.fire({toast:true, icon: data.status === 200 ? 'success':'error', title: data.text, timer:2000, showConfirmButton:false, position:'top-end'});
            table.ajax.reload();
        }).fail(function(){
            Swal.fire({toast:true, icon:'error', title:'Gagal mengaktifkan produk', timer:2000, showConfirmButton:false, position:'top-end'});
        });
    });
});
</script>
@endsection
