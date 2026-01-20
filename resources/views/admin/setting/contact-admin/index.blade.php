@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Contact Admin</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item"><a href="#">Setting</a></div>
              <div class="breadcrumb-item active"><a href="#">Contact Admin</a></div>
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
                            <th class="text-center">Name</th>
                            <th class="text-center" width="50%">Phone</th>
                            <th width="20%" class="text-center">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <form action="" method="POST">
                          @csrf
                          <tr>
                              <td class="text-center">{{ $data->name }}</td>
                              <td class="text-center">
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">+62</span>
                                  </div>
                                  <input type="text" name="contact" class="form-control" value="{{ $data->contact }}" required>
                                </div>
                              </td>
                              <td class="text-center">
                                  <button type="submit" class="btn btn-warning"><i class="fas fa-edit"></i></button>
                              </td>
                          </tr>
                        </form>
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

@endsection
