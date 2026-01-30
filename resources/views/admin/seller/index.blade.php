@extends('__layouts.__admin.main')

@section('body')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Seller</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Admin</a></div>
                    <div class="breadcrumb-item"><a href="#">Seller</a></div>
                    <div class="breadcrumb-item active"><a href="#">Registrations</a></div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="sellerTable" class="table table-striped my-4" id="table-1">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">#</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Email</th>
                                                <th class="text-center">Tax Number</th>
                                                <th class="text-center">Business Number</th>
                                                <th class="text-center">Phone</th>
                                                <th class="text-center">Location</th>
                                                <th width="20%" class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
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
                                <label for="reset-password-seller" class="form-label">
                                    Password
                                </label>
                                <input type="password" id="reset-password-seller" class="form-control"
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
    <div class="modal fade" tabindex="-1" role="dialog" id="rejectModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5">Reject Seller</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="rejectForm">
                        <div class="mb-3">
                            <label for="note" class="form-label">Note</label>
                            <textarea name="note" id="note" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" form="rejectForm">Reject <i
                            class="ti ti-send"></i></button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.page-link.previous').html("<i class='fas fa-chevron-left'></i>");

            var table = registerDatatables({
                element: $('#sellerTable'),
                url: "{{ route('admin.sellers') }}",
                columns: [{
                        data: 'no',
                        name: 'no'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        searchable: true,
                    },
                    {
                        data: 'email',
                        name: 'email',
                        searchable: true
                    },
                    {
                        data: 'tax_number',
                        name: 'tax_number',
                        searchable: true
                    },
                    {
                        data: 'business_number',
                        name: 'business_number',
                        searchable: true
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        searchable: true
                    },
                    {
                        data: 'location',
                        name: 'location',
                        searchable: true
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        orderable: false,
                        className: 'text-center'
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

        $('#sellerTable').on('click', '.btn-reset-password', function() {
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
                        $('#reset-password-seller').attr('type', 'password');
                        $('#hidePassword').addClass('d-none');
                        $('#showPassword').removeClass('d-none');
                        seller_id = id;
                    }
                });
            });

            $('#showPassword').on('click', function() {
                $('#reset-password-seller').attr('type', 'text');
                $('#hidePassword').removeClass('d-none');
                $('#showPassword').addClass('d-none');
            });

            $('#hidePassword').on('click', function() {
                $('#reset-password-seller').attr('type', 'password');
                $('#hidePassword').addClass('d-none');
                $('#showPassword').removeClass('d-none');
            });

            $(document).on('click', '.btn-close-modal', function() {
                $('#staticBackdrop').modal('hide');
                $('#reset-password-seller').val('');
                seller_id = 0;
            });

            $(document).on('click', '.btn-submit-pw', function () {

                let valueNewPassword = $('#reset-password-seller').val();

                if (seller_id == 0) {
                    Swal.fire({
                        icon: "warning",
                        title: "ID Seller Tidak Ditemukan!",
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

                $.post("{{ url('/admin/sellers') }}/" + seller_id + "/reset-password", {
                    _token: "{{ csrf_token() }}",
                    password: valueNewPassword
                }, function (data) {
                    Swal.close(); // Tutup loading

                    if (data.status === 400) {
                        toasMessage('error', data.text);
                        return;
                    }

                    toasMessage('success', 'Password berhasil diatur ulang');
                    $('#reset-password-seller').val('');
                    seller_id = 0;
                    $('#staticBackdrop').modal('hide');
                    $('.table').DataTable().ajax.reload();
                }).fail(function () {
                    Swal.close(); // Tutup loading meskipun gagal
                    toasMessage('error', 'Terjadi kesalahan saat menghubungi server.');
                });
            });

        

        // $(document).on('click', '.btn-reset-password', function () {
        //     let sellerId = $(this).data('id');
        //     Swal.fire({
        //         title: "Reset Password?",
        //         text: "Apakah Anda yakin ingin mereset password seller ini?",
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#3085d6",
        //         cancelButtonColor: "#d33",
        //         confirmButtonText: "Ya, Reset!",
        //         cancelButtonText: "Batal"
        //     }).then((result) => {
        //         if (result.isConfirmed) {

        //             // Tampilkan loading
        //             Swal.fire({
        //                 title: 'Memproses...',
        //                 text: 'Mohon tunggu sebentar.',
        //                 allowOutsideClick: false,
        //                 allowEscapeKey: false,
        //                 didOpen: () => {
        //                     Swal.showLoading();
        //                 }
        //             });

        //             $.ajax({
        //                 url: "{{ route('admin.sellers.reset-password', ':id') }}".replace(':id', sellerId),
        //                 type: 'POST',
        //                 data: {
        //                     _token: $('meta[name="csrf-token"]').attr('content')
        //                 },
        //                 success: function (response) {
        //                     Swal.close(); // Tutup loading
        //                     Swal.fire({
        //                         title: "Berhasil!",
        //                         text: response.text,
        //                         icon: "success",
        //                         confirmButtonColor: "#3085d6",
        //                         timer: 2000,
        //                         showConfirmButton: false
        //                     });
        //                 },
        //                 error: function () {
        //                     Swal.close(); // Tutup loading
        //                     Swal.fire({
        //                         title: "Gagal!",
        //                         text: "Terjadi kesalahan, coba lagi.",
        //                         icon: "error",
        //                         confirmButtonColor: "#d33"
        //                     });
        //                 }
        //             });
        //         }
        //     });
        // });
    });
    </script>
@endsection
