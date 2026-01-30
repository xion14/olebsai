@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dasbor SKPD</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('admin.register.dashboard') }}">Dasbor SKPD</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning"><i class="fas fa-hourglass-half"></i></div>
                        <div class="card-wrap">
                            <div class="card-header"><h4>Belum Diverifikasi</h4></div>
                            <div class="card-body">{{ $unverified }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success"><i class="fas fa-check"></i></div>
                        <div class="card-wrap">
                            <div class="card-header"><h4>Sudah Disetujui</h4></div>
                            <div class="card-body">{{ $approved }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></div>
                        <div class="card-wrap">
                            <div class="card-header"><h4>Perlu Perbaikan</h4></div>
                            <div class="card-body">{{ $needFix }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header"><h4>Sebaran Pelapak per Subsektor</h4></div>
                        <div class="card-body table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Subsektor</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($subsectorDist as $row)
                                        <tr>
                                            <td>{{ $row->subsektor }}</td>
                                            <td class="text-right">{{ $row->total }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="2" class="text-center text-muted">Tidak ada data</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header"><h4>Sebaran Pelapak per Distrik/Kampung</h4></div>
                        <div class="card-body table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Distrik/Kampung</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($districtDist as $row)
                                        <tr>
                                            <td>{{ $row->distrik ?? '-' }}</td>
                                            <td class="text-right">{{ $row->total }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="2" class="text-center text-muted">Tidak ada data</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
