@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pemantauan Kinerja Pelapak</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('admin.sellers') }}">Seller</a></div>
                <div class="breadcrumb-item active">Pemantauan Kinerja</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card mb-3">
                <div class="card-body">
                    <form class="row g-3" id="filter-form">
                        <div class="col-md-4">
                            <label class="form-label">Cari Nama/Email</label>
                            <input type="text" id="q" class="form-control" placeholder="Nama atau email">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Minimal Rasio Selesai (%)</label>
                            <input type="number" id="min_ratio" class="form-control" min="0" max="100" value="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Urutkan</label>
                            <select id="sort" class="form-control">
                                <option value="ratio_asc">Rasio terendah</option>
                                <option value="ratio_desc">Rasio tertinggi</option>
                                <option value="complaint_desc">Komplain terbanyak</option>
                                <option value="complaint_asc">Komplain tersedikit</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped" id="performance-table">
                        <thead>
                            <tr>
                                <th style="min-width: 200px;">Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Rasio Selesai</th>
                                <th>Selesai</th>
                                <th>Batal/Expired</th>
                                <th>Komplain</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sellers as $s)
                                <tr>
                                    <td>{{ $s->name }}</td>
                                    <td>{{ $s->email }}</td>
                                    <td>{{ $s->phone }}</td>
                                    <td>{{ $s->ratio }}%</td>
                                    <td>{{ $s->selesai }}</td>
                                    <td>{{ $s->batal }}</td>
                                    <td>{{ $s->komplain }}</td>
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

@section('script')
<script>
    $(document).ready(function() {
        function applyFilter() {
            const q = $('#q').val().toLowerCase();
            const minRatio = parseFloat($('#min_ratio').val() || '0');
            const sort = $('#sort').val();

            let rows = [];
            $('#performance-table tbody tr').each(function() {
                const $tr = $(this);
                const name = $tr.find('td:eq(0)').text().toLowerCase();
                const email = $tr.find('td:eq(1)').text().toLowerCase();
                const ratioText = $tr.find('td:eq(3)').text();
                const ratio = parseFloat(ratioText.replace('%','')) || 0;
                const complaints = parseInt($tr.find('td:eq(6)').text() || '0', 10);

                const matchQ = !q || name.includes(q) || email.includes(q);
                const matchRatio = ratio >= minRatio;
                if (matchQ && matchRatio) {
                    rows.push({row: $tr, ratio, complaints});
                } else {
                    $tr.hide();
                }
            });

            rows.sort(function(a,b){
                if (sort === 'ratio_asc') return a.ratio - b.ratio;
                if (sort === 'ratio_desc') return b.ratio - a.ratio;
                if (sort === 'complaint_desc') return b.complaints - a.complaints;
                if (sort === 'complaint_asc') return a.complaints - b.complaints;
                return 0;
            });

            $('#performance-table tbody').empty();
            if (rows.length === 0) {
                $('#performance-table tbody').html('<tr><td colspan="8" class="text-center text-muted">Tidak ada data sesuai filter.</td></tr>');
                return;
            }
            rows.forEach(r => {
                r.row.show();
                $('#performance-table tbody').append(r.row);
            });
        }

        $('#q, #min_ratio, #sort').on('input change', applyFilter);
    });
</script>
@endsection
