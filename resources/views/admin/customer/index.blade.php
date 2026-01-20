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

    {{-- Modal Reset Password Start --}}
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="staticBackdropLabel">Reset Password</h3>
                    <button type="button" class="btn btn-close-modal btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="w-100 mt-3">
                        <div class="row">
                            <div class="col-md-12 position-relative">
                                <label for="reset-password-customer" class="form-label">
                                    Password
                                </label>
                                <input type="password" id="reset-password-customer" class="form-control"
                                    placeholder="Masukkan password baru" autocomplete="off" required>
                                <button id="showPassword" type="button" class="btn p-0 m-0"
                                    style="border: none; background-color: transparent; position: absolute; top: 40px; right: 24px;">
                                    <i class="fas fa-eye-slash" style="font-size: 16px;"></i>
                                </button>
                                <button id="hidePassword" type="button" class="d-none btn p-0 m-0"
                                    style="border: none; background-color: transparent; position: absolute; top: 40px; right: 24px;">
                                    <i class="fas fa-eye" style="font-size: 16px;"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-close-modal btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" class="btn btn-submit-pw btn-primary">
                        Reset Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Reset Password End --}}
@endsection


@section('script')
    <script>
        $(document).ready(function() {
            let customer_id = 0;
            var table = registerDatatables({
                element: $('#customerTable'),
                url: "{{ route('admin.customers.index') }}",
                columns: [{
                        data: 'no',
                        name: 'no',
                        className: 'text-center align-middle'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        searchable: true,
                        className: 'align-middle'
                    },
                    {
                        data: 'email',
                        name: 'email',
                        searchable: true,
                        className: 'align-middle'
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        searchable: true,
                        className: 'text-center align-middle'
                    },
                    {
                        data: 'birthday',
                        name: 'birthday',
                        searchable: true,
                        className: 'text-center align-middle'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        orderable: false,
                        className: 'text-center align-middle'
                    }
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

            function toasMessage(icon, title) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: icon,
                    title: title
                });
            }

            $('#customerTable').on('click', '.btn-edit', function() {
                customer_id = $(this).data('id');
                window.location.href = "{{ route('admin.customers.show', ':id') }}".replace(':id',
                    customer_id);
            });


            $('#customerTable').on('click', '.btn-disable', function() {
                let id = $(this).data('id');
                const form = $(`#delete-form-${id}`);
                Swal.fire({
                    title: "Disable Customer?",
                    text: "Are you sure you want to disable this customer?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Approve",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post("{{ url('/admin/customers') }}/" + id + "/disable", {
                            _token: "{{ csrf_token() }}"
                        }, function(data) {
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

            $('#customerTable').on('click', '.btn-reset-password', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: "Reset Password?",
                    text: "Apakah kamu yakin ingin mengatur ulang password ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Reset!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tampil modal reset password
                        $('#staticBackdrop').modal('show');
                        $('#reset-password-customer').attr('type', 'password');
                        $('#hidePassword').addClass('d-none');
                        $('#showPassword').removeClass('d-none');
                        customer_id = id;
                    }
                });
            });

            $('#showPassword').on('click', function() {
                $('#reset-password-customer').attr('type', 'text');
                $('#hidePassword').removeClass('d-none');
                $('#showPassword').addClass('d-none');
            });

            $('#hidePassword').on('click', function() {
                $('#reset-password-customer').attr('type', 'password');
                $('#hidePassword').addClass('d-none');
                $('#showPassword').removeClass('d-none');
            });

            $(document).on('click', '.btn-close-modal', function() {
                $('#staticBackdrop').modal('hide');
                $('#reset-password-customer').val('');
                customer_id = 0;
            });

            $(document).on('click', '.btn-submit-pw', function () {

                let valueNewPassword = $('#reset-password-customer').val();

                if (customer_id == 0) {
                    Swal.fire({
                        icon: "warning",
                        title: "ID Customer Tidak Ditemukan!",
                        text: "Mohon keluar dari modal dan coba lagi",
                        showConfirmButton: false,
                        timer: 2500
                    });
                    return;
                }

                if (!valueNewPassword || valueNewPassword.trim() === '') {
                    Swal.fire({
                        icon: "warning",
                        title: "Password Kosong",
                        text: "Password tidak boleh kosong, harap diisi terlebih dahulu",
                        showConfirmButton: false,
                        timer: 2500
                    });
                    return;
                }

                // Tampilkan loading
                Swal.fire({
                    title: 'Sedang memproses...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.post("{{ url('/admin/customers') }}/" + customer_id + "/reset-password", {
                    _token: "{{ csrf_token() }}",
                    password: valueNewPassword
                }, function (data) {
                    Swal.close(); // Tutup loading

                    if (data.status === 400) {
                        toasMessage('error', data.text);
                        return;
                    }

                    toasMessage('success', 'Password berhasil diatur ulang');
                    $('#reset-password-customer').val('');
                    customer_id = 0;
                    $('#staticBackdrop').modal('hide');
                    $('.table').DataTable().ajax.reload();
                }).fail(function () {
                    Swal.close(); // Tutup loading meskipun gagal
                    toasMessage('error', 'Terjadi kesalahan saat menghubungi server.');
                });
            });
        });

    </script>
@endsection
