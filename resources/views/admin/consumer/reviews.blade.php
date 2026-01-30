@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pengawasan Ulasan & Penyalahgunaan</h1>
        </div>

        <div class="section-body">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
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
                    <table class="table table-striped" id="review-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order</th>
                                <th>Produk</th>
                                <th>Subsektor</th>
                                <th>Seller</th>
                                <th>Konsumen</th>
                                <th>Ulasan</th>
                                <th>Flag</th>
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
<div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Ulasan</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <table class="table table-sm">
            <tr><th>Order</th><td id="rev-order"></td></tr>
            <tr><th>Produk</th><td id="rev-product"></td></tr>
            <tr><th>Subsektor</th><td id="rev-subsector"></td></tr>
            <tr><th>Seller</th><td id="rev-seller"></td></tr>
            <tr><th>Konsumen</th><td id="rev-customer"></td></tr>
            <tr><th>Ulasan</th><td id="rev-text"></td></tr>
            <tr><th>Catatan</th><td><textarea id="rev-note" class="form-control" rows="2" placeholder="Catatan untuk Admin User/Pelapak"></textarea></td></tr>
            <tr><th>Flag</th><td><input type="checkbox" id="rev-flag"> Tandai ulasan ini</td></tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="btn-save-flag">Simpan</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
$(function(){
    const table = $('#review-table').DataTable({
        processing:true, serverSide:true,
        ajax:{
            url:"{{ route('admin.consumer.reviews.data') }}",
            data:d=>{
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
            {data:'review', name:'review'},
            {data:'flagged', name:'flagged', orderable:false, searchable:false, className:'text-center'},
            {data:'action', name:'action', orderable:false, searchable:false, className:'text-center'},
        ]
    });

    $('#btn-filter').on('click', ()=> table.ajax.reload());

    let current = null;
    $('#review-table').on('click', '.btn-detail', function(){
        const row = $(this).data('row');
        current = row;
        $('#rev-order').text(row.order_code || '-');
        $('#rev-product').text(row.product_name || '-');
        $('#rev-subsector').text(row.subsector || '-');
        $('#rev-seller').text(row.seller_name || '-');
        $('#rev-customer').text(row.customer_name || '-');
        $('#rev-text').text(row.review || '-');
        $('#rev-note').val(row.review_flag_note || '');
        $('#rev-flag').prop('checked', row.review_flagged == 1);
        $('#reviewModal').modal('show');
    });

    $('#btn-save-flag').on('click', function(){
        if(!current) return;
        $.post(`{{ url('/admin/consumer/reviews') }}/${current.id}/flag`, {
            _token: '{{ csrf_token() }}',
            flagged: $('#rev-flag').is(':checked') ? 1 : 0,
            note: $('#rev-note').val()
        }).done(res=>{
            sweetAlertSuccess(res.text || 'Tersimpan');
            $('#reviewModal').modal('hide');
            table.ajax.reload(null,false);
        }).fail(xhr=>{
            sweetAlertDanger(xhr.responseJSON?.text || 'Gagal menyimpan');
        });
    });
});
</script>
@endsection
