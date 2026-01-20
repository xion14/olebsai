<?php

use App\Http\Controllers\admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Exports\SellerTransactionExport;
use App\Exports\AdminTransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;



use App\Http\Controllers\AuthController as Auth;
use App\Http\Controllers\admin\DashboardController as DashboardAdmin;
use App\Http\Controllers\admin\SettingUnitController as SettingUnitAdmin;
use App\Http\Controllers\admin\SettingCategoryController as SettingCategoryAdmin;
use App\Http\Controllers\admin\SettingSubCategoryController as SettingSubCategoryAdmin;
use App\Http\Controllers\admin\UserController as UserAdmin;
use App\Http\Controllers\admin\SellerController as SellerAdmin;
use App\Http\Controllers\admin\ProductController as ProductAdmin;
use App\Http\Controllers\admin\CustomerController as CustomerAdmin;
use App\Http\Controllers\admin\CustomerAddressController as CustomerAddressAdmin;
use App\Http\Controllers\admin\BannerController as BannerAdmin;
use App\Http\Controllers\admin\TransactionController as TransactionAdmin;
use App\Http\Controllers\admin\BalanceController as BalanceAdmin;
use App\Http\Controllers\admin\CustomerBalanceController as CustomerBalanceAdmin;
use App\Http\Controllers\admin\CustomerWithdrawController as CustomerWithdrawAdmin;
use App\Http\Controllers\admin\WithdrawController as WithdrawAdmin;
use App\Http\Controllers\admin\StockController as StockAdmin;
use App\Http\Controllers\admin\InformationBarController as InformationBarAdmin;
use App\Http\Controllers\admin\AboutUsController as AboutUsAdmin;
use App\Http\Controllers\admin\DeliveryController as DeliveryAdmin;
use App\Http\Controllers\admin\OtherCostController as OtherCostAdmin;
use App\Http\Controllers\admin\SettingContactAdminController as SettingContactAdmin;
use App\Http\Controllers\admin\VoucherController as VoucherAdmin;
use App\Http\Controllers\admin\SettingCostController as SettingCostAdmin;

use App\Http\Controllers\customer\AboutOlbesaiController;
use App\Http\Controllers\customer\LoginController;
use App\Http\Controllers\customer\CheckoutController;
use App\Http\Controllers\customer\ConfirmationController;
use App\Http\Controllers\customer\DetailProductController;
use App\Http\Controllers\customer\DetailSellerController;
use App\Http\Controllers\customer\HomeController;
use App\Http\Controllers\customer\InvoiceController;
use App\Http\Controllers\customer\RegisterController;
use App\Http\Controllers\customer\ShopController;
use App\Http\Controllers\customer\UserSettingController;
use App\Http\Controllers\customer\ProductController as ProductCustomer;
use App\Http\Controllers\customer\VoucherController;

// Seller
use App\Http\Controllers\seller\AuthController as AuthSeller;
use App\Http\Controllers\seller\DashboardController as DashboardSeller;
use App\Http\Controllers\seller\HomeAndAllProductController;
use App\Http\Controllers\seller\ProfileController as ProfileSeller;
use App\Http\Controllers\seller\ProductController as ProductSeller;
use App\Http\Controllers\seller\SellerBannerController as BannerSeller;
use App\Http\Controllers\seller\TransactionController as TransactionSeller;
use App\Http\Controllers\seller\OtherCostController as OtherCostSeller;
use App\Http\Controllers\seller\SellerBalanceController as BalanceSeller;
use App\Http\Controllers\seller\WithdrawController as WithdrawSeller;
use App\Http\Controllers\seller\StockController as StockSeller;


use App\Http\Controllers\master\CategoryController as Category;

use Illuminate\Foundation\Console\AboutCommand;


use App\Http\Controllers\ResetPasswordController as ResetPassword;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route Autentikasi Customer
Route::get('/login', [LoginController::class, 'index'])->middleware('api-session');
Route::get('/register', [RegisterController::class, 'index']);
Route::get('/customer-start-session', [LoginController::class, 'start_session']);
Route::get('/customer-end-session', [LoginController::class, 'end_session']);
Route::get('/logout-user', [LoginController::class, 'logout']);
Route::get('/customer/email-verify/{user_id}', [LoginController::class, 'verification_email']);

Route::get('/request-reset-password', [ResetPassword::class, 'index'])->name('request-reset-password');
Route::get('/reset-password', [ResetPassword::class, 'reset_view'])->name('reset-password');
Route::get('/reset-password-code-verify/{id}', [ResetPassword::class, 'verification_email']);

Route::get('/seller/register', function () {
    return view('seller.register');
});

Route::controller(Auth::class)->group(function () {
    Route::get('/seller/login', 'index')->name('login');
    Route::post('/seller/login', 'login');
    Route::get('/seller/logout', 'logout')->name('logout');
});

Route::get('/seller/register', function () {
    return view('seller.register');
});

Route::get('/seller/email-verify/{user_id}', [AuthSeller::class, 'verification_email']);

Route::get('/admin/dashboard', [DashboardAdmin::class, 'index']);
Route::get('/admin/get-data-dashboard', [DashboardAdmin::class, 'getDataDashboard']);
Route::get('/admin/get-transaction-statistics', [DashboardAdmin::class, 'getTransactionStatistics']);
Route::get('/admin/get-chart-data-balance', [DashboardAdmin::class, 'getChartDataBalance']);
Route::get('/admin/get-chart-data-transaction', [DashboardAdmin::class, 'getChartDataTransaction']);

Route::get('/seller/get-transaction-statistics', [DashboardAdmin::class, 'getTransactionStatistics']);
Route::get('/seller/get-chart-data-balance', [DashboardAdmin::class, 'getChartDataBalance']);
Route::get('/seller/get-chart-data-transaction', [DashboardAdmin::class, 'getChartDataTransaction']);

Route::get('/search-suggestions', [DashboardAdmin::class, 'index']);

Route::post('/setting/units/switch-status', [SettingUnitAdmin::class, 'switchStatus'])->name('admin.setting.units.switchStatus');
Route::resource('/setting/units', SettingUnitAdmin::class)
    ->name('index', 'admin.setting.units')
    ->name('create', 'admin.setting.units.create')
    ->name('store', 'admin.setting.units.store')
    ->name('show', 'admin.setting.units.show')
    ->name('edit', 'admin.setting.units.edit')
    ->name('update', 'admin.setting.units.update')
    ->name('destroy', 'admin.setting.units.destroy');

Route::middleware(['auth'])->group(function () {
    Route::get('/transaction/cart', [StockAdmin::class, 'export']);
    Route::get('/category', [Category::class, 'index']);
    Route::get('/sub-category', [Category::class, 'subCategoriesByCatId']);
});



Route::middleware(['auth'])->post('/setting/sub-categories/switch-status', [SettingSubCategoryAdmin::class, 'switchStatus'])->name('admin.setting.sub-categories.switchStatus');
Route::middleware(['auth'])->resource('/setting/sub-categories', SettingSubCategoryAdmin::class)
    ->name('index', 'admin.setting.sub-categories')
    ->name('create', 'admin.setting.sub-categories.create')
    ->name('store', 'admin.setting.sub-categories.store')
    ->name('show', 'admin.setting.sub-categories.show')
    ->name('edit', 'admin.setting.sub-categories.edit')
    ->name('update', 'admin.setting.sub-categories.update')
    ->name('destroy', 'admin.setting.sub-categories.destroy');


// Route Setting Category
Route::post('/setting/categories/switch-status', [SettingCategoryAdmin::class, 'switchStatus'])->name('admin.setting.categories.switchStatus');
Route::resource('/setting/categories', SettingCategoryAdmin::class)
    ->name('index', 'admin.setting.categories')
    ->name('create', 'admin.setting.categories.create')
    ->name('store', 'admin.setting.categories.store')
    ->name('show', 'admin.setting.categories.show')
    ->name('edit', 'admin.setting.categories.edit')
    ->name('update', 'admin.setting.categories.update')
    ->name('destroy', 'admin.setting.categories.destroy');


Route::get('/admin/setting/contact-admin', [SettingContactAdmin::class, 'index']);
Route::post('/admin/setting/contact-admin', [SettingContactAdmin::class, 'update']);

Route::resource('/admin/users', UserAdmin::class)
    ->name('index', 'admin.users')
    ->name('create', 'admin.users.create')
    ->name('store', 'admin.users.store')
    ->name('show', 'admin.users.show')
    ->name('edit', 'admin.users.edit')
    ->name('update', 'admin.users.update')
    ->name('destroy', 'admin.users.destroy');

Route::get('/admin/sellers/confirmation', [SellerAdmin::class, 'confirmationSeller'])->name('admin.sellers.confirmation');
Route::get('/admin/sellers/failed', [SellerAdmin::class, 'failedSeller'])->name('admin.sellers.failed');
Route::post('/admin/sellers/{id}/accept', [SellerAdmin::class, 'acceptSeller'])->name('admin.sellers.accept');
Route::post('/admin/sellers/{id}/reject', [SellerAdmin::class, 'rejectSeller'])->name('admin.sellers.reject');
Route::get('/admin/get/sellers', [SellerAdmin::class, 'getSeller'])->name('admin.get.sellers');
Route::get('/admin/get/customers', [CustomerAdmin::class, 'getCustomer'])->name('admin.get.customers');
//reset password seller
Route::post('/admin/sellers/{id}/reset-password', [SellerAdmin::class, 'resetPassword'])->name('admin.sellers.reset-password');
Route::resource('/admin/sellers', SellerAdmin::class)
    ->name('index', 'admin.sellers')
    ->name('create', 'admin.sellers.create')
    ->name('store', 'admin.sellers.store')
    ->name('show', 'admin.sellers.show')
    ->name('edit', 'admin.sellers.edit')
    ->name('update', 'admin.sellers.update')
    ->name('destroy', 'admin.sellers.destroy');

// Admin Product Confirmation
Route::post('/admin/products/{id}/approve', [ProductAdmin::class, 'approve'])->name('seller.products.approve');
Route::post('/admin/products/{id}/reject', [ProductAdmin::class, 'reject'])->name('seller.products.reject');

Route::get('/admin/products/confirmation', [ProductAdmin::class, 'confirmation'])->name('admin.products.confirmation');
Route::resource('/admin/products', ProductAdmin::class)
    ->name('index', 'admin.products')
    ->name('create', 'admin.products.create')
    ->name('store', 'admin.products.store')
    ->name('show', 'admin.products.show')
    ->name('edit', 'admin.products.edit')
    ->name('update', 'admin.products.update')
    ->name('destroy', 'admin.products.destroy');

// content
Route::get('/admin/information-bar', [InformationBarAdmin::class, 'index'])->name('admin.information-bar.index');
Route::post('/admin/information-bar/{id}', [InformationBarAdmin::class, 'update'])->name('admin.information-bar.update');

Route::resource('/admin/about-us', AboutUsAdmin::class)
    ->name('index', 'admin.about-us')
    ->name('create', 'admin.about-us.create')
    ->name('store', 'admin.about-us.store')
    ->name('show', 'admin.about-us.show')
    ->name('edit', 'admin.about-us.edit')
    ->name('update', 'admin.about-us.update')
    ->name('destroy', 'admin.about-us.destroy');

Route::resource('/admin/delivery', DeliveryAdmin::class);

Route::get('/seller/dashboard', [DashboardSeller::class, 'index']);
Route::resource('/seller/profile', ProfileSeller::class)
    ->name('index', 'seller.profile')
    ->name('create', 'seller.profile.create')
    ->name('store', 'seller.profile.store')
    ->name('show', 'seller.profile.show')
    ->name('edit', 'seller.profile.edit')
    ->name('update', 'seller.profile.update')
    ->name('destroy', 'seller.profile.destroy');
//change password
Route::post('/seller/profile/{id}/change-password', [ProfileSeller::class, 'changePassword'])->name('seller.profile.change-password');

//add bank account
Route::post('/seller/profile/add-bank-account', [ProfileSeller::class, 'addBankAccount'])->name('seller.profile.add-bank-account');

// Route Add Seller Product
Route::resource('/seller/products', ProductSeller::class)
    ->name('index', 'seller.products')
    ->name('create', 'seller.products.create')
    ->name('store', 'seller.products.store')
    ->name('edit', 'seller.products.edit')
    ->name('update', 'seller.products.update')
    ->name('destroy', 'seller.products.destroy');

// Route My Product
Route::resource('/seller/my-products', ProductSeller::class)
    ->name('index', 'seller.my-products')
    ->name('create', 'seller.my-products.create')
    ->name('store', 'seller.my-products.store')
    ->name('edit', 'seller.my-products.edit')
    ->name('update', 'seller.my-products.update')
    ->name('destroy', 'seller.my-products.destroy');

//Route Admin Customer Confirmation
Route::post('/admin/customers/{id}/reset-password', [CustomerAdmin::class, 'resetPassword'])->name('admin.customers.reset-password');
Route::get('admin/customers', [CustomerAdmin::class, 'index'])->name('admin.customers.index');
Route::get('admin/customers/{customer}/show', [CustomerAdmin::class, 'show'])->name('admin.customers.show');
Route::delete('/admin/customers/{customer}/destroy', [CustomerAdmin::class, 'destroy'])->name('admin.customers.destroy');
Route::get('/disabled-customers', [CustomerAdmin::class, 'disabled'])->name('admin.customers.disabled');
Route::post('/{customer}/enable', [CustomerAdmin::class, 'enable'])->name('admin.customers.enable');
Route::post('/{customer}/disable', [CustomerAdmin::class, 'disable'])->name('admin.customers.disable');

Route::resource('/admin/banners', BannerAdmin::class);
Route::resource('/seller/banners', BannerAdmin::class);

Route::get('/', [HomeController::class, 'index']);
Route::get('/product/{slug}', [ProductCustomer::class, 'index']);
Route::get('/detail-product', [DetailProductController::class, 'index']);
Route::get('/shop', [ShopController::class, 'index']);
Route::get('/detail-seller/{username}', [DetailSellerController::class, 'index']);
Route::get('/about-us', [AboutOlbesaiController::class, 'index']);
Route::middleware(['checkLoginCustomer'])->group(function () {
    Route::get('/update-cart', [CheckoutController::class, 'update_cart']);
    Route::get('/check-shipping', [CheckoutController::class, 'check_shipping']);
    Route::get('/select-shipping', [CheckoutController::class, 'select_shipping']);
    Route::get('/checkout-cart', [CheckoutController::class, 'index']);
    Route::post('/transaction-create', [CheckoutController::class, 'store']);
    Route::get('/waiting-confirmation', [ConfirmationController::class, 'index']);
    Route::get('/invoice', [InvoiceController::class, 'index']);
    Route::get('/user-setting', [UserSettingController::class, 'profileSetting']);
    Route::get('/address-setting', [UserSettingController::class, 'addressSetting']);
    Route::get('/order-history', [UserSettingController::class, 'orderHistorySetting']);
    Route::post('/submit-review', [UserSettingController::class, 'submitReview']);
    Route::get('/waiting-payment', [UserSettingController::class, 'waitingPaymentSetting']);
    Route::get('/waiting-confirmation', [UserSettingController::class, 'waitingConfirmation']);
    Route::get('/get-saldo-user', [UserSettingController::class, 'getSaldo']);
    Route::get('/voucher-user', [VoucherController::class, 'index']);
});

// Route Seller 
Route::get('/home-seller', [HomeAndAllProductController::class, 'homePage']);
Route::get('/all-product-seller/{username}', [HomeAndAllProductController::class, 'allProductSeller']);


Route::get('/admin/dashboard', [DashboardAdmin::class, 'index']);
Route::get('/search-suggestions', [DashboardAdmin::class, 'index']);



Route::middleware(['auth'])->post('/setting/units/switch-status', [SettingUnitAdmin::class, 'switchStatus'])->name('admin.setting.units.switchStatus');
Route::middleware(['auth'])->resource('/setting/units', SettingUnitAdmin::class)
    ->name('index', 'admin.setting.units')
    ->name('create', 'admin.setting.units.create')
    ->name('store', 'admin.setting.units.store')
    ->name('show', 'admin.setting.units.show')
    ->name('edit', 'admin.setting.units.edit')
    ->name('update', 'admin.setting.units.update')
    ->name('destroy', 'admin.setting.units.destroy');


// Route Setting Category
Route::middleware(['auth'])->post('/setting/categories/switch-status', [SettingCategoryAdmin::class, 'switchStatus'])->name('admin.setting.categories.switchStatus');
Route::middleware(['auth'])->resource('/setting/categories', SettingCategoryAdmin::class)
    ->name('index', 'admin.setting.categories')
    ->name('create', 'admin.setting.categories.create')
    ->name('store', 'admin.setting.categories.store')
    ->name('show', 'admin.setting.categories.show')
    ->name('edit', 'admin.setting.categories.edit')
    ->name('update', 'admin.setting.categories.update')
    ->name('destroy', 'admin.setting.categories.destroy');





Route::middleware(['auth'])->resource('/admin/users', UserAdmin::class)
    ->name('index', 'admin.users')
    ->name('create', 'admin.users.create')
    ->name('store', 'admin.users.store')
    ->name('show', 'admin.users.show')
    ->name('edit', 'admin.users.edit')
    ->name('update', 'admin.users.update')
    ->name('destroy', 'admin.users.destroy');

Route::middleware(['auth'])->get('/admin/sellers/confirmation', [SellerAdmin::class, 'confirmationSeller'])->name('admin.sellers.confirmation');
Route::middleware(['auth'])->get('/admin/sellers/failed', [SellerAdmin::class, 'failedSeller'])->name('admin.sellers.failed');
Route::middleware(['auth'])->post('/admin/sellers/{id}/accept', [SellerAdmin::class, 'acceptSeller'])->name('admin.sellers.accept');
Route::middleware(['auth'])->post('/admin/sellers/{id}/reject', [SellerAdmin::class, 'rejectSeller'])->name('admin.sellers.reject');
Route::middleware(['auth'])->get('/admin/get/sellers', [SellerAdmin::class, 'getSeller'])->name('admin.get.sellers');
//reset password seller
Route::middleware(['auth'])->post('/admin/sellers/{id}/reset-password', [SellerAdmin::class, 'resetPassword'])->name('admin.sellers.reset-password');
Route::middleware(['auth'])->resource('/admin/sellers', SellerAdmin::class)
    ->name('index', 'admin.sellers')
    ->name('create', 'admin.sellers.create')
    ->name('store', 'admin.sellers.store')
    ->name('show', 'admin.sellers.show')
    ->name('edit', 'admin.sellers.edit')
    ->name('update', 'admin.sellers.update')
    ->name('destroy', 'admin.sellers.destroy');

// Admin Product Confirmation
Route::middleware(['auth'])->post('/admin/products/{id}/approve', [ProductAdmin::class, 'approve'])->name('seller.products.approve');
Route::middleware(['auth'])->post('/admin/products/{id}/reject', [ProductAdmin::class, 'reject'])->name('seller.products.reject');

Route::middleware(['auth'])->get('/admin/products/confirmation', [ProductAdmin::class, 'confirmation'])->name('admin.products.confirmation');
Route::middleware(['auth'])->resource('/admin/products', ProductAdmin::class)
    ->name('index', 'admin.products')
    ->name('create', 'admin.products.create')
    ->name('store', 'admin.products.store')
    ->name('show', 'admin.products.show')
    ->name('edit', 'admin.products.edit')
    ->name('update', 'admin.products.update')
    ->name('destroy', 'admin.products.destroy');



Route::middleware(['auth'])->get('/seller/dashboard', [DashboardSeller::class, 'index']);
Route::middleware(['auth'])->resource('/seller/profile', ProfileSeller::class)
    ->name('index', 'seller.profile')
    ->name('create', 'seller.profile.create')
    ->name('store', 'seller.profile.store')
    ->name('show', 'seller.profile.show')
    ->name('edit', 'seller.profile.edit')
    ->name('update', 'seller.profile.update')
    ->name('destroy', 'seller.profile.destroy');
//change password
Route::middleware(['auth'])->post('/seller/profile/{id}/change-password', [ProfileSeller::class, 'changePassword'])->name('seller.profile.change-password');

// Route Add Seller Product
Route::middleware(['auth'])->resource('/seller/products', ProductSeller::class)
    ->name('index', 'seller.products')
    ->name('create', 'seller.products.create')
    ->name('store', 'seller.products.store')
    ->name('edit', 'seller.products.edit')
    ->name('update', 'seller.products.update')
    ->name('destroy', 'seller.products.destroy');

Route::middleware(['auth'])->group(function () {
    Route::resource('/admin/stock', StockAdmin::class)->except(['show'])->names([
        'index' => 'admin.stock',
        'create' => 'admin.stock.create',
        'store' => 'admin.stock.store',
        'edit' => 'admin.stock.edit',
        'update' => 'admin.stock.update',
        'destroy' => 'admin.stock.destroy',
    ]);

    // Add a separate route for export
    Route::get('/admin/stock/export', [StockAdmin::class, 'export'])->name('admin.stock.export');
});


Route::middleware(['auth'])->group(function () {
    Route::resource('/seller/stock', StockSeller::class)->except(['show'])->names([
        'index' => 'seller.stock',
        'create' => 'seller.stock.create',
        'store' => 'seller.stock.store',
        'edit' => 'seller.stock.edit',
        'update' => 'seller.stock.update',
        'destroy' => 'seller.stock.destroy',
    ]);

    // Add a separate route for export
    Route::get('/seller/stock/export', [StockSeller::class, 'export'])->name('seller.stock.export');
});


// Route My Product
Route::middleware(['auth'])->resource('/seller/my-products', ProductSeller::class)
    ->name('index', 'seller.my-products')
    ->name('create', 'seller.my-products.create')
    ->name('store', 'seller.my-products.store')
    ->name('edit', 'seller.my-products.edit')
    ->name('update', 'seller.my-products.update')
    ->name('destroy', 'seller.my-products.destroy');

//Route Admin Customer Confirmation

Route::middleware(['auth'])->get('admin/customers', [CustomerAdmin::class, 'index'])->name('admin.customers.index');
Route::middleware(['auth'])->get('admin/customers/{customer}/show', [CustomerAdmin::class, 'show'])->name('admin.customers.show');
Route::middleware(['auth'])->delete('/admin/customers/{customer}/destroy', [CustomerAdmin::class, 'destroy'])->name('admin.customers.destroy');
Route::middleware(['auth'])->get('/disabled-customers', [CustomerAdmin::class, 'disabled'])->name('admin.customers.disabled');
Route::middleware(['auth'])->post('/{customer}/enable', [CustomerAdmin::class, 'enable'])->name('admin.customers.enable');
Route::middleware(['auth'])->post('/{customer}/disable', [CustomerAdmin::class, 'disable'])->name('admin.customers.disable');

// Route Customer Address
Route::middleware(['auth'])->get('admin/customer/address', [CustomerAddressAdmin::class, 'index'])->name('admin.customer.address');
Route::middleware(['auth'])->get('admin/customer/address/{id}', [CustomerAddressAdmin::class, 'show'])->name('admin.customer.address.show');
Route::middleware(['auth'])->post('admin/customer/address/update', [CustomerAddressAdmin::class, 'update'])->name('admin.customer.address.update');
Route::middleware(['auth'])->post('admin/customer/address/destroy', [CustomerAddressAdmin::class, 'destroy'])->name('admin.customer.address.destroy');

Route::middleware(['auth'])->resource('/admin/banners', BannerAdmin::class)
    ->name('index', 'admin.banners')
    ->name('create', 'admin.banners.create')
    ->name('store', 'admin.banners.store')
    ->name('show', 'admin.banners.show')
    ->name('edit', 'admin.banners.edit')
    ->name('update', 'admin.banners.update')
    ->name('destroy', 'admin.banners.destroy');


Route::middleware(['auth'])->resource('/seller/banners', BannerSeller::class)
    ->name('index', 'seller.banners')
    ->name('create', 'seller.banners.create')
    ->name('store', 'seller.banners.store')
    ->name('show', 'seller.banners.show')
    ->name('edit', 'seller.banners.edit')
    ->name('update', 'seller.banners.update')
    ->name('destroy', 'seller.banners.destroy');




//test payment
Route::get('/payment', function () {
    return view('snap');
});


Route::middleware(['auth'])->prefix('seller/transactions')->group(function () {
    Route::get('/', [TransactionSeller::class, 'index'])->name('seller.transactions');
    Route::get('/seller/confirm', [TransactionSeller::class, 'index'])->name('seller.transactions.confirmation.seller');
    Route::get('/admin/confirm', [TransactionSeller::class, 'index'])->name('seller.transactions.confirmation.admin');
    Route::get('/waiting_payment', [TransactionSeller::class, 'index'])->name('seller.transactions.waiting.payment');
    Route::get('/payment_done', [TransactionSeller::class, 'index'])->name('seller.transactions.payment.done');
    Route::get('/on_packing', [TransactionSeller::class, 'index'])->name('seller.transactions.on.packing');
    Route::get('/on_delivery', [TransactionSeller::class, 'index'])->name('seller.transactions.on.delivery');
    Route::get('/received', [TransactionSeller::class, 'index'])->name('seller.transactions.received');
    Route::get('/cancelled', [TransactionSeller::class, 'index'])->name('seller.transactions.cancelled');
    Route::get('/expired', [TransactionSeller::class, 'index'])->name('seller.transactions.expired');

    Route::get('/report', [TransactionSeller::class, 'report'])->name('seller.transactions.report');

    Route::get('/export', function (Request $request) {
        $fileName = 'transactions_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new SellerTransactionExport($request->start_date, $request->end_date, $request->status), $fileName);
    })->name('seller.transactions.export');


    Route::get('/{id}', [TransactionSeller::class, 'show'])->name('seller.transactions.show');
    Route::post('/{id}/confirm', [TransactionSeller::class, 'confirm'])->name('seller.transactions.confirm');
    Route::post('/{id}/reject', [TransactionSeller::class, 'reject'])->name('seller.transactions.reject');
    Route::post('/{id}/packing', [TransactionSeller::class, 'packing'])->name('seller.transactions.packing');
    Route::post('/{id}/delivery', [TransactionSeller::class, 'delivery'])->name('seller.transactions.delivery');

    Route::prefix('other-cost')->group(function () {
        Route::post('/submit', [OtherCostSeller::class, 'store'])->name('seller.transactions.other_cost.store');
        Route::put('/update/{id}', [OtherCostSeller::class, 'update'])->name('seller.transactions.other_cost.update');
        Route::delete('/delete/{id}', [OtherCostSeller::class, 'destroy'])->name('seller.transactions.other_cost.destroy');
    });
});


Route::middleware(['auth'])->prefix('admin/transactions')->group(function () {
    Route::get('/', [TransactionAdmin::class, 'index'])->name('admin.transactions');
    Route::get('/seller/confirm', [TransactionAdmin::class, 'index'])->name('admin.transactions.confirmation.seller');
    Route::get('/admin/confirm', [TransactionAdmin::class, 'index'])->name('admin.transactions.confirmation.admin');
    Route::get('/waiting_payment', [TransactionAdmin::class, 'index'])->name('admin.transactions.waiting.payment');
    Route::get('/payment_done', [TransactionAdmin::class, 'index'])->name('admin.transactions.payment.done');
    Route::get('/on_packing', [TransactionAdmin::class, 'index'])->name('admin.transactions.on.packing');
    Route::get('/on_delivery', [TransactionAdmin::class, 'index'])->name('admin.transactions.on.delivery');
    Route::get('/received', [TransactionAdmin::class, 'index'])->name('admin.transactions.received');
    Route::get('/cancelled', [TransactionAdmin::class, 'index'])->name('admin.transactions.cancelled');
    Route::get('/expired', [TransactionAdmin::class, 'index'])->name('admin.transactions.expired');

    Route::get('/report', [TransactionAdmin::class, 'report'])->name('admin.transactions.report');

    Route::get('/export', function (Request $request) {
        $fileName = 'transactions_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new AdminTransactionExport($request->seller_id, $request->start_date, $request->end_date, $request->status), $fileName);
    })->name('admin.transactions.export');

    Route::get('/{id}', [TransactionAdmin::class, 'show'])->name('admin.transactions.show');
    Route::post('/{id}/confirm', [TransactionAdmin::class, 'confirm'])->name('admin.transactions.confirm');
    Route::post('/{id}/reject', [TransactionAdmin::class, 'reject'])->name('admin.transactions.reject');
    Route::post('/{id}/return', [TransactionAdmin::class, 'returnTransaction'])->name('admin.transactions.return');

    Route::prefix('other-cost')->group(function () {
        Route::post('/save-shipping', [OtherCostAdmin::class, 'save_shipping'])->name('admin.transactions.other_cost.save-shipping');
        Route::post('/submit', [OtherCostAdmin::class, 'store'])->name('admin.transactions.other_cost.store');
        Route::put('/update/{id}', [OtherCostAdmin::class, 'update'])->name('admin.transactions.other_cost.update');
        Route::delete('/delete/{id}', [OtherCostAdmin::class, 'destroy'])->name('admin.transactions.other_cost.destroy');
    });
});

Route::middleware(['auth'])->prefix('seller/balance')->group(function () {
    Route::get('/', [BalanceSeller::class, 'index'])->name('seller.balance');
    Route::get('/{id}', [BalanceSeller::class, 'show'])->name('seller.balance.show');
});

Route::middleware(['auth'])->prefix('admin/balance')->group(function () {
    Route::get('/', [BalanceAdmin::class, 'index'])->name('admin.balance');
    // Route::get('/{id}', [BalanceAdmin::class, 'show'])->name('admin.balance.show');
    Route::get('/customer', [CustomerBalanceAdmin::class, 'index'])->name('admin.balance.customer');
    // Route::get('/customer/{id}', [CustomerBalanceAdmin::class, 'show'])->name('admin.balance.customer.show');
});



Route::middleware(['auth'])->prefix('seller/withdraw')->group(function () {
    Route::get('/', [WithdrawSeller::class, 'index'])->name('seller.withdraw');
    Route::get('/check/balance', [WithdrawSeller::class, 'checkBalance'])->name('seller.withdraw.checkBalance');
    Route::post('/store', [WithdrawSeller::class, 'store'])->name('seller.withdraw.store');
    Route::post('/{id}/cancel', [WithdrawSeller::class, 'cancel'])->name('seller.withdraw.cancel');
});

Route::middleware(['auth'])->prefix('admin/withdraw')->group(function () {
    Route::get('/', [WithdrawAdmin::class, 'index'])->name('admin.withdraw');
    Route::get('/check/balance', [WithdrawAdmin::class, 'checkBalance'])->name('admin.withdraw.checkBalance');
    Route::post('/{id}/reject', [WithdrawAdmin::class, 'reject'])->name('admin.withdraw.reject');
    Route::post('/{id}/accept', [WithdrawAdmin::class, 'accept'])->name('admin.withdraw.accept');

    //customer withdraw
    Route::get('/customer', [CustomerWithdrawAdmin::class, 'index'])->name('admin.withdraw.customer');
    Route::get('/customer/check/balance', [CustomerWithdrawAdmin::class, 'checkBalance'])->name('admin.withdraw.customer.checkBalance');
    Route::post('/customer/{id}/reject', [CustomerWithdrawAdmin::class, 'reject'])->name('admin.withdraw.customer.reject');
    Route::post('/customer/{id}/accept', [CustomerWithdrawAdmin::class, 'accept'])->name('admin.withdraw.customer.accept');
});


//Route Voucher
Route::middleware(['auth'])->prefix('admin/voucher')->group(function () {
    Route::get('/', [VoucherAdmin::class, 'index'])->name('admin.vouchers');
    Route::get('/create', [VoucherAdmin::class, 'create'])->name('admin.vouchers.create');
    Route::post('/store', [VoucherAdmin::class, 'store'])->name('admin.vouchers.store');
    Route::get('/{id}/edit', [VoucherAdmin::class, 'edit'])->name('admin.vouchers.edit');
    Route::put('/{id}/update', [VoucherAdmin::class, 'update'])->name('admin.vouchers.update');
    Route::delete('/{id}/destroy', [VoucherAdmin::class, 'destroy'])->name('admin.vouchers.destroy');
});

//Route Setting Cost
Route::middleware(['auth'])->prefix('admin/setting-cost')->group(function () {
    Route::get('/', [SettingCostAdmin::class, 'index'])->name('admin.setting-cost');
    Route::get('/create', [SettingCostAdmin::class, 'create'])->name('admin.setting-cost.create');
    Route::post('/store', [SettingCostAdmin::class, 'store'])->name('admin.setting-cost.store');
    Route::get('/{id}/edit', [SettingCostAdmin::class, 'edit'])->name('admin.setting-cost.edit');
    Route::post('/{id}/update', [SettingCostAdmin::class, 'update'])->name('admin.setting-cost.update');
    Route::delete('/{id}/destroy', [SettingCostAdmin::class, 'destroy'])->name('admin.setting-cost.destroy');
});




Route::get('/tes-email', function () {
    Mail::raw('Tes kirim email pakai Gmail SMTP!', function ($message) {
        $message->to('alamatemailkamu@gmail.com')
            ->subject('Tes Gmail SMTP dari Laravel');
    });

    return 'Email terkirim!';
});