@extends('__layouts.__admin.main')

@section('body')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Customer</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Admin</a></div>
                    <div class="breadcrumb-item"><a href="#">Customer</a></div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="customerTable" class="table table-striped table-bordered table-hover my-4">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th width="5%" class="text-center align-middle">#</th>
                                                <th class="text-center align-middle">Name</th>
                                                <th class="text-center align-middle">Email</th>
                                                <th class="text-center align-middle">Phone</th>
                                                <th class="text-center align-middle">Birthday</th>
                                                <th width="20%" class="text-center align-middle">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- Data dari datatables akan masuk di sini --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
            let customer_id = 0;
            var table = registerDatatables({
                element: $('#customerTable'),
                url: "{{ route('admin.customers.disabled') }}",
                columns: [
                    { data: 'no', name: 'no', className: 'text-center align-middle' },
                    { data: 'name', name: 'name', searchable: true, className: 'align-middle' },
                    { data: 'email', name: 'email', searchable: true, className: 'align-middle' },
                    { data: 'phone', name: 'phone', searchable: true, className: 'text-center align-middle' },
                    { data: 'birthday', name: 'birthday', searchable: true, className: 'text-center align-middle' },
                    { data: 'action', name: 'action', searchable: false, orderable: false, className: 'text-center align-middle' }
                ],
                language: {
                    paginate: {
                        previous: "<i class='fas fa-chevron-left'></i>",
                        next: "<i class='fas fa-chevron-right'></i>",
                        first: "<i class='fas fa-angle-double-left'></i>",
                        last: "<i class='fas fa-angle-double-right'></i>"
                    }
                },
            });

            $('#customerTable').on('click', '.btn-edit', function() {
                customer_id = $(this).data('id');
                window.location.href = "{{ route('admin.customers.show', ':id') }}".replace(':id', customer_id);
            });


            $('#customerTable').on('click', '.btn-active', function () {
                let id = $(this).data('id');
                const form = $(`#delete-form-${id}`);
                Swal.fire({
                title: "Activated Customer?",
                text: "Are you sure you want to activated this customer?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, Approve",
                cancelButtonText: "Cancel"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.post("{{ url('/admin/customers') }}/" + id + "/enable", {
                    _token: "{{ csrf_token() }}"
                    }, function (data) {
                    Swal.fire({
                        title: 'Success!',
                        text: data.text,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $('.table').DataTable().ajax.reload();
                    });
                    });
                }
                });
            });
        });
    </script>
@endsection
