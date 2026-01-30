@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Verifikasi Pelapak</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('admin.register.dashboard') }}">Dasbor SKPD</a></div>
                <div class="breadcrumb-item active">Verifikasi Pelapak</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped" id="verify-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>OAP</th>
                                <th>Status</th>
                                <th>Dokumen</th>
                                <th>Binaan SKPD</th>
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

<!-- Modal Catatan -->
<div class="modal fade" id="noteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Catatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea id="noteText" class="form-control" rows="4" placeholder="Catatan penolakan atau perbaikan"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSaveNote">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(function(){
    let selectedId = null;
    let selectedAction = null;

    const table = $('#verify-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.register.verify.data') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false},
            {data: 'foto', name: 'foto', orderable:false, searchable:false},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'oap_badge', name: 'oap', orderable:false, searchable:false},
            {data: 'status_badge', name: 'status', orderable:false, searchable:false},
            {data: 'dokumen', name: 'dokumen', orderable:false, searchable:false},
            {data: 'binaan', name: 'binaan', orderable:false, searchable:false},
            {data: 'action', name: 'action', orderable:false, searchable:false},
        ]
    });

    $('#verify-table').on('change', '.toggle-binaan', function(){
        const id = $(this).data('id');
        const binaan = $(this).is(':checked') ? 1 : 0;
        $.post(`{{ url('/admin/register/verify') }}/${id}/binaan`, {
            _token: '{{ csrf_token() }}',
            binaan: binaan
        }).done(res => {
            sweetAlertSuccess(res.text || 'Berhasil');
        }).fail(xhr => {
            sweetAlertDanger(xhr.responseJSON?.text || 'Gagal memperbarui');
            table.ajax.reload(null,false);
        });
    });

    function doAction(id, action, note='') {
        $.post(`{{ url('/admin/register/verify') }}/${id}/action`, {
            _token: '{{ csrf_token() }}',
            action: action,
            note: note
        }).done(res => {
            sweetAlertSuccess(res.text || 'Berhasil');
            table.ajax.reload(null,false);
        }).fail(xhr => {
            sweetAlertDanger(xhr.responseJSON?.text || 'Gagal memproses');
        });
    }

    $('#verify-table').on('click', '.btn-approve', function(){
        const id = $(this).data('id');
        doAction(id, 'approve');
    });

    $('#verify-table').on('click', '.btn-revise', function(){
        selectedId = $(this).data('id');
        selectedAction = 'revise';
        $('#noteText').val('');
        $('#noteModal').modal('show');
    });

    $('#verify-table').on('click', '.btn-reject', function(){
        selectedId = $(this).data('id');
        selectedAction = 'reject';
        $('#noteText').val('');
        $('#noteModal').modal('show');
    });

    $('#btnSaveNote').on('click', function(){
        const note = $('#noteText').val();
        if (!selectedId || !selectedAction) return;
        doAction(selectedId, selectedAction, note);
        $('#noteModal').modal('hide');
        selectedId = null;
        selectedAction = null;
    });
});
</script>
@endsection
