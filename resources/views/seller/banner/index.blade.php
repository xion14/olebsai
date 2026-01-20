@extends('__layouts.__seller.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Banners</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#">Seller</a></div>
                <div class="breadcrumb-item active"><a href="#">Banners</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <button class="btn btn-primary d-none" id="create_btn"><i class="fas fa-plus"></i> Create</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="bannerTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">#</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Link</th>
                                            <th class="text-center">Image</th>
                                            <th class="text-center">Status</th>
                                            <th width="20%" class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Form -->
    <div class="modal fade" tabindex="-1" role="dialog" id="bannerModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5">Create Banner</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="bannerForm">
                        @csrf
                        <input type="hidden" name="_method" value="POST" id="formMethod">
                        <input type="hidden" name="id" id="banner_id">

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Banner Title" required>
                        </div>
                        <div class="mb-3">
                            <label for="link" class="form-label">Link</label>
                            <input type="url" name="link" id="link" class="form-control" placeholder="Banner Link">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="bannerForm">Submit</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Setup CSRF token in AJAX request
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var mode = 'create';
        var selectedId = 0;

        var table = $('#bannerTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('seller.banners') }}",
            columns: [
                { data: 'DT_RowIndex', className: 'align-middle text-center' },
                { data: 'title', className: 'align-middle text-center' },
                { data: 'link', className: 'align-middle text-center' },
                { data: 'image', className: 'align-middle text-center' },
                { data: 'status', className: 'align-middle text-center' },
                { data: 'action', className: 'align-middle text-center' }
            ],
            drawCallback: function (settings) {
                var rowCount = table.rows().count(); // Ambil jumlah total baris data
                if (rowCount > 0) {
                    $('#create_btn').addClass('d-none');
                } else {
                    $('#create_btn').removeClass('d-none');
                }
            }
        });


        // Open Create Modal
        $("#create_btn").on("click", function() {
            mode = 'create';
            $("#bannerForm")[0].reset();
            $("#formMethod").val("POST");
            $(".modal-title").text("Create Banner");
            $("#bannerModal").modal("show");
        });

        // Open Edit Modal
        $("#bannerTable").on("click", ".btn-edit", function() {
            mode = 'edit';
            selectedId = $(this).data("id");
            
            $("#title").val($(this).data("title"));
            $("#link").val($(this).data("link"));
            $("#banner_id").val(selectedId);
            $("#formMethod").val("PUT");

            $(".modal-title").text("Edit Banner");
            $("#bannerModal").modal("show");
        });

        // Form Submission
        $('#bannerForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            let url = mode === 'create' ? "{{ route('seller.banners.store') }}" 
                : "{{ route('seller.banners.update', ':id') }}".replace(':id', selectedId);
            
            $.ajax({
                url: url,
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#bannerModal').modal('hide');
                    Swal.fire("Success", response.message, "success");
                    table.ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire("Error", "Something went wrong!", "error");
                }
            });
        });

        // Delete Banner
        $("#bannerTable").on("click", ".btn-delete", function() {
            let id = $(this).data("id");
            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('seller.banners.destroy', ':id') }}".replace(':id', id),
                        method: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire("Deleted!", response.message, "success");
                            table.ajax.reload();
                        },
                        error: function() {
                            Swal.fire("Error!", "Failed to delete banner!", "error");
                        }
                    });
                }
            });
        });

    });
</script>
@endsection
