@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dasbor Operasional</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success"><i class="fas fa-user-check"></i></div>
                        <div class="card-wrap">
                            <div class="card-header"><h4>Pelapak Aktif</h4></div>
                            <div class="card-body">{{ $active }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-secondary"><i class="fas fa-user-slash"></i></div>
                        <div class="card-wrap">
                            <div class="card-header"><h4>Pelapak Nonaktif</h4></div>
                            <div class="card-body">{{ $nonactive }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info"><i class="fas fa-user-plus"></i></div>
                        <div class="card-wrap">
                            <div class="card-header"><h4>Pelapak Baru</h4></div>
                            <div class="card-body">{{ $newReg }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></div>
                        <div class="card-wrap">
                            <div class="card-header"><h4>Pelapak Bermasalah</h4></div>
                            <div class="card-body">{{ $problematic }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
