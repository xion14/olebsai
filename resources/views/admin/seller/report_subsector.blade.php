@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Laporan Pelapak per Subsektor & Kota</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('admin.sellers') }}">Seller</a></div>
                <div class="breadcrumb-item active">Laporan Subsektor</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card mb-3">
                <div class="card-body">
                    <form class="row g-3" method="GET">
                        <div class="col-md-4">
                            <label class="form-label">Subsektor</label>
                            <select name="subsector" class="form-control">
                                <option value="">Semua</option>
                                @foreach($subsectors as $id=>$name)
                                    <option value="{{ $id }}" {{ ($subsectorId ?? '')==$id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kota/Kabupaten</label>
                            <select name="city" class="form-control">
                                <option value="">Semua</option>
                                @foreach($cities as $c)
                                    <option value="{{ $c }}" {{ ($cityFilter ?? '')==$c ? 'selected' : '' }}>{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">OAP</label>
                            <select name="oap" class="form-control">
                                <option value="">Semua</option>
                                <option value="yes" {{ ($oapFilter ?? '')=='yes' ? 'selected' : '' }}>OAP</option>
                                <option value="no" {{ ($oapFilter ?? '')=='no' ? 'selected' : '' }}>Non OAP</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Terapkan Filter</button>
                            <a href="{{ route('admin.sellers.report.subsector') }}" class="btn btn-light">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body table-responsive">
                    <h6 class="mb-2">Ringkasan per Subsektor</h6>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Subsektor</th>
                                <th>Total Pelapak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($perSubsector as $row)
                                <tr>
                                    <td>{{ $row->subsector }}</td>
                                    <td>{{ $row->total_sellers }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-body table-responsive">
                    <h6 class="mb-2">Detail Subsektor x Kota</h6>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Subsektor</th>
                                <th>Kota</th>
                                <th>Total Pelapak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rows as $row)
                                <tr>
                                    <td>{{ $row->subsector }}</td>
                                    <td>{{ $row->city }}</td>
                                    <td>{{ $row->total_sellers }}</td>
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
