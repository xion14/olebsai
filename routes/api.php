<?php

use App\Http\Controllers\admin\BannerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\seller\AuthController as AuthSeller;
use App\Http\Controllers\api\AuthController as AuthCustomer;
use App\Http\Controllers\AuthController as Auth;
use App\Http\Controllers\api\CustomerAddressController as CustomerAddress;
use App\Http\Controllers\api\CategoryController as Category;
use App\Http\Controllers\api\ProductController as Product;
use App\Http\Controllers\api\CustomerCartController as CustomerCart;
use App\Http\Controllers\api\BannerController as Banner;
use App\Http\Controllers\api\TransactionController as Transaction;
use App\Http\Controllers\api\SellerController as Seller;
use App\Http\Controllers\api\InformationBarController as InformationBar;
use App\Http\Controllers\api\AboutUsController as AboutUs;
use App\Http\Controllers\api\DeliveryController as Delivery;
use App\Http\Controllers\api\DashboardController as Dashboard;
use App\Http\Controllers\api\NotificationController as Notification;
use App\Http\Controllers\api\BalanceController as Balance;
use App\Http\Controllers\api\WithdrawController as Withdraw;
use App\Http\Controllers\api\VoucherController as Voucher;
use App\Http\Controllers\api\RajaOngkirController as RajaOngkir;


use App\Http\Controllers\ResetPasswordController as ResetPassword;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['api_key'])->group(function () {
    Route::controller(RajaOngkir::class)->group(function () {
        Route::get('/rajaongkir/get-provinces', 'get_provinces')->name('api.rajaongkir.provinces');
        Route::get('/rajaongkir/get-cities', 'get_cities')->name('api.rajaongkir.cities');
        Route::get('/rajaongkir/get-districts', 'get_districts')->name('api.rajaongkir.districts');
        Route::get('/rajaongkir/check-costs', 'check_costs')->name('api.rajaongkir.costs');
    });

    Route::controller(AuthSeller::class)->group(function () {
        Route::post('/seller/register', 'store')->name('api.seller.register.store');
    });

    Route::controller(ResetPassword::class)->group(function () {
        Route::post('/request-reset-password', 'request_code')->name('api.request-reset-password');
        Route::post('/reset-password', 'reset_password')->name('api.reset-password');
    });

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::controller(AuthCustomer::class)->group(function () {
    // Route::middleware->('api-session')->controller(AuthCustomer::class)->group(function () {
        Route::post('/customer/register', 'store')->name('api.customer.register.store');
        Route::post('/customer/update/{id}', 'update')->name('api.customer.update');
        Route::get('/customer/detail/{id}', 'show')->name('api.customer.show');
        Route::post('/customer/validate-code', 'validate_code')->name('api.customer.validate-code');
        Route::post('/customer/resend-code', 'resend_code')->name('api.customer.resend-code');
        Route::post('/customer/update/image-profile/{id}', 'update_image_profile')->name('api.customer.update_image_profile');
        Route::post('/customer/update-password/{id}', 'update_password')->name('api.customer.update_password');
        Route::post('/customer/add-bank-account/{id}', 'add_bank_account')->name('api.customer.add_bank_account');
    });

    Route::controller(BannerController::class)->group(function () {
        Route::get('/banner/get-all', 'index')->name('api.banners.index');
    });

    Route::controller(CustomerAddress::class)->group(function () {
        Route::get('/customer/get/address', 'index')->name('api.customer.address.index');
        Route::get('/customer/get/active-address', 'active')->name('api.customer.address.active');
        Route::post('/customer/add/address', 'store')->name('api.customer.address.store');
        Route::post('/customer/update/address/{id}', 'update')->name('api.customer.address.update');
        Route::post('/customer/delete/address/{id}', 'destroy')->name('api.customer.address.destroy');
    });

    Route::controller(Banner::class)->group(function () {
        Route::get('/banner', 'index')->name('api.banner.index');
    });

    Route::controller(Category::class)->group(function () {
        Route::get('/categories', 'index')->name('api.categories.index');
        Route::get('/categories/products', 'getCategoryWithProducts')->name('api.categories.get-product');
    });

    Route::controller(Product::class)->group(function () {
        Route::get('/products', 'index')->name('api.products.index');
        Route::get('/product/{slug}', 'show')->name('api.products.show');
        Route::get('/products/best-sellers', 'bestSeller')->name('api.products.bestsellers');
        Route::get('/products/search-recomendation', 'searchRecomendation')->name('api.products.search-recomendation');
        Route::get('/products/shop', 'shop')->name('api.products.shop');
        Route::get('/products/recomendation', 'recomendation')->name('api.products.recomendation');
    });

    Route::controller(CustomerCart::class)->group(function () {
        Route::get('/customer/get/cart', 'index')->name('api.customer.cart.index');
        Route::post('/customer/add/cart', 'store')->name('api.customer.cart.store');
        Route::post('/customer/update/cart/{id}', 'update')->name('api.customer.cart.update');
        Route::post('/customer/delete/cart/{id}', 'destroy')->name('api.customer.cart.destroy');
    });


    Route::controller(Transaction::class)->group(function () {
        Route::get('/customer/get/transaction', 'index')->name('api.customer.transaction.index');
        Route::post('/transaction/create', 'store')->name('api.customer.transaction.store');
        Route::post('/transaction/payment', 'payment')->name('api.customer.transaction.payment');
        Route::post('/transaction/received', 'received')->name('api.customer.transaction.received');
        Route::post('/transaction/cancel', 'cancel')->name('api.customer.transaction.cancel');
        Route::post('/transaction/cart', 'cart')->name('api.customer.transaction.cart');
    });

    Route::controller(AboutUs::class)->group(function () {
        Route::get('/about-us', 'index')->name('api.about-us.index');
    });

    Route::controller(Delivery::class)->group(function () {
        Route::get('/delivery', 'index')->name('api.delivery.index');
        Route::post('/delivery', 'store')->name('api.delivery.store');
    });

    Route::controller(Notification::class)->group(function () {
        Route::get('/notification/user/unread', 'get_unread_user')->name('api.notification.get-unread-user');
        Route::get('/notification/admin/unread', 'get_unread_admin')->name('api.notification.get-unread-admin');
        Route::get('/notification/seller/unread', 'get_unread_seller')->name('api.notification.get-unread-seller');
        Route::post('/notification/user/read', 'read_user')->name('api.notification.read-user');
        Route::post('/notification/admin/read', 'read_admin')->name('api.notification.read-admin');
        Route::post('/notification/seller/read', 'read_seller')->name('api.notification.read-seller');
        Route::get('/notification/user', 'get_user')->name('api.notification.get-user');
        Route::get('/notification/admin', 'get_admin')->name('api.notification.get-admin');
        Route::get('/notification/seller', 'get_seller')->name('api.notification.get-seller');
        Route::delete('/notification/user/{id}', 'destroy_notif_user')->name('api.notification.destroy-notif-user');
        Route::delete('/notification/admin/{id}', 'destroy_notif_admin')->name('api.notification.destroy-notif-admin');
        Route::delete('/notification/seller/{id}', 'destroy_notif_seller')->name('api.notification.destroy-notif-seller');
        Route::get('/notification/user/mark-as-read/{id}', 'mark_as_read_user')->name('api.notification.mark-as-read-user');
        Route::get('/notification/admin/mark-as-read', 'mark_as_read_admin')->name('api.notification.mark-as-read-admin');
        Route::get('/notification/seller/mark-as-read/{id}', 'mark_as_read_seller')->name('api.notification.mark-as-read-seller');
        Route::get('/notification/seller/mark-read/{id}', 'mark_read_seller')->name('api.notification.mark-read-seller');
        Route::get('/notification/user/mark-read/{id}', 'mark_read_user')->name('api.notification.mark-read-user');
        Route::get('/notification/admin/mark-read/{id}', 'mark_read_admin')->name('api.notification.mark-read-admin');
    });

    //voucher
    Route::controller(Voucher::class)->group(function () {
        Route::get('/voucher', 'get_all_voucher')->name('api.voucher.all');
        Route::get('/voucher-active', 'get_active_voucher')->name('api.voucher.active');
    });
});

Route::controller(Transaction::class)->group(function () {
    Route::post('/handle-midtrans-notifications', 'handle_notification')->name('api.customer.transaction.handle-notifications');
});

Route::controller(InformationBar::class)->group(function () {
    Route::get('/information-bar', 'index')->name('api.information-bar.index');
});


Route::controller(AuthCustomer::class)->group(function () {
    // Route::get('/customer/login', 'index');
    Route::post('/customer/login', 'login')->middleware('api-session')->name('api.customers.login');
    Route::get('/customer/logout', 'logout')->name('api.customers.logout');
});

Route::controller(Seller::class)->group(function () {
    Route::get('/seller/product', 'get_seller_product')->name('api.seller.product');
    Route::get('/seller/banner', 'get_seller_banner')->name('api.seller.banner');
    Route::get('/seller/details', 'get_detail_seller')->name('api.seller.details');
    Route::get('/seller/products', 'get_seller_products')->name('api.seller.products');
});

//API DASHBOARD
Route::controller(Dashboard::class)->group(function () {
    Route::get('/dashboard/card-data', 'cardData')->name('api.dashboard.card-data');
    Route::get('/dashboard/transaction-statistic', 'TransactionStatistic')->name('api.dashboard.transaction-statistic');
    Route::get('/dashboard/balance-graph-per-date', 'balanceGraphPerDate')->name('api.dashboard.balance-graph-per-date');
    Route::get('/dashboard/withdraw-graph-per-date', 'withdrawGraphPerDate')->name('api.dashboard.withdraw-graph-per-date');
    Route::get('/dashboard/revenue-vs-order', 'revenueVsOrder')->name('api.dashboard.revenue-vs-order');
    Route::get('/dashboard/top-product', 'topProduct')->name('api.dashboard.top-product');

    Route::get('/dashboard/balance-data-seller','getBalanceInfoSeller')->name('api.dashboard.balance-data-seller');
    Route::get('/dashboard/transaction-data','getTransactionInfoSeller')->name('api.dashboard.transaction-data-seller');
    Route::get('/dashboard/admin-card-data','adminCardData')->name('api.dashboard.admin-card-data');
    Route::get('/dashboard/balance-data-admin','getBalanceInfoAdmin')->name('api.dashboard.balance-data-admin');
    Route::get('/dashboard/admin-product-confirmation','getProductConfirmationAdmin')->name('api.dashboard.admin-product-confirmation');
    Route::get('/dashboard/admin-seller-confirmation','getSellerConfirmation')->name('api.dashboard.admin-seller-confirmation');
    
});

//API CUSTOMER BALANCE
Route::controller(Balance::class)->group(function () {
    Route::get('/customer/balance', 'index')->name('api.customer.balance.index');
    Route::get('/customer/check-available-balance', 'checkAvailableBalance')->name('api.customer.balance.check-available-balance');
});

//API CUSTOMER WITHDRAW
Route::controller(Withdraw::class)->group(function () {
    Route::get('/withdraw', 'index')->name('api.withdraw.index');
    Route::post('/withdraw', 'store')->name('api.withdraw.store');
});

