@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dasbor Komplain & Kepuasan</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info"><i class="fas fa-bullhorn"></i></div>
                        <div class="card-wrap">
                            <div class="card-header"><h4>Komplain Baru (Hari Ini)</h4></div>
                            <div class="card-body">{{ $complainToday }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning"><i class="fas fa-hourglass-half"></i></div>
                        <div class="card-wrap">
                            <div class="card-header"><h4>Komplain Belum Tertangani</h4></div>
                            <div class="card-body">{{ $complainOpen }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></div>
                        <div class="card-wrap">
                            <div class="card-header"><h4>Komplain Mengendap (&gt;7 hari)</h4></div>
                            <div class="card-body">{{ $stale }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success"><i class="fas fa-check-circle"></i></div>
                        <div class="card-wrap">
                            <div class="card-header"><h4>Komplain Selesai</h4></div>
                            <div class="card-body">{{ $resolvedPct }}%</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header"><h4>Komplain per Subsektor</h4></div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <thead><tr><th>Subsektor</th><th class="text-right">Total</th></tr></thead>
                                <tbody>
                                    @forelse($perSubsector as $row)
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
                        <div class="card-header"><h4>Persentase Komplain Selesai</h4></div>
                        <div class="card-body">
                            <p>Total komplain: {{ $totalComplain }}</p>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $resolvedPct }}%;" aria-valuenow="{{ $resolvedPct }}" aria-valuemin="0" aria-valuemax="100">{{ $resolvedPct }}%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
