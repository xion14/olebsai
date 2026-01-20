<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="">OLEBSAI Seller</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="">OS</a>
        </div>
        <ul class="sidebar-menu">
            @if (Auth::user()->seller->status == 4)
                <li class="menu-header">Dashboard</li>
                <li class="dropdown" data-menu="seller-menu">
                    <a href="{{ url('/seller/dashboard') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                </li>
            @endif
            <li class="menu-header">Menu</li>
            <li>
                <a class="nav-link" href="{{ route('seller.profile') }}"><i
                        class="fas fa-user"></i><span>Profile</span></a>
            </li>
            @if (Auth::user()->seller->status == 4)
                <li class="dropdown" data-menu="transaction-menu">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-money-check"></i>
                        <span>Transaction</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('seller.transactions.confirmation.seller') }}">Seller
                                Confirmation</a></li>
                        <li><a class="nav-link" href="{{ route('seller.transactions.confirmation.admin') }}">Admin
                                Confirmation</a></li>
                        <li><a class="nav-link" href="{{ route('seller.transactions.waiting.payment') }}">Waiting
                                Payment</a></li>
                        <li><a class="nav-link" href="{{ route('seller.transactions.payment.done') }}">Payment Done</a>
                        </li>
                        <li><a class="nav-link" href="{{ route('seller.transactions.on.packing') }}">On Packing</a></li>
                        <li><a class="nav-link" href="{{ route('seller.transactions.on.delivery') }}">On Delivery</a>
                        </li>
                        <li><a class="nav-link" href="{{ route('seller.transactions.received') }}">Received</a></li>
                        <li><a class="nav-link" href="{{ route('seller.transactions.cancelled') }}">Cancelled</a></li>
                        <li><a class="nav-link" href="{{ route('seller.transactions.expired') }}">Expired</a></li>
                    </ul>

                </li>

                <li class="dropdown" data-menu="balance-menu">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-wallet"></i>
                        <span>Balance</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('seller.balance') }}">Balance History</a></li>
                    </ul>
                </li>

                <li class="dropdown" data-menu="whitedraw-menu">
                    <a href="{{ route('seller.withdraw') }}" class="nav-link"><i
                            class="fas fa-credit-card"></i>
                        <span>Withdraw</span>
                    </a>
                </li>
                <li class="dropdown" data-menu="product-menu">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-tags"></i>
                        <span>Product</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('seller.my-products') }}">My Product</a></li>
                    </ul>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('seller.products') }}">Register Product</a></li>
                    </ul>
                </li>
                <li class="dropdown" data-menu="product-menu">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-database"></i>
                        <span>Stock</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('seller.stock') }}">Report Stock</a></li>
                    </ul>
                </li>
                <li class="dropdown" data-menu="content-menu">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-image"></i>
                        <span>Content</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('seller.banners') }}">Banner Home</a></li>
                    </ul>

                </li>
                <li class="dropdown" data-menu="content-menu">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-chart-line"></i>
                        <span>Report</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('seller.transactions.report') }}">Transaction Report</a></li>
                    </ul>

                </li>
            @endif
        </ul>
    </aside>
</div>
