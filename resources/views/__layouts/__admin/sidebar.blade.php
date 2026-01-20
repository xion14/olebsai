<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="">OLEBSAI</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="">OS</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="dropdown">
                <a href="{{ url('/admin/dashboard') }}" class="nav-link">
                    <i class="fas fa-fire"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="menu-header">Menu</li>
            <li class="dropdown" data-menu="seller-menu">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-building"></i> <span>Seller</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.sellers') }}">Registrations</a></li>
                    <li><a class="nav-link" href="{{ route('admin.sellers.confirmation') }}">Confirmation</a></li>
                    <li><a class="nav-link" href="{{ route('admin.sellers.failed') }}">Failed</a></li>
                </ul>
            </li>
            <li class="dropdown" data-menu="customer-menu">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-users"></i> <span>Customer</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.customers.index') }}">List Customer</a></li>
                </ul>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.customers.disabled') }}">Disabled Customer</a></li>
                </ul>
            </li>
            <li class="dropdown" data-menu="setting-menu">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-cog"></i> <span>Settings</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.setting.units') }}">Setting Units</a></li>
                    <li><a class="nav-link" href="{{ route('admin.setting.categories') }}">Setting Categories</a></li>
					<li><a class="nav-link" href="{{ route('admin.setting.sub-categories') }}">Setting Sub Categories</a></li>
                    <li><a class="nav-link" href="{{ route('admin.setting-cost') }}">Setting Cost</a></li>
                    <li><a class="nav-link" href="{{ url('admin/setting/contact-admin') }}">Contact Admin</a></li>
                </ul>
            </li>
            <li class="dropdown" data-menu="product-menu">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-box"></i> <span>Product</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.products') }}">Products</a></li>
                </ul>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.products.confirmation') }}">Confirmation</a></li>
                </ul>
            </li>
            <li class="dropdown" data-menu="product-menu">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-database"></i>
                        <span>Stock</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('admin.stock') }}">Report Stock</a></li>
                    </ul>
                </li>
            <li class="dropdown" data-menu="content-menu">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-image"></i> <span>Contents</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.banners') }}">Banner Home</a></li>
                </ul>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ url('admin/information-bar') }}">Information Bar</a></li>
                </ul>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.about-us') }}">About Us</a></li>
                </ul>
            </li>
            <li class="dropdown" data-menu="content-menu">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-gift"></i> <span>Voucher</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.vouchers') }}">Voucher</a></li>
                </ul>
               
            </li>
            <li class="dropdown" data-menu="transaction-menu">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fas fa-money-check"></i>
                    <span>Transaction</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.transactions.confirmation.seller') }}">Seller
                            Confirmation</a></li>
                    <li><a class="nav-link" href="{{ route('admin.transactions.confirmation.admin') }}">Admin
                            Confirmation</a></li>
                    <li><a class="nav-link" href="{{ route('admin.transactions.waiting.payment') }}">Waiting
                            Payment</a></li>
                    <li><a class="nav-link" href="{{ route('admin.transactions.payment.done') }}">Payment Done</a></li>
                    <li><a class="nav-link" href="{{ route('admin.transactions.on.packing') }}">On Packing</a></li>
                    <li><a class="nav-link" href="{{ route('admin.transactions.on.delivery') }}">On Delivery</a></li>
                    <li><a class="nav-link" href="{{ route('admin.transactions.received') }}">Received</a></li>
                    <li><a class="nav-link" href="{{ route('admin.transactions.cancelled') }}">Cancelled</a></li>
                    <li><a class="nav-link" href="{{ route('admin.transactions.expired') }}">Expired</a></li>
                </ul>
            </li>
            <li class="dropdown" data-menu="belance-menu">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-wallet"></i>
                    <span>Balance History</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.balance') }}">Seller Balance</a></li>
                </ul>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.balance.customer') }}">Customer Balance</a></li>
                </ul>
            </li>
            <li class="dropdown" data-menu="whitedraw-menu">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fas fa-credit-card"></i>
                    <span>Withdraw</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.withdraw') }}">Seller Withdraw</a></li>
                </ul>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.withdraw.customer') }}">Customer Withdraw</a></li>
                </ul>
            </li>

            <li class="dropdown" data-menu="content-menu">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-chart-line"></i>
                        <span>Report</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('admin.transactions.report') }}">Transaction Report</a></li>
                    </ul>

                </li>
        </ul>
    </aside>
</div>
