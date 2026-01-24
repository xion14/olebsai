@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Vouchers</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#">Admin</a></div>
                <div class="breadcrumb-item active"><a href="#">Vouchers</a></div>
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
                                <table id="voucherTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Percentage</th>
                                            <th>Max Discount</th>
                                            <th>Min Transaction</th>
                                            <th>Quota</th>
                                            <th>Status</th>
                                            <th>Valid</th>
                                            <th>Actions</th>
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

    <!-- Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="voucherModal">
        <div class="modal-dialog" role="document">
            <form id="voucherForm">
                @csrf
                <input type="hidden" name="_method" value="POST" id="formMethod">
                <input type="hidden" name="id" id="voucher_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Voucher</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body row">
                        <div class="form-group col-md-12">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Type</label>
                            <select name="type" class="form-control">
                                <option value="1">Product Discount</option>
                                <option value="2">Shipping Discount</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Non Active</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Percentage (%)</label>
                            <input type="number" name="percentage" step="0.01" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Max Discount</label>
                            <input type="number" name="max_discount" step="0.01" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Minimum Transaction</label>
                            <input type="number" name="minimum_transaction" step="0.01" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Quota</label>
                            <input type="number" name="quota" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Start Date</label>
                            <input type="datetime-local" name="start_date" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Expired Date</label>
                            <input type="datetime-local" name="expired_date" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

        let table = $('#voucherTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.vouchers') }}",
            columns: [
                { data: 'DT_RowIndex' },
                { data: 'name' },
                { data: 'type' },
                { data: 'percentage' },
                { data: 'max_discount' },
                { data: 'minimum_transaction' },
                { data: 'quota' },
                { data: 'status' },
                { data: 'validity' },
                { data: 'action' }
            ]
        });

        let mode = 'create';
        let selectedId = 0;

        $('#create_btn').on('click', function () {
            mode = 'create';
            $('#voucherForm')[0].reset();
            $('#formMethod').val("POST");
            $('#voucherModal').modal('show');
            $('.modal-title').text('Create Voucher');
        });

        $('#voucherTable').on('click', '.btn-edit', function () {
            mode = 'edit';
            selectedId = $(this).data("id");

            for (const field in this.dataset) {
                if (field !== "id") $(`[name=${field}]`).val(this.dataset[field]);
            }

            $('#voucher_id').val(selectedId);
            $('#formMethod').val("PUT");
            $('.modal-title').text('Edit Voucher');
            $('#voucherModal').modal('show');
        });

        $('#voucherForm').on('submit', function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            let url = mode === 'create'
                ? "{{ route('admin.vouchers.store') }}"
                : "{{ route('admin.vouchers.update', ':id') }}".replace(':id', selectedId);

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    if (res.success) {
                        $('#voucherModal').modal('hide');
                        Swal.fire("Success", res.message, "success");
                        table.ajax.reload();
                    } else {
                        Swal.fire("Failed", res.message, "error");
                    }
                },
                error: function () {
                    Swal.fire("Error", "Something went wrong", "error");
                }
            });
        });

        $('#voucherTable').on('click', '.btn-delete', function () {
            let id = $(this).data("id");
            Swal.fire({
                title: "Are you sure?",
                text: "This will permanently delete the voucher.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then((res) => {
                if (res.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.vouchers.destroy', ':id') }}".replace(':id', id),
                        type: "DELETE",
                        success: function (res) {
                            Swal.fire("Deleted!", res.message, "success");
                            table.ajax.reload();
                        },
                        error: function () {
                            Swal.fire("Error", "Failed to delete data", "error");
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
