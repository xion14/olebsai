@extends('__layouts.__admin.main')

@section('body')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Seller Confirmation</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Admin</a></div>
                    <div class="breadcrumb-item"><a href="#">Seller</a></div>
                    <div class="breadcrumb-item active"><a href="#">Confirmation</a></div>
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
@endsection

@section('script')
    <div class="modal fade" tabindex="-1" role="dialog" id="rejectModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5">Reject Seller</h4>
                    <button type="button" class="close" data-dismiss="modal">
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
            let seller_id = 0;
            var table = registerDatatables({
                element: $('#sellerTable'),
                url: "{{ route('admin.sellers.confirmation') }}",
                columns: [{
                        data: 'no',
                        name: 'no'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        searchable: true
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

            $("#sellerTable").on("click", '.btn-reject', function() {
                seller_id = $(this).data('id');
                $('#note').val('');
                $('#rejectModal').modal('show');
            });

            $("#sellerTable").on("click", '.btn-accept', function() {
                seller_id = $(this).data('id');
                return new Promise((resolve, reject) => {
                    let data = {
                        _token: '{{ csrf_token() }}',
                    };

                    $.ajax({
                        url: '{{ route('admin.sellers.accept', ':id') }}'.replace(':id',
                            seller_id),
                        method: 'POST',
                        data: data,
                        success: function(response) {
                            sweetAlertSuccess(response.text);
                            table.ajax.reload(null, false);
                        },
                        error: function(xhr) {
                            reject(xhr);
                        }
                    });
                });
            });

            function processForm(id, note) {
                return new Promise((resolve, reject) => {
                    let data = {
                        _token: '{{ csrf_token() }}',
                        note: note,
                    };

                    $.ajax({
                        url: '{{ route('admin.sellers.reject', ':id') }}'.replace(':id', seller_id),
                        method: 'POST',
                        data: data,
                        success: function(response) {
                            resolve(response);
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;

                                for (let field in errors) {
                                    let input = $(`[name="${field}"]`);
                                    input.addClass('is-invalid');
                                    input.after(
                                        `<div class="invalid-feedback">${errors[field][0]}</div>`
                                    );
                                }
                            }
                            reject(xhr);
                        }
                    });
                });
            }

            $('#rejectForm').on('submit', function(e) {
                e.preventDefault();
                let note = $('#note').val();

                processForm(seller_id, note)
                    .then(response => {
                        $('#note').val('');
                        seller_id = 0;
                        $('#rejectModal').modal('hide');
                        if (response.status === 200) {
                            sweetAlertSuccess(response.text);
                            table.ajax.reload(null, false);
                        } else if (response.status === 400) {
                            sweetAlertDanger(response.text);
                        }
                    })
                    .catch(error => {
                        console.error('Terjadi Masalah:', error);
                    });
            });
        });
    </script>
@endsection
