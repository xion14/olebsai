@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Kelola Admin & Role</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped" id="admin-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $i => $u)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td>
                                        <select class="form-control form-control-sm role-select" data-id="{{ $u->id }}">
                                            @foreach($roles as $val => $label)
                                                <option value="{{ $val }}" @selected($u->role==$val)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary btn-save-role" data-id="{{ $u->id }}">Simpan</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h4>Daftar Menu & Role yang Bisa Melihat</h4>
                    <div class="text-muted" style="font-size: 12px;">Pilih role yang boleh melihat tiap menu lalu klik Simpan.</div>
                </div>
                <div class="card-body table-responsive">
                    <form id="menuMapForm">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Menu Key</th>
                                    <th>Role yang diizinkan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($menuMap as $key => $roles)
                                    <tr>
                                        <td><code>{{ $key }}</code></td>
                                        <td>
                                            <select name="menu[{{ $key }}][]" class="form-control form-control-sm menu-roles" multiple>
                                                @foreach($roles as $r)
                                                    @php $selectedRole[$key][$r]=true; @endphp
                                                @endforeach
                                                @foreach([1=>'Super Admin',2=>'Admin',5=>'Admin Register',6=>'Admin User',7=>'Admin Konsumen'] as $val=>$label)
                                                    <option value="{{ $val }}" @if(isset($selectedRole[$key][$val])) selected @endif>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary">Simpan Mapping</button>
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
    $('.btn-save-role').on('click', function(){
        const id = $(this).data('id');
        const role = $(`select.role-select[data-id='${id}']`).val();
        $.post(`{{ url('/admin/master/admins') }}/${id}`, {
            _token: '{{ csrf_token() }}',
            role: role
        }).done(res=>{
            sweetAlertSuccess(res.text || 'Role diperbarui');
        }).fail(xhr=>{
            sweetAlertDanger(xhr.responseJSON?.message || xhr.responseJSON?.text || 'Gagal memperbarui');
        });
    });

    $('#menuMapForm').on('submit', function(e){
        e.preventDefault();
        const formData = $(this).serialize();
        $.post("{{ route('admin.master.menu-map.update') }}", formData)
            .done(res=>{
                sweetAlertSuccess(res.text || 'Mapping disimpan');
            })
            .fail(xhr=>{
                sweetAlertDanger(xhr.responseJSON?.text || 'Gagal menyimpan mapping');
            });
    });
});
</script>
@endsection
