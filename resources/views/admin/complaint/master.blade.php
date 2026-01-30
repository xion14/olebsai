@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pusat Komplain (Master)</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active">Pusat Komplain</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select id="filter-status" class="form-control">
                                <option value="">Semua</option>
                                @foreach($statuses as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tag Kasus</label>
                            <select id="filter-tag" class="form-control">
                                <option value="">Semua</option>
                                @foreach($tags as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button id="btn-refresh" class="btn btn-primary"><i class="fas fa-sync"></i> Refresh</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped" id="complaint-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode Transaksi</th>
                                <th>Produk</th>
                                <th>Seller</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Tag</th>
                                <th>Dikomplain</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Detail / Override -->
<div class="modal fade" id="complaintModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Komplain</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <dl class="row" id="detail-body"></dl>
                <hr>
                <form id="override-form">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Status</label>
                            <select name="status" id="ov-status" class="form-control">
                                <option value="eopn">Terbuka</option>
                                <option value="close">Ditutup</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Tag Kasus</label>
                            <select name="tag" id="ov-tag" class="form-control">
                                <option value="">-</option>
                                @foreach($tags as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea name="note" id="ov-note" rows="3" class="form-control" placeholder="Catatan atau keputusan override"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-save-override">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function(){
    const table = $('#complaint-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.complaints.master.data') }}",
            data: function(d){
                d.status = $('#filter-status').val();
                d.tag    = $('#filter-tag').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false},
            {data: 'transaction_code', name: 'transaction_code'},
            {data: 'product_name', name: 'product_name'},
            {data: 'seller_name', name: 'seller_name'},
            {data: 'customer_name', name: 'customer_name'},
            {data: 'status_badge', name: 'status_badge', orderable:false, searchable:false, className:'text-center'},
            {data: 'tag', name: 'tag', orderable:false},
            {data: 'complained_at_fmt', name: 'complained_at', orderable:false},
            {data: 'action', name: 'action', orderable:false, searchable:false, className:'text-center'}
        ]
    });

    $('#filter-status, #filter-tag').on('change', function(){ table.ajax.reload(); });
    $('#btn-refresh').on('click', function(){ table.ajax.reload(); });

    let selectedId = null;

    $('#complaint-table').on('click', '.btn-detail', function(){
        const data = $(this).data();
        selectedId = data.id;
        const body = `
            <dt class="col-sm-4">Kode Transaksi</dt><dd class="col-sm-8">${data.code || '-'}</dd>
            <dt class="col-sm-4">Produk</dt><dd class="col-sm-8">${data.product || '-'}</dd>
            <dt class="col-sm-4">Seller</dt><dd class="col-sm-8">${data.seller || '-'}</dd>
            <dt class="col-sm-4">Customer</dt><dd class="col-sm-8">${data.customer || '-'}</dd>
            <dt class="col-sm-4">Komplain</dt><dd class="col-sm-8">${data.complain || '-'}</dd>
        `;
        $('#detail-body').html(body);
        $('#ov-status').val(data.status || 'eopn');
        $('#ov-tag').val(data.tag || '');
        $('#ov-note').val(data.note || '');
        $('#complaintModal').modal('show');
    });

    $('#btn-save-override').on('click', function(){
        if(!selectedId) return;
        const payload = {
            _token: '{{ csrf_token() }}',
            status: $('#ov-status').val(),
            tag: $('#ov-tag').val(),
            note: $('#ov-note').val()
        };
        $.post(`{{ url('/admin/complaints/master') }}/${selectedId}/override`, payload)
            .done(function(res){
                sweetAlertSuccess(res.text || 'Tersimpan');
                $('#complaintModal').modal('hide');
                table.ajax.reload(null,false);
            })
            .fail(function(xhr){
                sweetAlertDanger(xhr.responseJSON?.text || 'Gagal menyimpan');
            });
    });
});
</script>
@endsection
