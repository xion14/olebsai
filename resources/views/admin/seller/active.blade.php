@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pelapak Aktif</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active">Pelapak Aktif</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card mb-3">
                <div class="card-body">
                    <form id="filter-form" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Cari Nama/Email</label>
                            <input type="text" id="q" class="form-control" placeholder="Nama atau email">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Minimal Transaksi</label>
                            <input type="number" id="min_tx" class="form-control" min="0" value="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Urutkan</label>
                            <select id="sort" class="form-control">
                                <option value="last_desc">Terakhir transaksi (baru)</option>
                                <option value="last_asc">Terakhir transaksi (lama)</option>
                                <option value="tx_desc">Total transaksi (banyak)</option>
                                <option value="tx_asc">Total transaksi (sedikit)</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped" id="active-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Total Transaksi</th>
                                <th>Terakhir Transaksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sellers as $seller)
                                <tr>
                                    <td>{{ $seller->name }}</td>
                                    <td>{{ $seller->email }}</td>
                                    <td>{{ $seller->phone }}</td>
                                    <td>{{ $seller->total_transactions }}</td>
                                    <td>{{ $seller->last_transaction_at }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada pelapak aktif.</td>
                                </tr>
                            @endforelse
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
        const $table = $('#active-table');

        function applyFilter() {
            const q = $('#q').val().toLowerCase();
            const minTx = parseInt($('#min_tx').val() || '0', 10);
            const sort = $('#sort').val();

            let rows = [];
            $('#active-table tbody tr').each(function() {
                const $tr = $(this);
                const name = $tr.find('td:eq(0)').text().toLowerCase();
                const email = $tr.find('td:eq(1)').text().toLowerCase();
                const tx = parseInt($tr.find('td:eq(3)').text() || '0', 10);
                const last = $tr.find('td:eq(4)').text();

                const matchQ = !q || name.includes(q) || email.includes(q);
                const matchTx = tx >= minTx;
                if (matchQ && matchTx) {
                    rows.push({
                        row: $tr,
                        tx: tx,
                        last: last
                    });
                } else {
                    $tr.hide();
                }
            });

            // sorting
            rows.sort(function(a, b) {
                if (sort === 'tx_desc') return b.tx - a.tx;
                if (sort === 'tx_asc') return a.tx - b.tx;
                if (sort === 'last_asc') return a.last.localeCompare(b.last);
                return b.last.localeCompare(a.last); // default last_desc
            });

            $('#active-table tbody').empty();
            rows.forEach(r => {
                r.row.show();
                $('#active-table tbody').append(r.row);
            });

            if (rows.length === 0) {
                $('#active-table tbody').html('<tr><td colspan=\"5\" class=\"text-center text-muted\">Tidak ada data sesuai filter.</td></tr>');
            }
        }

        $('#q, #min_tx, #sort').on('input change', applyFilter);
    });
</script>
@endsection
