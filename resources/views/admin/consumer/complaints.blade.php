@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Penanganan Komplain</h1>
        </div>

        <div class="section-body">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label>Status</label>
                            <select id="filter-status" class="form-control">
                                <option value="">Semua</option>
                                <option value="eopn">Terbuka</option>
                                <option value="close">Selesai</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Subsektor</label>
                            <select id="filter-subsector" class="form-control">
                                <option value="">Semua</option>
                                @foreach($subsectors as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button id="btn-filter" class="btn btn-primary"><i class="fas fa-sync"></i> Terapkan</button>
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
                                <th>Kode Order</th>
                                <th>Produk</th>
                                <th>Subsektor</th>
                                <th>Seller</th>
                                <th>Konsumen</th>
                                <th>Status</th>
                                <th>Eskalasi</th>
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

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Komplain</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <table class="table table-sm">
            <tr><th>Kode Order</th><td id="det-code"></td></tr>
            <tr><th>Produk</th><td id="det-product"></td></tr>
            <tr><th>Subsektor</th><td id="det-subsector"></td></tr>
            <tr><th>Seller</th><td id="det-seller"></td></tr>
            <tr><th>Konsumen</th><td id="det-customer"></td></tr>
            <tr><th>Komplain</th><td id="det-complain"></td></tr>
            <tr><th>Catatan</th><td><textarea id="det-note" class="form-control" rows="2" placeholder="Catatan / klarifikasi"></textarea></td></tr>
            <tr><th>Keputusan Akhir</th><td><textarea id="det-decision" class="form-control" rows="2" placeholder="Refund/pengiriman ulang/dll"></textarea></td></tr>
            <tr><th>Status</th>
                <td>
                    <select id="det-status" class="form-control">
                        <option value="eopn">Terbuka</option>
                        <option value="close">Selesai</option>
                    </select>
                </td>
            </tr>
            <tr><th>Eskalasi</th><td><input type="checkbox" id="det-escalated"> Tandai untuk eskalasi Admin Master</td></tr>
            <tr><th>Aksi Klarifikasi</th><td><button class="btn btn-success" id="btn-wa-seller"><i class="fab fa-whatsapp"></i> Minta Klarifikasi ke Pelapak</button></td></tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="btn-save">Simpan Keputusan</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
$(function(){
    const table = $('#complaint-table').DataTable({
        processing:true, serverSide:true,
        ajax:{
            url:"{{ route('admin.consumer.complaints.data') }}",
            data: d => {
                d.status = $('#filter-status').val();
                d.subsector = $('#filter-subsector').val();
            }
        },
        columns:[
            {data:'DT_RowIndex', name:'DT_RowIndex', orderable:false, searchable:false},
            {data:'order_code', name:'order_code'},
            {data:'product_name', name:'product_name'},
            {data:'subsector', name:'subsector'},
            {data:'seller_name', name:'seller_name'},
            {data:'customer_name', name:'customer_name'},
            {data:'status_badge', name:'complain_status', orderable:false, searchable:false, className:'text-center'},
            {data:'escalated', name:'escalated', orderable:false, searchable:false, className:'text-center'},
            {data:'action', name:'action', orderable:false, searchable:false, className:'text-center'},
        ]
    });

    $('#btn-filter').on('click', ()=> table.ajax.reload());

    let current = null;
    $('#complaint-table').on('click','.btn-detail', function(){
        const row = $(this).data('row');
        current = row;
        $('#det-code').text(row.order_code || '-');
        $('#det-product').text(row.product_name || '-');
        $('#det-subsector').text(row.subsector || '-');
        $('#det-seller').text(row.seller_name || '-');
        $('#det-customer').text(row.customer_name || '-');
        $('#det-complain').text(row.complain || '-');
        $('#det-note').val(row.complain_note || '');
        $('#det-decision').val(row.complain_final_decision || '');
        $('#det-status').val(row.complain_status || 'eopn');
        $('#det-escalated').prop('checked', row.complain_escalated == 1);
        $('#detailModal').modal('show');
    });

    $('#btn-save').on('click', function(){
        if(!current) return;
        $.post(`{{ url('/admin/consumer/complaints') }}/${current.id}`, {
            _token: '{{ csrf_token() }}',
            complain_status: $('#det-status').val(),
            complain_final_decision: $('#det-decision').val(),
            complain_note: $('#det-note').val(),
            escalated: $('#det-escalated').is(':checked') ? 1 : 0
        }).done(res=>{
            sweetAlertSuccess(res.text || 'Tersimpan');
            $('#detailModal').modal('hide');
            table.ajax.reload(null,false);
        }).fail(xhr=>{
            sweetAlertDanger(xhr.responseJSON?.text || 'Gagal menyimpan');
        });
    });

    $('#btn-wa-seller').on('click', function(){
        if(!current) return;
        let phone = (current.seller_phone || '').replace(/[^0-9]/g,'');
        if(phone.startsWith('0')) phone = '62' + phone.slice(1);
        else if(!phone.startsWith('62')) phone = '62' + phone;
        const msg = encodeURIComponent(`Halo, mohon klarifikasi terkait komplain order ${current.order_code}.`);
        window.open(`https://wa.me/${phone}?text=${msg}`, '_blank');
    });
});
</script>
@endsection
