<section class="py-2" style="background-color: #86ccf3;">
    <div class="container-lg d-flex justify-content-between align-items-center" style="font-size: 14px;">
        <small class="d-none d-lg-block" id="information-bar">

        </small>
        <div class="d-flex gap-1">
            <button type="submit" onclick="window.location.href='{{ url('/shop') }}'"
                class="btn p-0 border-0 mx-3 fw-semibold">Belanja</button>
            <button type="button" onclick="window.location.href='{{ url('/about-us') }}'"
                class="btn p-0 border-0 mx-3 fw-semibold">Tentang Kami</button>
        </div>
    </div>
</section>
<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container-lg py-1">
        <div class="d-flex">
            <div class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation" class="border:none;">
                <span class="navbar-toggler-icon"></span>
            </div>
            <button onclick="window.location.href='{{ url('/') }}'"
                class="d-flex flex-row align-items-center border-0 bg-transparent mr-md-5">
                <img src="{{ asset('assets/image/brand/logo-brand.png') }}" alt="Logo" width="50"
                    height="auto">
                <span class="d-none d-md-block ms-2 fw-bold">Olebsai</span>
            </button>
        </div>
        <div class="d-flex d-lg-none gap-2">
            @if (session('customer_already_login') === true)
                <button type="button" class="btn position-relative"
                    onclick="window.location.href='{{ url('/checkout-cart') }}'">
                    <i class="bi bi-cart3 text-primary" style="font-size: 24px;"></i>
                    <span
                        class="position-absolute top-0 start-100 translate-middle d-flex align-items-center justify-content-center bg-danger border border-light rounded-circle btn-cart d-none"
                        style="width: 1.5rem; height: 1.5rem;">
                        <span class="text-white p-0 m-0 text-qty-cart" style="font-size: 10px;">

                        </span>
                    </span>
                </button>
            @else
                <button type="button" class="btn position-relative"
                    onclick="window.location.href='{{ url('/login') }}'">
                    <i class="bi bi-cart3 text-primary" style="font-size: 24px;"></i>
                </button>
            @endif

            @if (session('customer_already_login') === true)
                <button type="button" class="btn position-relative" data-bs-toggle="modal"
                    data-bs-target="#exampleModalNotifikasi">
                    <i class="bi bi-bell text-primary" style="font-size: 24px;"></i>
                    <span
                        class="position-absolute top-0 start-100 translate-middle d-flex align-items-center justify-content-center bg-danger border border-light rounded-circle badge-notification d-none"
                        style="width: 1.5rem; height: 1.5rem;">
                        <span class="text-white p-0 m-0 text-qty-notif" style="font-size: 10px;"></span>
                    </span>
                </button>
            @else
                <button type="button" class="btn position-relative" data-bs-toggle="modal"
                    data-bs-target="#exampleModalNotifikasi">
                    <i class="bi bi-bell text-primary" style="font-size: 24px;"></i>
                </button>
            @endif
            @if (session('customer_already_login') === true)
                <button type="button" class="button-icon" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasSettingProfile" aria-controls="offcanvasSettingProfile">
                    <i class="bi bi-person-circle" style="font-size: 24px;"></i>
                </button>
            @else
                <button type="button" class="button-icon" onclick="window.location.href='{{ url('/login') }}'">
                    <i class="bi bi-person-circle" style="font-size: 24px;"></i>
                </button>
            @endif
        </div>

        <div class="collapse navbar-collapse pt-2 pb-2 mt-md-0" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-3 mb-lg-0 mx-lg-5 w-100">
                @if (session('customer_already_login') === true)
                    <button type="button" onclick="window.location.href='{{ url('/voucher-user') }}'"
                        class="btn btn-primary text-white mb-2 mb-lg-0 mx-0 mx-lg-2 text-nowrap">
                        <i class="fa-solid fa-ticket"></i>
                        <span class="d-inline-block mx-1">Voucher</span>
                    </button>
                @endif
                <button type="button" onclick="window.location.href='{{ url('/shop') }}'"
                    class="btn btn-primary text-white mb-2 mb-lg-0 mx-0 mx-lg-2 text-nowrap">
                    <i class="fa-solid fa-grip"></i>
                    <span class="d-inline-block mx-1">Belanja</span>
                </button>
                <form class="d-flex justify-content-start w-100 position-relative" role="search_filter_shop"
                    action="{{ url('shop') }}">
                    <input class="form-control-search" type="search_filter_shop" name="search_filter_shop"
                        placeholder="Temukan di olebsai" value="{{ @$_GET['search_filter_shop'] }}" aria-label="Search"
                        id="searchInput">
                    <i class="fa-solid fa-magnifying-glass position-absolute top-50 translate-middle-y"
                        style="left:0.875rem; color: #A6A6A6;"></i>

                    <ul id="searchSuggestions" class="dropdown-menu w-100 position-absolute d-none mt-5"></ul>
                </form>
            </ul>
            <div class="w-fit d-none d-lg-flex justify-content-start align-items-center gap-4">
                @if (session('customer_already_login') === true)
                    <button type="button" class="btn position-relative"
                        onclick="window.location.href='{{ url('/checkout-cart') }}'">
                        <i class="bi bi-cart3 text-primary" style="font-size: 22px;"></i>
                        <span id="alert-notification-cart"
                            class="position-absolute top-0 start-100 translate-middle d-flex align-items-center justify-content-center bg-danger border border-light rounded-circle btn-cart d-none"
                            style="width: 1.5rem; height: 1.5rem;">
                            <span class="text-white p-0 m-0 text-qty-cart" style="font-size: 10px;">

                            </span>
                        </span>
                    </button>
                @else
                    <button type="button" class="btn position-relative"
                        onclick="window.location.href='{{ url('/login') }}'">
                        <i class="bi bi-cart3 text-primary" style="font-size: 22px;"></i>
                    </button>
                @endif

                @if (session('customer_already_login') === true)
                    <button type="button" class="btn position-relative" data-bs-toggle="modal"
                        data-bs-target="#exampleModalNotifikasi">
                        <i class="bi bi-bell text-primary" style="font-size: 22px;"></i>
                        <span
                            class="position-absolute top-0 start-100 translate-middle d-flex align-items-center justify-content-center bg-danger border border-light rounded-circle badge-notification d-none"
                            style="width: 1.5rem; height: 1.5rem;">
                            <span class="text-white p-0 m-0 text-qty-notif" style="font-size: 10px;">

                            </span>
                        </span>
                    </button>
                @else
                    <button type="button" class="btn position-relative" data-bs-toggle="modal"
                        data-bs-target="#exampleModalNotifikasi">
                        <i class="bi bi-bell text-primary" style="font-size: 22px;"></i>
                    </button>
                @endif
                @if (session('customer_already_login') === true)
                    <button type="button" class="btn btn-primary text-white text-nowrap" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasSettingProfile" aria-controls="offcanvasSettingProfile">
                        <i class="fa-solid fa-circle-user"></i>
                        <span class="d-inline-block mx-1">{{ session('name_customer') }}</span>
                    </button>
                @else
                    <button type="button" class="btn btn-primary text-white text-nowrap"
                        onclick="window.location.href='{{ url('/login') }}'">
                        <i class="fa-solid fa-circle-user"></i>
                        <span class="d-inline-block mx-1">Profile</span>
                    </button>
                @endif
            </div>
        </div>
    </div>
</nav>

<div class="modal fade" id="exampleModalNotifikasi" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Notifikasi Kamu</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" value="{{ session('user_id') }}" name="id" id="notification_id">
                <div class="w-100 d-flex align-items-center justify-content-end mb-2">
                    @if (session('customer_already_login') === true)
                        <a id="markAllAsReadUser"
                            class="link-offset-2 link-underline link-underline-opacity-0 d-flex align-items-center gap-2 fw-bold lihat-detail"
                            href="#"style="font-size: 12px; line-height: 1.5;">
                            Tandai semua sudah dibaca
                        </a>
                    @else
                    @endif
                </div>
                <section id="notificationList" class="d-flex flex-column gap-3">

                </section>
            </div>
        </div>
    </div>
</div>

{{-- Setting Profile Start --}}
<div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasSettingProfile"
    aria-labelledby="offcanvasSettingProfileLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title fs-6" id="offcanvasSettingProfileLabel">Pengaturan Akun</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0 m-0 position-relative">
        <div class="d-flex align-items-center gap-4 my-2 px-4">
            <img id="imageProfileMain" src="{{ asset('assets/image/profile/profile.jpeg') }}" alt="Profile"
                class="rounded-circle object-fit-cover "
                style="width: 6rem; height: 6rem; overflow: hidden; flex-shrink: 0; object-position: top;">
            <div class="d-flex flex-column">
                <strong id="profileNameMain" class="fw-bold" style="font-size: 18px; line-height: 1.5rem"></strong>
                <span id="profileEmailMain" class="fw-medium fs-6" style="word-break: break-all"></span>
            </div>
        </div>
        <ul class="px-4 my-4">
            <li class="list-group-item mb-2">
                <div onclick="window.location.href='{{ url('/user-setting') }}'"
                    class="w-100 py-1 d-flex align-items-center gap-4 justify-content-between"
                    style="cursor: pointer;">
                    <div class="d-flex align-items-center gap-3">
                        <button type="button" class="btn-icon-setting">
                            <i class="fa-solid fa-user-pen"></i>
                        </button>
                        <span class="fw-semibold fs-6">Ubah Profile</span>
                    </div>
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </li>
            <li class="list-group-item mb-2">
                <div onclick="window.location.href='{{ url('/address-setting') }}'"
                    class="w-100 py-1 d-flex align-items-center gap-4 justify-content-between"
                    style="cursor: pointer;">
                    <div class="d-flex align-items-center gap-3">
                        <button type="button" class="btn-icon-setting">
                            <i class="fa-solid fa-map"></i>
                        </button>
                        <span class="fw-semibold fs-6">Daftar Alamat</span>
                    </div>
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </li>
            <li class="list-group-item mb-2">
                <div onclick="window.location.href='{{ url('/order-history') }}'"
                    class="w-100 py-1 d-flex align-items-center gap-4 justify-content-between"
                    style="cursor: pointer;">
                    <div class="d-flex align-items-center gap-3">
                        <button type="button" class="btn-icon-setting">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </button>
                        <span class="fw-semibold fs-6">Transaksi</span>
                    </div>
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </li>
            <li class="list-group-item mb-2">
                <div class="w-100 py-1 d-flex align-items-center gap-4 justify-content-between"
                    style="cursor: pointer;">
                    <div onclick="window.location.href='{{ url('/waiting-payment') }}'"
                        class="d-flex align-items-center gap-3">
                        <button type="button" class="btn-icon-setting">
                            <i class="fa-solid fa-basket-shopping"></i>
                        </button>
                        <span class="fw-semibold fs-6">Menunggu Pembayaran</span>
                    </div>
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </li>
            <li class="list-group-item mb-2">
                <div class="w-100 py-1 d-flex align-items-center gap-4 justify-content-between"
                    style="cursor: pointer;">
                    <div onclick="window.location.href='{{ url('/waiting-confirmation') }}'"
                        class="d-flex align-items-center gap-3">
                        <button type="button" class="btn-icon-setting">
                            <i class="bi bi-check-circle-fill"></i>
                        </button>
                        <span class="fw-semibold fs-6">Menunggu Konfirmasi</span>
                    </div>
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </li>
            <li class="list-group-item mb-2">
                <div class="w-100 py-1 d-flex align-items-center gap-4 justify-content-between"
                    style="cursor: pointer;">
                    <div onclick="window.location.href='{{ url('/get-saldo-user') }}'"
                        class="d-flex align-items-center gap-3">
                        <button type="button" class="btn-icon-setting">
                            <i class="fa-solid fa-hand-holding-dollar"></i>
                        </button>
                        <span class="fw-semibold fs-6">Penarikan Saldo</span>
                    </div>
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </li>
        </ul>
        <div class="w-100 px-4 px-lg-4 position-absolute" style="bottom: 1rem; right: 0;">
            <button type="button" id="btnLogout"
                class="w-100 d-flex flex-row align-items-center py-3 btn-error mb-2 mb-lg-0 mx-0 mx-lg-2 text-nowrap">
                <i class="fa-solid fa-right-from-bracket" style="font-size: 20px;"></i>
                <span class="d-inline-block mx-1">Keluar Sekarang</span>
            </button>
        </div>
    </div>
</div>
{{-- Setting Profile End --}}
