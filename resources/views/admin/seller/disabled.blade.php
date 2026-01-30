@extends('__layouts.__admin.main')

@section('body')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Seller Dinonaktifkan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('admin.sellers') }}">Seller</a></div>
                    <div class="breadcrumb-item active">Dinonaktifkan</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="disabledSellerTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Telepon</th>
                                        <th>Action</th>
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
        $('#disabledSellerTable').DataTable({
            ajax: "{{ route('admin.sellers.disabled.list') }}",
            columns: [
                { data: 'no', name: 'no' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' },
            ]
        });

        $('#disabledSellerTable').on('click', '.btn-enable', function() {
            const id = $(this).data('id');
            $.post("{{ url('/admin/sellers') }}/" + id + "/enable", {_token: "{{ csrf_token() }}"}, function(data) {
                Swal.fire({
                    toast: true,
                    icon: data.status === 200 ? 'success' : 'error',
                    title: data.text,
                    position: 'top-end',
                    timer: 2000,
                    showConfirmButton: false
                });
                $('#disabledSellerTable').DataTable().ajax.reload();
            }).fail(function() {
                Swal.fire({ toast: true, icon: 'error', title: 'Gagal mengaktifkan seller', position: 'top-end', timer: 2000, showConfirmButton: false });
            });
        });
    });
</script>
@endsection
