@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>About Us</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#">Admin</a></div>
                <div class="breadcrumb-item active"><a href="#">About Us</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <button class="btn btn-primary" id="create_btn"><i class="fas fa-plus"></i> Create</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="aboutUsTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">#</th>
                                            <th class="text-center">Key</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Subtitle</th>
                                            <th class="text-center">Image</th>
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
    <div class="modal fade" tabindex="-1" role="dialog" id="aboutUsModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5">Create Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="aboutUsForm">
                        @csrf
                        <input type="hidden" name="_method" value="POST" id="formMethod">
                        <input type="hidden" name="id" id="about_us_id">
                        <input type="hidden" name="key" id="about_us_key">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="About Us Title" required>
                        </div>
                        <div class="mb-3">
                            <label for="subtitle" class="form-label">Subtitle</label>
                            <input type="text" name="subtitle" id="subtitle" class="form-control" placeholder="About Us Subtitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="aboutUsForm">Submit</button>
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

      // Datatables Initialization
        var table = $('#aboutUsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.about-us') }}",
            columns: [
                { data: 'DT_RowIndex', className: 'align-middle text-center' },
                { data: 'key', className: 'align-middle text-center' },
                { data: 'title', className: 'align-middle text-center' },
                { data: 'subtitle', className: 'align-middle text-center' },
                { data: 'image', className: 'align-middle text-center' },
                { data: 'action', className: 'align-middle text-center' }
            ],
            drawCallback: function(settings) {
                var api = this.api();
                var rowCount = api.rows().count(); // Hitung jumlah baris
            }
        });


        // Open Create Modal
        $("#create_btn").on("click", function() {
            mode = 'create';
            $("#aboutUsForm")[0].reset();
            $("#about_us_key").val('impact');
            $("#formMethod").val("POST");
            $(".modal-title").text("Create About Us");
            $("#aboutUsModal").modal("show");
        });

        // Open Edit Modal
        $("#aboutUsTable").on("click", ".btn-edit", function() {
            mode = 'edit';
            selectedId = $(this).data("id");
            selectedKey = $(this).data("key");
            
            $("#title").val($(this).data("title"));
            $("#subtitle").val($(this).data("subtitle"));
            $("#about_us_id").val(selectedId);
            $("#about_us_key").val(selectedKey);
            $("#formMethod").val("PUT");

            $(".modal-title").text("Edit About Us");
            $("#aboutUsModal").modal("show");
        });

        // Form Submission
        $('#aboutUsForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            let url = mode === 'create' ? "{{ route('admin.about-us.store') }}" 
                : "{{ route('admin.about-us.update', ':id') }}".replace(':id', selectedId);
            
            $.ajax({
                url: url,
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#aboutUsModal').modal('hide');
                    Swal.fire("Success", response.message, "success");
                    table.ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire("Error", "Something went wrong!", "error");
                }
            });
        });

        // Delete About Us
        $("#aboutUsTable").on("click", ".btn-delete", function() {
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
                        url: "{{ route('admin.about-us.destroy', ':id') }}".replace(':id', id),
                        method: "DELETE",
                        success: function(response) {
                            $('#create_btn').removeClass('d-none');
                            Swal.fire("Deleted!", response.message, "success");
                            table.ajax.reload();
                        },
                        error: function() {
                            Swal.fire("Error!", "Failed to delete About Us!", "error");
                        }
                    });
                }
            });
        });

    });
</script>
@endsection
