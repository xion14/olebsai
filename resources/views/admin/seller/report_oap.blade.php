@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Laporan Pelapak OAP vs Non-OAP</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('admin.sellers') }}">Seller</a></div>
                <div class="breadcrumb-item active">Laporan OAP</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card mb-3">
                <div class="card-body">
                    <form class="row g-3" method="GET">
                        <div class="col-md-6">
                            <label class="form-label">Subsektor</label>
                            <select name="subsector" class="form-control">
                                <option value="">Semua</option>
                                @foreach($subsectors as $id=>$name)
                                    <option value="{{ $id }}" {{ ($subsectorId ?? '')==$id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kota/Kabupaten</label>
                            <select name="city" class="form-control">
                                <option value="">Semua</option>
                                @foreach($cities as $c)
                                    <option value="{{ $c }}" {{ ($cityFilter ?? '')==$c ? 'selected' : '' }}>{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Terapkan Filter</button>
                            <a href="{{ route('admin.sellers.report.oap') }}" class="btn btn-light">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body table-responsive">
                    <h6 class="mb-2">Ringkasan Nasional</h6>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Total Pelapak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($summary as $row)
                                <tr>
                                    <td>{{ $row->oap === 'yes' ? 'OAP' : 'Non OAP' }}</td>
                                    <td>{{ $row->total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-body table-responsive">
                    <h6 class="mb-2">Per Kota</h6>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Kota</th>
                                <th>OAP</th>
                                <th>Non OAP</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($perCity as $row)
                                <tr>
                                    <td>{{ $row->city }}</td>
                                    <td>{{ $row->oap_yes }}</td>
                                    <td>{{ $row->oap_no }}</td>
                                    <td>{{ $row->total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body table-responsive">
                    <h6 class="mb-2">Detail Pelapak</h6>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Kota</th>
                                <th>OAP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detail as $row)
                                <tr>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->email }}</td>
                                    <td>{{ $row->phone }}</td>
                                    <td>{{ $row->city ?? '-' }}</td>
                                    <td>{{ $row->oap === 'yes' ? 'OAP' : 'Non OAP' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
