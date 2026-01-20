@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Setting Cost</h1>
            <div class="section-header-breadcrumb">
                <button class="btn btn-primary" id="create_btn"><i class="fas fa-plus"></i> Create</button>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="settingCostTable" class="table table-striped my-4">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">#</th>
                                            <th class="text-center">Min. Price</th>
                                            <th class="text-center">Max. Price</th>
                                            <th class="text-center">Cost Value</th>
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

    <!-- Modal -->
    <div class="modal fade" id="settingCostModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Setting Cost</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="settingCostForm">
                        <div class="form-group">
                            <label>Min. Price</label>
                            <input type="number" name="min_price" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Max. Price</label>
                            <input type="number" name="max_price" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Cost Value</label>
                            <input type="number" name="cost_value" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="settingCostForm">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
$(document).ready(function() {
    var mode = 'create';
    var selectedId = null;

    var table = registerDatatables({
        element: $('#settingCostTable'),
        url: "{{ route('admin.setting-cost') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
            { 
                data: 'min_price', 
                className: 'text-center',
                render: function(data, type, row) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data);
                }
            },
            { 
                data: 'max_price', 
                className: 'text-center',
                render: function(data, type, row) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data);
                }
            },

            { data: 'cost_value', className: 'text-center',
                render: function(data, type, row) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data);
                }
             },
            { 
                data: 'status', 
                name: 'status',
                render: function(data, type, row) {
                    var badgeClass = data == 1 ? 'badge-success' : 'badge-secondary'; // Green for active, Grey for inactive
                    var badgeText = data == 1 ? 'Active' : 'Inactive';
                    return `
                        <span class="badge ${badgeClass}">${badgeText}</span>
                    `;
                }
                , className: 'text-center'
            },
            { data: 'action', orderable: false, searchable: false, className: 'text-center' }
        ]
    });

    $("#create_btn").on("click", function() {
        mode = 'create';
        selectedId = null;
        $('#settingCostForm')[0].reset();
        $('.modal-title').text('Create Setting Cost');
        $('#settingCostModal').modal('show');
    });

    $("#settingCostTable").on("click", ".btn-edit", function() {
        mode = 'edit';
        selectedId = $(this).data('id');

        $('input[name="min_price"]').val($(this).data('min_price'));
        $('input[name="max_price"]').val($(this).data('max_price'));
        $('input[name="cost_value"]').val($(this).data('cost_value'));
        $('select[name="status"]').val($(this).data('status'));

        $('.modal-title').text('Edit Setting Cost');
        $('#settingCostModal').modal('show');
    });

    $("#settingCostForm").on("submit", function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        var url = mode === 'create' 
            ? "{{ route('admin.setting-cost.store') }}" 
            : "{{ route('admin.setting-cost.update', ':id') }}".replace(':id', selectedId);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function(response) {
                $('#settingCostModal').modal('hide');
                table.ajax.reload(null, false);
                sweetAlertSuccess(response.text);
            },
            error: function(xhr) {
                console.error(xhr);
                sweetAlertDanger(xhr.responseJSON.text);
            }
        });
    });

    $("#settingCostTable").on("click", ".btn-delete", function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.setting-cost.destroy', ':id') }}".replace(':id', id),
                    type: 'POST',
                    data: { _method: 'DELETE', _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        table.ajax.reload(null, false);
                        sweetAlertSuccess(response.text);
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        sweetAlertDanger('Failed to delete.');
                    }
                });
            }
        });
    });
});
</script>
@endsection
