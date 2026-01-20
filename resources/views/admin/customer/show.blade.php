@extends('__layouts.__admin.main')

@section('body')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Customer Detail</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Admin</a></div>
                    <div class="breadcrumb-item"><a href="#">Customer</a></div>
                    <div class="breadcrumb-item active">Detail</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <!-- Informasi Customer -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h4><i class="fas fa-user"></i> Customer Information</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <th><i class="fas fa-tag"></i> Code</th>
                                        <td>{{ $customer->code }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-user"></i> Name</th>
                                        <td>{{ $customer->name }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-envelope"></i> Email</th>
                                        <td>{{ $customer->email }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-phone"></i> Whatsapp</th>
                                        <td>
                                            <a target="_blank" href="https://wa.me/{{ $customer->phone }}">{{ $customer->phone }}</a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Alamat -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h4><i class="fas fa-map-marker-alt"></i> Address List</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="addressTable" class="table table-striped table-hover">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Road</th>
                                                <th>City</th>
                                                <th>Province</th>
                                                <th>Postal Code</th>
                                                <th>Address</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal Edit Alamat -->
    <div class="modal fade" id="editAddressModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Address</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="editAddressForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" id="edit_phone" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Road</label>
                            <input type="text" name="road" id="edit_road" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="city" id="edit_city" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Province</label>
                            <input type="text" name="province" id="edit_province" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Postal Code</label>
                            <input type="text" name="zip_code" id="edit_zip_code" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" id="edit_address" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
       $(document).ready(function() {
        let addressTable = $('#addressTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.customer.address', ['customer_id' => $customer->id]) }}", 
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'phone', name: 'phone' },
                { data: 'road', name: 'road' },
                { data: 'city', name: 'city' },
                { data: 'province', name: 'province' },
                { data: 'zip_code', name: 'zip_code' },
                { data: 'address', name: 'address' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

         // Event klik tombol Edit
        $(document).on('click', '.edit', function() {
            let addressId = $(this).data('id'); // Ambil ID dari tombol Edit
            $.ajax({
                url: "{{ url('admin/customer/address') }}" + '/' + addressId,
                type: "GET",
                success: function(response) {
                    if (response.success) {
                        let data = response.data;
                        
                        // Isi form modal edit dengan data dari server
                        $('#edit_id').val(data.id);
                        $('#edit_name').val(data.name);
                        $('#edit_phone').val(data.phone);
                        $('#edit_road').val(data.road);
                        $('#edit_city').val(data.city);
                        $('#edit_province').val(data.province);
                        $('#edit_zip_code').val(data.zip_code);
                        $('#edit_address').val(data.address);

                        // Buka modal edit
                        $('#editAddressModal').modal('show');
                    } else {
                        Swal.fire("Error", "Data not found!", "error");
                    }
                },
                error: function() {
                    Swal.fire("Error", "Failed to fetch data!", "error");
                }
            });
        });


        // Event ketika tombol Hapus diklik
        $(document).on('click', '.delete', function() {
            let addressId = $(this).data('id');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/customer/address') }}" + '/' + addressId,
                        type: "POST",
                        data: { 
                            id: addressId,
                            _method: 'DELETE',
                            _token: "{{ csrf_token() }}" // Tambahkan CSRF Token di sini
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Address deleted successfully!',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    addressTable.ajax.reload(null, false); // Reload DataTables tanpa reset halaman
                                });
                            } else {
                                Swal.fire("Error", "Failed to delete address!", "error");
                            }
                        },
                        error: function() {
                            Swal.fire("Error", "Failed to delete address!", "error");
                        }
                    });
                }
            });
        });

        // Event ketika form edit disubmit
        $('#editAddressForm').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('admin.customer.address.update') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    $('#editAddressModal').modal('hide');
                    Swal.fire({
                        title: 'Success!',
                        text: 'Address updated successfully!',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        addressTable.ajax.reload(null, false); // Reload DataTables tanpa reset halaman
                    });
                },
                error: function() {
                    Swal.fire("Error", "Failed to update address!", "error");
                }
            });
        });
    });

    </script>
@endsection
