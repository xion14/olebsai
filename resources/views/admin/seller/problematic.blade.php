@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pelapak Bermasalah</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active">Pelapak Bermasalah</div>
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
                            <label class="form-label">Minimal Total Isu</label>
                            <input type="number" id="min_issue" class="form-control" min="0" value="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Urutkan</label>
                            <select id="sort" class="form-control">
                                <option value="issue_desc">Total isu (banyak)</option>
                                <option value="issue_asc">Total isu (sedikit)</option>
                                <option value="last_desc">Terakhir isu (baru)</option>
                                <option value="last_asc">Terakhir isu (lama)</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped" id="problematic-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Komplain</th>
                                <th>Batal/Expired</th>
                                <th>Total Isu</th>
                                <th>Terakhir Isu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sellers as $seller)
                                <tr>
                                    <td>{{ $seller->name }}</td>
                                    <td>{{ $seller->email }}</td>
                                    <td>{{ $seller->phone }}</td>
                                    <td>{{ $seller->complaints }}</td>
                                    <td>{{ $seller->cancelled_orders }}</td>
                                    <td>{{ $seller->total_issues }}</td>
                                    <td>{{ $seller->last_issue_at }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Tidak ada pelapak bermasalah.</td>
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
        function applyFilter() {
            const q = $('#q').val().toLowerCase();
            const minIssue = parseInt($('#min_issue').val() || '0', 10);
            const sort = $('#sort').val();

            let rows = [];
            $('#problematic-table tbody tr').each(function() {
                const $tr = $(this);
                const name = $tr.find('td:eq(0)').text().toLowerCase();
                const email = $tr.find('td:eq(1)').text().toLowerCase();
                const complaints = parseInt($tr.find('td:eq(3)').text() || '0', 10);
                const cancelled = parseInt($tr.find('td:eq(4)').text() || '0', 10);
                const total = parseInt($tr.find('td:eq(5)').text() || '0', 10);
                const last = $tr.find('td:eq(6)').text();

                const matchQ = !q || name.includes(q) || email.includes(q);
                const matchIssue = total >= minIssue;
                if (matchQ && matchIssue) {
                    rows.push({row: $tr, total, complaints, cancelled, last});
                } else {
                    $tr.hide();
                }
            });

            rows.sort(function(a, b) {
                if (sort === 'issue_asc') return a.total - b.total;
                if (sort === 'issue_desc') return b.total - a.total;
                if (sort === 'last_asc') return a.last.localeCompare(b.last);
                return b.last.localeCompare(a.last); // last_desc default
            });

            $('#problematic-table tbody').empty();
            rows.forEach(r => {
                r.row.show();
                $('#problematic-table tbody').append(r.row);
            });

            if (rows.length === 0) {
                $('#problematic-table tbody').html('<tr><td colspan=\"7\" class=\"text-center text-muted\">Tidak ada data sesuai filter.</td></tr>');
            }
        }

        $('#q, #min_issue, #sort').on('input change', applyFilter);
    });
</script>
@endsection
