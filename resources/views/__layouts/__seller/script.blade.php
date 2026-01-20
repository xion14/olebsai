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
        let menuDashboardSellerActive = ["/seller/dashboard"].some(path => window.location
            .pathname
            .includes(path));
        let menuTransactionActive = ["/seller/transactions/seller/confirm",
                "/seller/transactions/admin/confirm",
                "/seller/transactions/waiting_payment", "/seller/transactions/payment_done",
                "/seller/transactions/on_packing", "/seller/transactions/on_delivery",
                "/seller/transactions/received", "/seller/transactions/cancelled"
            ]
            .some(path => window.location
                .pathname
                .includes(path));
        let menuBelanceActive = ["/seller/balance"].some(path => window.location
            .pathname
            .includes(path));
        let menuWhitedrawActive = ["/seller/withdraw"].some(path => window.location
            .pathname
            .includes(path));
        let menuProductActive = ["/seller/my-products", "/seller/products"].some(path => window.location
            .pathname
            .includes(path));
        let menuContentActive = ["/seller/banners"].some(path => window.location
            .pathname
            .includes(path));

        const $dropdownMenuSeller = $(".dropdown[data-menu='seller-menu'] .dropdown-menu");
        const $dropdownTransactionSetting = $(".dropdown[data-menu='transaction-menu'] .dropdown-menu");
        const $dropdownBelence = $(".dropdown[data-menu='balance-menu'] .dropdown-menu");
        const $dropdownWhitedraw = $(".dropdown[data-menu='whitedraw-menu'] .dropdown-menu");
        const $dropdownProduct = $(".dropdown[data-menu='product-menu'] .dropdown-menu");
        const $dropdownContent = $(".dropdown[data-menu='content-menu'] .dropdown-menu");

        if (menuDashboardSellerActive) {
            $dropdownMenuSeller.css("display", "block");
        } else {
            $dropdownMenuSeller.css("display", "none");
        }

        if (menuTransactionActive) {
            $dropdownTransactionSetting.css("display", "block");
        } else {
            $dropdownTransactionSetting.css("display", "none");
        }

        if (menuBelanceActive) {
            $dropdownBelence.css("display", "block");
        } else {
            $dropdownBelence.css("display", "none");
        }

        if (menuWhitedrawActive) {
            $dropdownWhitedraw.css("display", "block");
        } else {
            $dropdownWhitedraw.css("display", "none");
        }

        if (menuProductActive) {
            $dropdownProduct.css("display", "block");
        } else {
            $dropdownProduct.css("display", "none");
        }

        if (menuContentActive) {
            $dropdownContent.css("display", "block");
        } else {
            $dropdownContent.css("display", "none");
        }
    });
</script>

{{-- Notification Script --}}
<script>
    const userId = "{{ Auth::user()->id }}";

    function getNotificationUnread() {
        $.ajax({
            headers: {
                'X-API-KEY': '{{ env('API_KEY') }}'
            },
            url: "/api/notification/seller/unread",
            type: "GET",
            data: {
                user_id: userId
            },
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
            url: "/api/notification/seller/mark-as-read/" + userId,
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
            url: "/api/notification/seller/mark-read/" + id,
            type: "GET",
            success: function(response) {
                window.location.href = href;
            }
        });
    });

    getNotificationUnread();
    setInterval(getNotificationUnread, 60000);
</script>

<!-- Moment.js (Dibutuhkan untuk Date Range Picker) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

<!-- Date Range Picker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<!-- Select2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css">

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
