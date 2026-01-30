@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pemetaan Pelapak Ekraf</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('admin.register.dashboard') }}">Dasbor SKPD</a></div>
                <div class="breadcrumb-item active">Pemetaan Pelapak</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Subsektor</label>
                            <select id="filter-subsector" class="form-control">
                                <option value="">Semua</option>
                                @foreach($subsectors as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Distrik/Kampung</label>
                            <select id="filter-city" class="form-control">
                                <option value="">Semua</option>
                                @foreach($cities as $c)
                                    <option value="{{ $c }}">{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">OAP</label>
                            <select id="filter-oap" class="form-control">
                                <option value="">Semua</option>
                                <option value="yes">OAP</option>
                                <option value="no">Non OAP</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end justify-content-between">
                            <button id="btn-refresh" class="btn btn-primary"><i class="fas fa-sync"></i> Terapkan</button>
                            <a id="btn-export" href="#" class="btn btn-success"><i class="fas fa-file-export"></i> Export CSV</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped" id="map-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>OAP</th>
                                <th>Kota</th>
                                <th>Provinsi</th>
                                <th>Subsektor</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script>
$(function(){
    const table = $('#map-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.register.map.data') }}",
            data: function(d){
                d.subsector = $('#filter-subsector').val();
                d.city      = $('#filter-city').val();
                d.oap       = $('#filter-oap').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'oap_badge', name: 'oap', orderable:false, searchable:false, className:'text-center'},
            {data: 'city', name: 'city'},
            {data: 'province', name: 'province'},
            {data: 'subsectors', name: 'subsectors'}
        ]
    });

    $('#btn-refresh').on('click', function(){
        table.ajax.reload();
    });

    $('#btn-export').on('click', function(e){
        e.preventDefault();
        const qs = $.param({
            subsector: $('#filter-subsector').val(),
            city: $('#filter-city').val(),
            oap: $('#filter-oap').val()
        });
        window.location = "{{ route('admin.register.map.export') }}" + '?' + qs;
    });
});
</script>
@endsection
