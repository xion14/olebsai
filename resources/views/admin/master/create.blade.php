@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Admin</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form id="addAdminForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="phone" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select name="role" class="form-control" required>
                                        <option value="">Pilih role</option>
                                        <option value="1">Super Admin</option>
                                        <option value="2">Admin</option>
                                        <option value="5">Admin Register</option>
                                        <option value="6">Admin User</option>
                                        <option value="7">Admin Konsumen</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script>
$(function(){
    $('#addAdminForm').on('submit', function(e){
        e.preventDefault();
        $.post("{{ route('admin.master.admins.store') }}", $(this).serialize())
            .done(res=>{
                sweetAlertSuccess(res.text || 'Admin ditambahkan');
                window.location.href = "{{ route('admin.master.admins') }}";
            })
            .fail(xhr=>{
                sweetAlertDanger(xhr.responseJSON?.message || xhr.responseJSON?.text || 'Gagal menambah admin');
            });
    });
});
</script>
@endsection
