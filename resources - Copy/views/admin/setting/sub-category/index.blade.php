@extends('__layouts.__admin.main')

@section('body')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Sub Categories</h1>
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
                                    <table id="categoryTable" class="table table-striped my-4" id="table-1">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">#</th>
												<th class="text-center">Category Code</th>
                                                <th class="text-center">Category Name</th>
												<th class="text-center">Code</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Image</th>
                                                <th class="text-center">Status</th>
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

        <div class="modal fade" tabindex="-1" role="dialog" id="categoryModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title fs-5">Create Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="categoryForm">
							<div class="mb-3">
                                <label for="code" class="form-label">Category Name</label>
                                <select id="setting_category_id" name="setting_category_id" class="form-control">
								<option value="">-- Select Category Name --</option>
								@foreach($setting_categories as $id => $settingCategoryName)
									<option value="{{ $id }}">{{ $settingCategoryName }}</option>
								@endforeach
                            </select>
                            </div>
                            <div class="mb-3">
                                <label for="code" class="form-label">Sub Category Code</label>
                                <input type="text" name="code" id="code" class="form-control"
                                    placeholder="Sub Category Code">
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Sub Category Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Sub Category Name">
                            </div>
                            <!-- image upload -->
                            <div class="mb-3">
                                <label for="image">Sub Category Image</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            </div>
                            <!-- end image upload -->
                        </form>
                    </div>


                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" form="categoryForm">Submit <i
                                class="ti ti-send"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl"> <!-- Ubah ukuran modal -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Preview Image</h5>

                    </div>
                    <div class="modal-body text-center">
                        <img id="modalImage" src="" class="img-fluid rounded"
                            style="max-width: 100%; height: auto;" />
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('script')
        <script>
            function showImageModal(imageUrl) {
                console.log(imageUrl);
                $('#modalImage').attr('src', imageUrl);
                $('#imageModal').modal('show');
            }

            $(document).ready(function() {
                var mode = 'create';
                var selectedId = 0;


                var table = registerDatatables({
                    element: $('#categoryTable'),
                    url: "{{ route('admin.setting.sub-categories') }}",
                    columns: [{
                            data: 'no',
                            name: 'no'
                        },
						{
                            data: 'pcode',
                            name: 'pcode',
                            searchable: true
                        },
						{
                            data: 'pname',
                            name: 'pname',
                            searchable: true
                        },
                        {
                            data: 'code',
                            name: 'code',
                            searchable: true
                        },
                        {
                            data: 'name',
                            name: 'name',
                            searchable: true
                        },
                        {
                            data: 'image',
                            name: 'image',
                            searchable: false,
                            orderable: false,
                            className: 'text-center',
                            render: function(data, type, row) {
                                if (!data) {
                                    return '<span class="text-muted">No Image</span>';
                                }
                                let imageUrl = `/uploads/sub_category/${data}`;
                                return `<img src="${imageUrl}" width="50" height="50" class="rounded cursor-pointer" 
                        onclick="showImageModal('${imageUrl}')"/>`;
                            }
                        },


                        {
                            data: 'status',
                            name: 'status',
                            searchable: false,
                            orderable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            searchable: false,
                            orderable: false,
                            className: 'text-center'
                        }
                    ]
                });




                function switchStatus(id, status) {
                    return new Promise((resolve, reject) => {
                        $.ajax({
                            url: '{{ route('admin.setting.sub-categories.switchStatus') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id,
                                status: status
                            },
                            success: function(response) {
                                resolve(response);
                            },
                            error: function(xhr) {
                                reject(xhr);
                            }
                        });
                    });
                }

                $('#categoryTable').on('change', '.switch-status', function() {
                    var id = $(this).data('id');
                    var status = $(this).is(':checked') ? 1 : 0;

                    switchStatus(id, status)
                        .then(response => {
                            if (response.status === 200) {
                                sweetAlertSuccess(response.text);
                                table.ajax.reload(null, false);
                            } else if (response.status === 400) {
                                sweetAlertDanger(response.text);
                            }
                        })
                        .catch(error => {
                            console.error('Terjadi kesalahan:', error);
                        });
                });

                $("#create_btn").on("click", function() {
                    $('.modal-title').text('Create Sub Category');
					$('#categoryForm')[0].reset();
                    mode = 'create';
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();
                    $('#code').val('');
                    $('#name').val('');
                    $('#image').val('');
                    $('#categoryModal').modal('show');
                });

                $("#categoryTable").on("click", '.btn-edit', function() {
                    mode = 'edit';
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();

                    selectedId = $(this).data('id');
					let pid = $(this).data('pid');
                    let code = $(this).data('code');
                    let name = $(this).data('name');

                    $('.modal-title').text('Edit Category');
					$('#setting_category_id').val(pid);
                    $('#code').val(code);
                    $('#name').val(name);

                    $('#categoryModal').modal('show');
                });

                function processForm(mode, id, setting_category_id, code, name, image) {
                    return new Promise((resolve, reject) => {
                        let formData = new FormData();
                        formData.append('_token', '{{ csrf_token() }}');
						formData.append('setting_category_id', setting_category_id);
                        formData.append('code', code);
                        formData.append('name', name);

                        if (image) {
                            formData.append('image', image);
                        }

                        if (mode === 'edit') {
                            formData.append('_method', 'PUT');
                            formData.append('id', id);
                        }
						
                        $.ajax({
                            url: mode === 'create' ?
                                '{{ route('admin.setting.sub-categories.store') }}' :
                                '{{ route('admin.setting.sub-categories.update', ':id') }}'.replace(':id',
                                    id),
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
								// // // // // alert('aaa');
                                resolve(response);
                            },
                            error: function(xhr) {
								// // // // // alert('bbb');
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




                $('#categoryForm').on('submit', function(e) {
                    e.preventDefault();
					let setting_category_id = $('#setting_category_id').val();
                    let code = $('#code').val();
                    let name = $('#name').val();
                    let image = $('#image')[0].files[0]; // Ambil file yang dipilih

                    processForm(mode, selectedId, setting_category_id, code, name, image)
                        .then(response => {
                            $('.is-invalid').removeClass('is-invalid');
                            $('.invalid-feedback').remove();
							$('#setting_category_id').val('');
                            $('#code').val('');
                            $('#name').val('');
                            $('#image').val('');
                            $('#categoryModal').modal('hide');

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


                function deleteData(categoryId) {
                    return new Promise((resolve, reject) => {
                        $.ajax({
                            url: '{{ route('admin.setting.sub-categories.destroy', ':id') }}'.replace(':id',
                                categoryId),
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'delete',
                            },
                            success: function(response) {
                                resolve(response);
                            },
                            error: function(xhr) {
                                reject(xhr);
                            }
                        });
                    });
                }

                $('#categoryTable').on('click', '.btn-delete', function() {
                    const id = $(this).data('id');
                    const form = $(`#delete-form-${id}`);

                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteData(id)
                                .then((rs) => {
                                    if (rs.status === 200) {
                                        sweetAlertSuccess(rs.text);
                                        table.ajax.reload(null, false);
                                    } else if (rs.status === 400) {
                                        sweetAlertDanger(rs.text);
                                    }
                                });
                        }
                    });
                });
            });
        </script>
    @endsection
