<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="">OLEBSAI</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="">OS</a>
        </div>

        @php
            $role = auth()->user()->role ?? null;
            $menuMap = file_exists(storage_path('app/menu_roles.json'))
                ? json_decode(file_get_contents(storage_path('app/menu_roles.json')), true)
                : config('menu_roles');
            $can = function($keys) use ($role, $menuMap) {
                foreach((array)$keys as $k){
                    $allowed = $menuMap[$k] ?? [];
                    if(in_array($role, $allowed, true)) return true;
                }
                return false;
            };
        @endphp

        {{-- Role 5: SKPD Register --}}
        @if($can('dashboard_register'))
            <ul class="sidebar-menu">
                <li class="menu-header">Dashboard</li>
                <li><a href="{{ route('admin.register.dashboard') }}" class="nav-link"><i class="fas fa-clipboard-check"></i> <span>Dasbor SKPD</span></a></li>
                <li><a href="{{ route('admin.register.map') }}" class="nav-link"><i class="fas fa-map-marked-alt"></i> <span>Pemetaan Pelapak</span></a></li>
                <li><a href="{{ route('admin.register.coaching') }}" class="nav-link"><i class="fas fa-book-reader"></i> <span>Catatan Pembinaan</span></a></li>
                <li><a href="{{ route('admin.register.verify') }}" class="nav-link"><i class="fas fa-user-check"></i> <span>Verifikasi Pelapak</span></a></li>
            </ul>
        {{-- Role 6: Admin User --}}
        @elseif($can('dashboard_user'))
            <ul class="sidebar-menu">
                <li class="menu-header">Dashboard</li>
                <li><a href="{{ route('admin.user.dashboard') }}" class="nav-link"><i class="fas fa-fire"></i> <span>Dasbor Operasional</span></a></li>
                @if($can('seller_mgmt'))
                    <li class="menu-header">Pelapak</li>
                    <li><a href="{{ route('admin.sellers') }}" class="nav-link"><i class="fas fa-building"></i> <span>Data Pelapak</span></a></li>
                @endif
                @if($can('product_mgmt'))
                    <li class="menu-header">Product</li>
                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-box"></i> <span>Product</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('admin.products') }}">Products</a></li>
                            <li><a class="nav-link" href="{{ route('admin.products.confirmation') }}">Confirmation</a></li>
                            <li><a class="nav-link" href="{{ route('admin.products.disabled') }}">Produk Dinonaktifkan</a></li>
                        </ul>
                    </li>
                @endif
                @if($can('performance'))
                    <li><a href="{{ route('admin.sellers.performance') }}" class="nav-link"><i class="fas fa-chart-bar"></i> <span>Pemantauan Kinerja Pelapak</span></a></li>
                @endif
            </ul>
        {{-- Role 7: Admin Konsumen --}}
        @elseif($can('dashboard_consumer'))
            <ul class="sidebar-menu">
                <li class="menu-header">Dashboard</li>
                <li><a href="{{ route('admin.consumer.dashboard') }}" class="nav-link"><i class="fas fa-comments"></i> <span>Dasbor Komplain</span></a></li>
                <li><a href="{{ route('admin.consumer.complaints') }}" class="nav-link"><i class="fas fa-headset"></i> <span>Penanganan Komplain</span></a></li>
                <li><a href="{{ route('admin.consumer.reviews') }}" class="nav-link"><i class="fas fa-comment-alt"></i> <span>Pengawasan Ulasan</span></a></li>
                <li><a href="{{ route('admin.consumer.analysis') }}" class="nav-link"><i class="fas fa-chart-pie"></i> <span>Analisis Pola Masalah</span></a></li>
            </ul>
        {{-- Role 1/2 Admin --}}
        @else
            <ul class="sidebar-menu">
                <li class="menu-header">Dashboard</li>
                <li><a href="{{ url('/admin/dashboard') }}" class="nav-link"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>

                @if($can('admin_master'))
                <li class="menu-header">Admin Master</li>
                <li><a href="{{ route('admin.master.admins') }}" class="nav-link"><i class="fas fa-user-shield"></i> <span>Kelola Admin & Role</span></a></li>
                @endif

                @if($can('seller_mgmt'))
                <li class="menu-header">Menu</li>
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-building"></i> <span>Seller</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('admin.sellers') }}">Data Pelapak</a></li>
                        <li><a class="nav-link" href="{{ route('admin.sellers.active') }}">Pelapak Aktif</a></li>
                        <li><a class="nav-link" href="{{ route('admin.sellers.disabled') }}">Pelapak Dinonaktifkan</a></li>
                        <li><a class="nav-link" href="{{ route('admin.sellers.problematic') }}">Pelapak Bermasalah</a></li>
                        <li><a class="nav-link" href="{{ route('admin.sellers.performance') }}">Pemantauan Kinerja</a></li>
                        <li><a class="nav-link" href="{{ route('admin.sellers.master') }}">Data Pelapak & Toko</a></li>
                        <li><a class="nav-link" href="{{ route('admin.sellers.report.subsector') }}">Laporan Subsektor</a></li>
                        <li><a class="nav-link" href="{{ route('admin.sellers.report.oap') }}">Laporan OAP</a></li>
                        <li><a class="nav-link" href="{{ route('admin.sellers.confirmation') }}">Pendaftar Baru</a></li>
                        <li><a class="nav-link" href="{{ route('admin.sellers.failed') }}">Pendaftaran Gagal</a></li>
                    </ul>
                </li>
                @endif

                @if($can('product_mgmt'))
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-box"></i> <span>Product</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('admin.products') }}">Products</a></li>
                        <li><a class="nav-link" href="{{ route('admin.products.confirmation') }}">Confirmation</a></li>
                        <li><a class="nav-link" href="{{ route('admin.products.disabled') }}">Produk Dinonaktifkan</a></li>
                    </ul>
                </li>
                @endif

                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-database"></i> <span>Stock</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('admin.stock') }}">Report Stock</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-image"></i> <span>Contents</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('admin.banners') }}">Banner</a></li>
                        <li><a class="nav-link" href="{{ route('admin.information-bar.index') }}">Information</a></li>
                        <li><a class="nav-link" href="{{ route('admin.about-us') }}">About Us</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-exchange-alt"></i> <span>Transaction</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('admin.transactions.confirmation.seller') }}">Seller Confirmation</a></li>
                        <li><a class="nav-link" href="{{ route('admin.transactions.confirmation.admin') }}">Admin Confirmation</a></li>
                        <li><a class="nav-link" href="{{ route('admin.transactions.waiting.payment') }}">Waiting Payment</a></li>
                        <li><a class="nav-link" href="{{ route('admin.transactions.payment.done') }}">Payment Done</a></li>
                        <li><a class="nav-link" href="{{ route('admin.transactions.on.packing') }}">On Packing</a></li>
                        <li><a class="nav-link" href="{{ route('admin.transactions.on.delivery') }}">On Delivery</a></li>
                        <li><a class="nav-link" href="{{ route('admin.transactions.received') }}">Received</a></li>
                        <li><a class="nav-link" href="{{ route('admin.transactions.cancelled') }}">Cancelled</a></li>
                        <li><a class="nav-link" href="{{ route('admin.transactions.expired') }}">Expired</a></li>
                    </ul>
                </li>

                @if($can('balance'))
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-wallet"></i> <span>Balance History</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('admin.balance') }}">Seller Balance</a></li>
                        <li><a class="nav-link" href="{{ route('admin.balance.customer') }}">Customer Balance</a></li>
                    </ul>
                </li>
                @endif

                @if($can('withdraw'))
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-credit-card"></i> <span>Withdraw</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('admin.withdraw') }}">Seller Withdraw</a></li>
                        <li><a class="nav-link" href="{{ route('admin.withdraw.customer') }}">Customer Withdraw</a></li>
                    </ul>
                </li>
                @endif

                @if($can('report'))
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-chart-line"></i> <span>Report</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('admin.transactions.report') }}">Transaction Report</a></li>
                    </ul>
                </li>
                @endif

                <li><a class="nav-link" href="{{ route('admin.complaints.master') }}"><i class="fas fa-headset"></i> <span>Pusat Komplain</span></a></li>
                <li><a class="nav-link" href="{{ route('admin.register.dashboard') }}"><i class="fas fa-clipboard-check"></i> <span>Dasbor SKPD</span></a></li>
            </ul>
        @endif
    </aside>
</div>
