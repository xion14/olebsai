@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Catatan Pembinaan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('admin.register.dashboard') }}">Dasbor SKPD</a></div>
                <div class="breadcrumb-item active">Catatan Pembinaan</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card mb-3">
                <div class="card-header"><h4>Input Catatan</h4></div>
                <div class="card-body">
                    <form id="coachingForm" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Pelapak</label>
                                <select class="form-control" name="seller_id" id="seller_id" required>
                                    <option value="">Pilih Pelapak</option>
                                    @foreach($sellers as $s)
                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Jenis</label>
                                <select class="form-control" name="type" id="type" required>
                                    <option value="pelatihan">Pelatihan</option>
                                    <option value="bantuan">Bantuan Alat/Dana</option>
                                    <option value="pendampingan_kur">Pendampingan KUR</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Tanggal</label>
                                <input type="date" class="form-control" name="coaching_date" id="coaching_date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" class="form-control" name="title" id="title" required>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea class="form-control" rows="3" name="description" id="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Lampiran (PDF/JPG/PNG)</label>
                            <input type="file" class="form-control" name="attachment" id="attachment" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h4>Riwayat Pembinaan</h4></div>
                <div class="card-body table-responsive">
                    <table class="table table-striped" id="coachingTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Pelapak</th>
                                <th>Jenis</th>
                                <th>Judul</th>
                                <th>Tanggal</th>
                                <th>Lampiran</th>
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
$(function(){
    const table = $('#coachingTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.register.coaching.data') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false},
            {data: 'seller_name', name: 'seller_name'},
            {data: 'type_label', name: 'type'},
            {data: 'title', name: 'title'},
            {data: 'coaching_date', name: 'coaching_date'},
            {data: 'attachment_link', name: 'attachment', orderable:false, searchable:false},
        ]
    });

    $('#coachingForm').on('submit', function(e){
        e.preventDefault();
        let formData = new FormData(this);
        formData.append('_token', '{{ csrf_token() }}');
        $.ajax({
            url: "{{ route('admin.register.coaching.store') }}",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res){
                sweetAlertSuccess(res.text || 'Tersimpan');
                $('#coachingForm')[0].reset();
                table.ajax.reload(null,false);
            },
            error: function(xhr){
                sweetAlertDanger(xhr.responseJSON?.message || xhr.responseJSON?.text || 'Gagal menyimpan');
            }
        });
    });
});
</script>
@endsection
