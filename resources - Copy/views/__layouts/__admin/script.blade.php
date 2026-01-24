<footer class="main-footer">
    <div class="footer-left">
        Copyright &copy; <a href="#">Olebsai 2025</a>
    </div>
    <div class="footer-right">

    </div>
</footer>
</div>
<!-- General JS Scripts -->
<script src="{{ asset('assets/panel/modules/jquery.min.js') }}"></script>
<script src="{{ asset('assets/panel/modules/popper.js') }}"></script>
<script src="{{ asset('assets/panel/modules/tooltip.js') }}"></script>
<script src="{{ asset('assets/panel/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/panel/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('assets/panel/modules/moment.min.js') }}"></script>
<script src="{{ asset('assets/panel/js/stisla.js') }}"></script>
<script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- JS Libraies -->
<script src="{{ asset('assets/datatables/datatables.min.js') }}"></script>
<!-- Page Specific JS File -->
<!-- Date Range Picker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<!-- Select2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css">

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<!-- Template JS File -->
<script src="{{ asset('assets/panel/js/scripts.js') }}"></script>
{{-- <script src="{{ asset('assets/admin/js/custom.js') }}"></script> --}}
<script src="{{ asset('utility/js/custom.js') }}"></script>
<script>
    @if (session('success'))
        sweetAlertSuccess("{{ session('success') }}")
    @endif

    @if (session('danger'))
        sweetAlertDanger("{{ 'danger' }}")
    @endif

    @if (session('error'))
        sweetAlertDanger("{{ session('error') }}")
    @endif

    @if (session('warning'))
        sweetAlertWarning("{{ 'warning' }}")
    @endif
</script>
<script type="text/javascript">
    $(document).ready(function() {
        let menuSellerActive = ["/admin/sellers", "/admin/sellers/confirmation", "/admin/sellers/failed"]
            .some(path => window.location.pathname.includes(path));
        let menuCustomerActive = ["/admin/customers", "/disabled-customers"]
            .some(path => window.location.pathname.includes(path));
        let menuSettingActive = ["/setting/units", "/setting/categories", "/setting/sub-categories"].some(path => window.location.pathname
            .includes(path));
        let menuProductActive = ["/admin/products", "/admin/products/confirmation"].some(path => window.location
            .pathname
            .includes(path));
        let menuContentActive = ["/admin/banners"].some(path => window.location
            .pathname
            .includes(path));
        let menuTransactionActive = ["/admin/transactions/seller/confirm", "/admin/transactions/admin/confirm",
                "/admin/transactions/waiting_payment", "/admin/transactions/payment_done",
                "/admin/transactions/on_packing", "/admin/transactions/on_delivery",
                "/admin/transactions/received", "/admin/transactions/cancelled"
            ]
            .some(path => window.location
                .pathname
                .includes(path));
        let menuBelanceActive = ["/admin/balance"].some(path => window.location
            .pathname
            .includes(path));
        let menuWhitedrawActive = ["/admin/withdraw"].some(path => window.location
            .pathname
            .includes(path));

        const $dropdownMenuSeller = $(".dropdown[data-menu='seller-menu'] .dropdown-menu");
        const $dropdownMenuCustomer = $(".dropdown[data-menu='customer-menu'] .dropdown-menu");
        const $dropdownMenuSetting = $(".dropdown[data-menu='setting-menu'] .dropdown-menu");
        const $dropdownProductSetting = $(".dropdown[data-menu='product-menu'] .dropdown-menu");
        const $dropdownContentSetting = $(".dropdown[data-menu='content-menu'] .dropdown-menu");
        const $dropdownTransactionSetting = $(".dropdown[data-menu='transaction-menu'] .dropdown-menu");
        const $dropdownBelanceSetting = $(".dropdown[data-menu='belance-menu'] .dropdown-menu");
        const $dropdownWhitedrawSetting = $(".dropdown[data-menu='whitedraw-menu'] .dropdown-menu");

        if (menuSellerActive) {
            $dropdownMenuSeller.css("display", "block");
        } else {
            $dropdownMenuSeller.css("display", "none");
        }

        if (menuCustomerActive) {
            $dropdownMenuCustomer.css("display", "block");
        } else {
            $dropdownMenuCustomer.css("display", "none");
        }

        if (menuSettingActive) {
            $dropdownMenuSetting.css("display", "block");
        } else {
            $dropdownMenuSetting.css("display", "none");
        }

        if (menuProductActive) {
            $dropdownProductSetting.css("display", "block");
        } else {
            $dropdownProductSetting.css("display", "none");
        }

        if (menuContentActive) {
            $dropdownContentSetting.css("display", "block");
        } else {
            $dropdownContentSetting.css("display", "none");
        }

        if (menuTransactionActive) {
            $dropdownTransactionSetting.css("display", "block");
        } else {
            $dropdownTransactionSetting.css("display", "none");
        }

        if (menuBelanceActive) {
            $dropdownBelanceSetting.css("display", "block");
        } else {
            $dropdownBelanceSetting.css("display", "none");
        }

        if (menuWhitedrawActive) {
            $dropdownWhitedrawSetting.css("display", "block");
        } else {
            $dropdownWhitedrawSetting.css("display", "none");
        }
    });
</script>


{{-- Notification Script --}}
<script>
    function getNotificationUnread() {
        $.ajax({
            headers: {
                'X-API-KEY': '{{ env('API_KEY') }}'
            },
            url: "/api/notification/admin/unread",
            type: "GET",
            success: function(response) {
                console.log(response);

                const data = response.data;
                const count = data.length;
                const dataIcon = {
                    'success': 'check',
                    'info': 'truck',
                    'danger': 'times',
                    'warning': 'bell'
                }
                $("#notification-list").html("");

                if (count > 0) {
                    $(".notification-toggle").addClass("beep");

                    data.forEach((item) => {
                        const {
                            id,
                            title,
                            content,
                            url,
                            type,
                            created_at
                        } = item;
                        const time = moment(created_at).fromNow();

                        const notification = `
                            <a href="javascript:void(0)" class="dropdown-item notificaiton-message" data-id="${id}" data-href="${url}">
                                <div class="dropdown-item-icon bg-${type} text-white">
                                    <i class="fas fa-${dataIcon[type]}"></i>
                                </div>
                                <div class="dropdown-item-desc">
                                    <div>
                                        <b>${title}</b>
                                        <p>${content}</p>    
                                    </div>
                                    <div class="time">${time}</div>
                                </div>
                            </a>
                        `;
                        $("#notification-list").append(notification);
                    });
                } else {
                    $(".notification-toggle").removeClass("beep");
                }
            }
        });
    }

    function markAsRead() {
        $.ajax({
            headers: {
                'X-API-KEY': '{{ env('API_KEY') }}'
            },
            url: "/api/notification/admin/mark-as-read/",
            type: "GET",
            success: function(response) {
                getNotificationUnread();
            }
        });
    }

    $('#notification-list').on('click', '.dropdown-item.notificaiton-message', function() {
        const id = $(this).data('id');
        const href = $(this).data('href');
        $.ajax({
            headers: {
                'X-API-KEY': '{{ env('API_KEY') }}'
            },
            url: "/api/notification/admin/mark-read/" + id,
            type: "GET",
            success: function(response) {
                window.location.href = href;
            }
        });
    });

    getNotificationUnread();
    setInterval(getNotificationUnread, 60000);
</script>

