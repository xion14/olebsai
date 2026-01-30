@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Pelapak & Toko (Pandangan Sistem)</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('admin.sellers') }}">Seller</a></div>
                <div class="breadcrumb-item active">Data Pelapak & Toko</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card mb-3">
                <div class="card-body">
                    <form id="filter-form" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">OAP</label>
                            <select id="oap" class="form-control">
                                <option value="">Semua</option>
                                <option value="yes">OAP</option>
                                <option value="no">Non OAP</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Subsektor</label>
                            <select id="subsector" class="form-control">
                                <option value="">Semua</option>
                                @foreach($subsectors as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Kota/Kabupaten</label>
                            <select id="city" class="form-control">
                                <option value="">Semua</option>
                                @foreach($cities as $c)
                                    <option value="{{ $c }}">{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped" id="master-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>OAP</th>
                                <th>Kota</th>
                                <th>Subsektor</th>
                                <th>Total Produk</th>
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
@endsection

@section('script')
<script>
    $(document).ready(function() {
        const table = $('#master-table').DataTable({
            ajax: {
                url: "{{ route('admin.sellers.master.data') }}",
                data: function(d) {
                    d.oap = $('#oap').val();
                    d.subsector = $('#subsector').val();
                    d.city = $('#city').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'oap_badge', name: 'oap', orderable:false, searchable:false, className:'text-center' },
                { data: 'city', name: 'city' },
                { data: 'subsectors', name: 'subsectors', orderable:false },
                { data: 'total_products', name: 'total_products' },
                { data: 'action', name: 'action', orderable:false, searchable:false, className:'text-center' },
            ]
        });

        $('#filter-form select').on('change', function(){ table.ajax.reload(); });

        $('#master-table').on('click', '.btn-block-seller', function(){
            const id = $(this).data('id');
            Swal.fire({
                title: 'Blokir pelapak?',
                text: 'Pelapak akan dinonaktifkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, blokir'
            }).then(res => {
                if(res.isConfirmed){
                    $.post(`{{ url('/admin/sellers') }}/${id}/force-block`, {_token:'{{ csrf_token() }}'}, function(rs){
                        Swal.fire({toast:true,icon: rs.status===200?'success':'error',title:rs.text, timer:2000, showConfirmButton:false, position:'top-end'});
                        table.ajax.reload(null,false);
                    }).fail(()=>Swal.fire({toast:true,icon:'error',title:'Gagal blokir',timer:2000,showConfirmButton:false, position:'top-end'}));
                }
            });
        });

        $('#master-table').on('click', '.btn-unblock-seller', function(){
            const id = $(this).data('id');
            $.post(`{{ url('/admin/sellers') }}/${id}/force-unblock`, {_token:'{{ csrf_token() }}'}, function(rs){
                Swal.fire({toast:true,icon: rs.status===200?'success':'error',title:rs.text, timer:2000, showConfirmButton:false, position:'top-end'});
                table.ajax.reload(null,false);
            }).fail(()=>Swal.fire({toast:true,icon:'error',title:'Gagal mengaktifkan',timer:2000,showConfirmButton:false, position:'top-end'}));
        });

        $('#master-table').on('click', '.btn-detail', function(){
            const data = $(this).data();
            let html = `<dl class="row text-left mb-0">`
                + `<dt class="col-4">Nama</dt><dd class="col-8">${data.name||''}</dd>`
                + `<dt class="col-4">Email</dt><dd class="col-8">${data.email||''}</dd>`
                + `<dt class="col-4">Telepon</dt><dd class="col-8">${data.phone||''}</dd>`
                + `<dt class="col-4">OAP</dt><dd class="col-8">${data.oap==='yes'?'OAP':'Non OAP'}</dd>`
                + `<dt class="col-4">Kota</dt><dd class="col-8">${data.city||''}</dd>`
                + `<dt class="col-4">Provinsi</dt><dd class="col-8">${data.province||''}</dd>`
                + `<dt class="col-4">Subsektor</dt><dd class="col-8">${data.subsectors||'-'}</dd>`
                + `<dt class="col-4">Total Produk</dt><dd class="col-8">${data.products||0}</dd>`
                + (() => {
                    const doc = data.document;
                    if (doc) {
                        const url = `{{ asset('storage') }}/${doc}`;
                        return `<dt class="col-4">Dokumen</dt><dd class="col-8"><a href="${url}" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-file"></i> Lihat</a></dd>`;
                    }
                    return `<dt class="col-4">Dokumen</dt><dd class="col-8 text-muted">Tidak ada</dd>`;
                  })()
                + `</dl>`;
            Swal.fire({title:'Detail Pelapak', html: html, icon:'info'});
        });
    });
</script>
@endsection
