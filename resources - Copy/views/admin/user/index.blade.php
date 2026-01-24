@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Users</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item"><a href="#">Admin</a></div>
              <div class="breadcrumb-item active"><a href="#">Users</a></div>
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
                    <table id="userTable" class="table table-striped" id="table-1">
                      <thead>                                 
                        <tr>
                            <th width="5%" class="text-center">#</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Phone</th>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="userModal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title fs-5">Create User</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="userForm">
                  <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="User Name">
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="User Email">
                  </div>
                  <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="User Phone">
                  </div>
                  <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                  </div>
                </form>
            </div>
            <div class="modal-footer bg-whitesmoke br">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" form="userForm">Submit <i class="ti ti-send"></i></button>
            </div>
          </div>
        </div>
      </div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
      var mode = 'create';
      var selectedId = 0;
      var table = registerDatatables({
        element: $('#userTable'),
        url: "{{ route('admin.users') }}",
        columns: [
          { data: 'no',name: 'no' },
          { data: 'name', name: 'name', searchable: true },
          { data: 'email', name: 'email', searchable: true },
          { data: 'phone', name: 'phone', searchable: true },
          { data: 'action', name: 'action', searchable: false, orderable: false, className: 'text-center' }
        ]
      });

      $("#create_btn").on( "click", function() {
        $('.modal-title').text('Create User');
        mode = 'create';
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        $('#name').val('');
        $('#email').val('');
        $('#phone').val('');
        $('#password').val('');
        $('#userModal').modal('show');
      });

      $("#userTable").on("click", '.btn-edit', function() {
        mode = 'edit';
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        selectedId = $(this).data('id');
        let email = $(this).data('email');
        let name = $(this).data('name');
        let phone = $(this).data('phone');

        $('.modal-title').text('Edit User');
        $('#email').val(email);
        $('#name').val(name);
        $('#phone').val(phone);
        $('#userModal').modal('show');
      });

      function processForm(mode,id,email,name,phone,password){
        return new Promise((resolve,reject) => {
          let data = {
            _token: '{{ csrf_token() }}',
            email: email,
            name: name,
            phone: phone,
            password: password
          };
          if (mode == 'edit'){
            data._method = 'put';
            data.id = id;
          }

          $.ajax({
            url : mode == 'create' ? '{{ route('admin.users') }}' : '{{ route('admin.users.update',':id') }}'.replace(':id',id),
            method : 'POST',
            data:data,
            success: function(response) {
              resolve(response);
            },
            error: function(xhr) {
              if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;

                for (let field in errors) {
                  let input = $(`[name="${field}"]`);
                  input.addClass('is-invalid');
                  input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                }
              }
              reject(xhr);
            }
          });
        });
      }

      $('#userForm').on('submit',function(e)
      {
        e.preventDefault();
        let email = $('#email').val();
        let name = $('#name').val();
        let phone = $('#phone').val();
        let password = $('#password').val();

        processForm(mode,selectedId,email,name,phone,password)
          .then(response => {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            $('#email').val('');
            $('#name').val('');
            $('#phone').val('');
            $('#userModal').modal('hide');
            if(response.status === 200) {
                sweetAlertSuccess(response.text);
                table.ajax.reload(null, false);
            } else if(response.status === 400) {
                sweetAlertDanger(response.text);
            }})
            .catch(error => {
                console.error('Terjadi Masalah:',error);
            });        
      });

      function deleteData(unitId) {
        return new Promise((resolve, reject) => {
          $.ajax({
            url: '{{ route('admin.users.destroy', ':id') }}'.replace(':id', unitId),
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

      $('#userTable').on('click', '.btn-delete', function() {
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
                if(rs.status === 200) { 
                  sweetAlertSuccess(rs.text);
                  table.ajax.reload(null, false);
                }else if(rs.status === 400){
                  sweetAlertDanger(rs.text);
                }
              });
          }
        });
      });
    });
</script>
@endsection
