@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Analisis Pola Masalah</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header"><h4>Subsektor dengan Komplain Terbanyak</h4></div>
                        <div class="card-body table-responsive">
                            <table class="table table-sm">
                                <thead><tr><th>Subsektor</th><th class="text-right">Total Komplain</th></tr></thead>
                                <tbody>
                                    @forelse($bySubsector as $row)
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
                        <div class="card-header"><h4>Jenis Masalah yang Sering Terjadi</h4></div>
                        <div class="card-body table-responsive">
                            <table class="table table-sm">
                                <thead><tr><th>Jenis Masalah</th><th class="text-right">Total</th></tr></thead>
                                <tbody>
                                    @forelse($byIssue as $row)
                                        <tr>
                                            <td>{{ $row->label }}</td>
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
