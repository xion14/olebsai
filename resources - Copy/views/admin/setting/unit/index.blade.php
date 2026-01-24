@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Units</h1>
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
                    <table id="unitTable" class="table table-striped my-4" id="table-1">
                      <thead>                                 
                        <tr>
                            <th width="5%" class="text-center">#</th>
                            <th class="text-center">Code</th>
                            <th class="text-center">Name</th>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="unitModal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title fs-5">Create Unit</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="unitForm">
                  <div class="mb-3">
                    <label for="code" class="form-label">Unit Code</label>
                    <input type="text" name="code" id="code" class="form-control" placeholder="Unit Code">
                  </div>
                  <div class="mb-3">
                    <label for="unit" class="form-label">Unit Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Unit Name">
                  </div>
                </form>
            </div>
            <div class="modal-footer bg-whitesmoke br">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" form="unitForm">Submit <i class="ti ti-send"></i></button>
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
        element: $('#unitTable'),
        url: "{{ route('admin.setting.units') }}",
        columns: [
          { data: 'no',name: 'no' },
          { data: 'code',name: 'code', searchable:true },
          { data: 'name', name: 'name', searchable: true },
          { data: 'status', name: 'status', searchable: false, orderable: false, className: 'text-center'  },
          { data: 'action', name: 'action', searchable: false, orderable: false, className: 'text-center' }
        ]
      });

      function switchStatus(id, status) {
        return new Promise((resolve, reject) => {
          $.ajax({
            url: '{{ route('admin.setting.units.switchStatus') }}',
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

      $('#unitTable').on('change', '.switch-status', function() {
        var id = $(this).data('id');
        var status = $(this).is(':checked') ? 1 : 0;

        switchStatus(id, status)
          .then(response => { 
            if(response.status === 200) {
                sweetAlertSuccess(response.text);
                table.ajax.reload(null, false);
            } else if(response.status === 400) {
                sweetAlertDanger(response.text);
            }
          })
          .catch(error => {
            console.error('Terjadi kesalahan:', error);
          });
      });

      $("#create_btn").on( "click", function() {
        $('.modal-title').text('Create Unit');
        mode = 'create';
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        $('#code').val('');
        $('#name').val('');
        $('#unitModal').modal('show');
      });

      $("#unitTable").on("click", '.btn-edit', function() {
        mode = 'edit';
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        selectedId = $(this).data('id');
        let code = $(this).data('code');
        let name = $(this).data('name');

        $('.modal-title').text('Edit Unit');
        $('#code').val(code);
        $('#name').val(name);
        $('#unitModal').modal('show');
      });

      function processForm(mode,id,code,name){
        return new Promise((resolve,reject) => {
          let data = {
            _token: '{{ csrf_token() }}',
            code: code,
            name: name
          };
          if (mode == 'edit'){
            data._method = 'put';
            data.id = id;
          }

          $.ajax({
            url : mode == 'create' ? '{{ route('admin.setting.units.store') }}' : '{{ route('admin.setting.units.update',':id') }}'.replace(':id',id),
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

      $('#unitForm').on('submit',function(e)
      {
        e.preventDefault();
        let code = $('#code').val();
        let name = $('#name').val();

        processForm(mode,selectedId,code,name)
          .then(response => {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            $('#code').val('');
            $('#name').val('');
            $('#unitModal').modal('hide');
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
            url: '{{ route('admin.setting.units.destroy', ':id') }}'.replace(':id', unitId),
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

      $('#unitTable').on('click', '.btn-delete', function() {
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
