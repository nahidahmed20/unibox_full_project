<?php

use App\Http\Controllers\backend\AboutUsController;
use App\Http\Controllers\backend\AttributeController;
use App\Http\Controllers\backend\BackupController;
use App\Http\Controllers\backend\BlockedPhoneController;
use App\Http\Controllers\backend\BlogCategoryController;
use App\Http\Controllers\backend\BlogController;
use App\Http\Controllers\backend\BrandController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\ClientController;
use App\Http\Controllers\backend\ColorController;
use App\Http\Controllers\backend\CounterController;
use App\Http\Controllers\backend\CourierController;
use App\Http\Controllers\backend\CustomerController as BackendCustomerController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\ExpenseCategoryController;
use App\Http\Controllers\backend\ExpenseController;
use App\Http\Controllers\backend\FeatureController;
use App\Http\Controllers\backend\HomeController;
use App\Http\Controllers\backend\LocationController;
use App\Http\Controllers\backend\MaterialController;
use App\Http\Controllers\backend\MemberController;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\backend\OurServiceController;
use App\Http\Controllers\backend\PermissionController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\PurchaseController;
use App\Http\Controllers\backend\ReportController;
use App\Http\Controllers\backend\RoleController;
use App\Http\Controllers\backend\SaleController;
use App\Http\Controllers\backend\SettingController;
use App\Http\Controllers\backend\ShippingController;
use App\Http\Controllers\backend\SizeController;
use App\Http\Controllers\backend\SliderController;
use App\Http\Controllers\backend\SpecificationController;
use App\Http\Controllers\backend\SubCategoryController;
use App\Http\Controllers\backend\SupplierController;
use App\Http\Controllers\backend\TeamController;
use App\Http\Controllers\backend\TestimonialController;
use App\Http\Controllers\backend\UnitController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\UserProfileController;
use App\Http\Controllers\backend\VariationController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\FontOrderController;
use App\Http\Controllers\frontend\HomeController as FrontendHomeController;
use App\Http\Controllers\frontend\ReviewController;
use App\Http\Controllers\frontend\UserController as FrontendUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendHomeController::class, 'index'])->name('home');
Route::get('/product/quick-view/{id}', [FrontendHomeController::class, 'modalData'])->name('product.quickView');
Route::get('/product/{slug}', [FrontendHomeController::class, 'productShow'])->name('product.show');
Route::get('/search/products', [FrontendHomeController::class, 'search'])->name('product.search');
Route::get('/privacy-policy', [FrontendHomeController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/terms-conditions', [FrontendHomeController::class, 'termsConditions'])->name('terms.conditions');
Route::get('/track-order', [FrontendHomeController::class, 'trackOrder'])->middleware('throttle:10,1')->name('track.order');
Route::get('/return-policy', [FrontendHomeController::class, 'returnPolicy'])->name('return.policy');
Route::get('/shipping-policy', [FrontendHomeController::class, 'shippingPolicy'])->name('shipping.policy');
Route::get('/contact-us', [FrontendHomeController::class, 'contactUs'])->name('contact.us');
Route::post('/contact-us/send-message', [FrontendHomeController::class, 'contactUsSend'])->middleware('throttle:10,1')->name('contact.store');
Route::get('/about-us', [FrontendHomeController::class, 'about'])->name('about.us');
Route::post('/newsletter/subscribe', [FrontendHomeController::class, 'newsletterSubscribe'])->middleware('throttle:10,1')->name('newsletter.subscribe');
Route::post('/product/{id}/review', [ReviewController::class, 'store'])->middleware('throttle:10,1')->name('product.review.store');

Route::get('/login/google', [FrontendUserController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [FrontendUserController::class, 'handleGoogleCallback']);
Route::get('/login/facebook', [FrontendUserController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('/login/facebook/callback', [FrontendUserController::class, 'handleFacebookCallback']);

Route::post('/send-otp', [FrontendUserController::class, 'sendOtp'])->middleware('throttle:3,1')->name('user.login.send_otp');
Route::post('/verify-otp', [FrontendUserController::class, 'verifyOtp'])->middleware('throttle:5,1')->name('user.login.verify_otp');
Route::get('/cancel-otp', [FrontendUserController::class, 'cancelOtp'])->name('user.login.cancel_otp');

Route::get('/category/{slug}', [FrontendHomeController::class, 'categoryProducts'])->name('category.show');
Route::get('/product/modal-data/{id}', [FrontendHomeController::class, 'modalData']);

Route::get('/service/{slug}', [FrontendHomeController::class, 'serviceDetails'])->name('service.details');

Route::get('/checkout', [FontOrderController::class, 'cartCheckout'])->name('cart.checkout');

Route::get('/get-districts/{division_id}', [FontOrderController::class, 'getDistricts']);
Route::get('/get-upazilas/{district_id}', [FontOrderController::class, 'getUpazilas']);
Route::post('/checkout/place-order', [FontOrderController::class, 'placeOrder'])->block(10, 10)->middleware('throttle:10,1')->name('checkout.placeOrder');
Route::get('/order-success/{order_number}', [FontOrderController::class, 'orderSuccess'])->name('order.success');
Route::post('/coupon/apply', [FontOrderController::class, 'applyCoupon'])->name('coupon.apply');
Route::post('/coupon/remove', [FontOrderController::class, 'removeCoupon'])->name('coupon.remove');

Route::get('/get-districts', [CartController::class, 'getDistricts'])->name('get.districts');
Route::get('/get-upazilas', [CartController::class, 'getUpazilas'])->name('get.upazilas');

Route::prefix('/cart')->group(function () {
    Route::get('/', [CartController::class, 'cart'])->name('checkout');
    Route::get('/index', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'cartAdd'])->name('cart.add');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/content', [CartController::class, 'cartContent'])->name('cart.content');
    Route::post('/update', [CartController::class, 'cartUpdate'])->name('cart.update');
    Route::post('/update-shipping-zone', [CartController::class, 'updateShippingZone'])->name('cart.update-shipping-zone');
    Route::post('/order/store', [CartController::class, 'orderStore'])->block(10, 10)->middleware('throttle:10,1')->name('checkout.place-order');
});
Route::get('single-product/{slug}', [CartController::class, 'singleView'])->name('add.to.cart');
Route::get('/thank-you/{order_number}', [FrontendHomeController::class, 'thankYou'])->name('thank.you');

Route::get('faq', [FontOrderController::class, 'faq'])->name('faq');

Route::get('our/blogs', [FrontendHomeController::class, 'ourBlogs'])->name('our-blogs');
Route::get('/blog/{slug}', [FrontendHomeController::class, 'blogDetails'])->name('blog.details');

Route::get('/search', [FrontendHomeController::class, 'search'])->name('search');
Route::get('/search-suggestion', [FrontendHomeController::class, 'searchSuggestion'])->name('search.suggestion');

Route::get('/best-selling-products', [FrontendHomeController::class, 'bestsellers'])->name('shop.bestsellers');

Route::middleware(['auth', 'staff'])->prefix('admin')->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    // Accounting Core
    Route::resource('accounts', \App\Http\Controllers\backend\AccountController::class);
    Route::get('ledger', [\App\Http\Controllers\backend\AccountController::class, 'ledger'])->name('accounts.ledger');
    Route::resource('journals', \App\Http\Controllers\backend\JournalEntryController::class);

    Route::resource('categories', CategoryController::class);
    Route::get('/get-child-categories/{id}', [App\Http\Controllers\backend\CategoryController::class, 'getChildCategories']);
    Route::resource('brands', BrandController::class);
    Route::resource('units', UnitController::class);
    Route::get('products/bulk-price', [ProductController::class, 'bulkPriceForm'])->name('products.bulkPrice.form');
    Route::post('products/bulk-price', [ProductController::class, 'bulkPriceUpdate'])->name('products.bulkPrice.update');
    Route::resource('products', ProductController::class);
    Route::resource('members', MemberController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('variations', VariationController::class)->except(['create', 'show']);
    Route::resource('sizes', SizeController::class);
    Route::resource('colors', ColorController::class)->except(['show']);
    Route::delete('/product-color/delete/{id}', [ProductController::class, 'deleteColor']);

    Route::get('/product/bulk-upload', [ProductController::class, 'bulkUploadView'])->name('products.bulk_upload_view');
    Route::post('/product/bulk-upload', [ProductController::class, 'bulkUpload'])->name('products.bulk_upload');
    Route::get('/product/demo-excel', [ProductController::class, 'downloadDemo'])->name('products.demo_excel');

    Route::get('/stock-adjustments', [ProductController::class, 'stockAdjustmentIndex'])->name('stock-adjustments.index');
    Route::get('/stock-adjustments/create', [ProductController::class, 'stockAdjustmentcreate'])->name('stock-adjustments.create');
    Route::post('/stock-adjustments/store', [ProductController::class, 'stockAdjustmentstore'])->name('stock-adjustments.store');
    Route::get('/stock-adjustments/{id}', [ProductController::class, 'stockAdjustmentShow'])->name('stock-adjustments.show');
    Route::get('/stock-adjustments/edit/{id}', [ProductController::class, 'stockAdjustmentEdit'])->name('stock-adjustments.edit');
    Route::put('/stock-adjustments/update/{id}', [ProductController::class, 'stockAdjustmentUpdate'])->name('stock-adjustments.update');
    Route::delete('/stock-adjustments/destroy/{id}', [ProductController::class, 'stockAdjustmentDestroy'])->name('stock-adjustments.destroy');

    Route::resource('purchases', PurchaseController::class);

    Route::resource('sales', SaleController::class);

    Route::resource('expenses-categories', ExpenseCategoryController::class)->except(['create', 'show']);
    Route::resource('expenses', ExpenseController::class);

    Route::resource('user-profiles', UserProfileController::class);

    Route::resource('couriers', CourierController::class)->except(['create', 'show']);

    Route::get('/blocked-phones', [BlockedPhoneController::class, 'index'])->name('blocked-phones.index');
    Route::post('/blocked-phones/block', [BlockedPhoneController::class, 'block'])->name('blocked-phones.block');
    Route::post('/blocked-phones/unblock', [BlockedPhoneController::class, 'unblock'])->name('blocked-phones.unblock');

    Route::get('/ecommerce/sales', [OrderController::class, 'ecommerceSales'])->name('orders.sales-list');
    Route::get('/orders/check-new', [OrderController::class, 'checkNewOrder'])->name('orders.checkNew');
    Route::resource('orders', OrderController::class);
    Route::get('orders/invoice/{id}', [OrderController::class, 'invoice'])->name('orders.invoice');
    Route::post('orders/update-status/{id}', [OrderController::class, 'statusUpdate'])->name('orders.update.status');
    Route::get('orders/status-modal/{id}', [OrderController::class, 'statusModal']);
    Route::post('/single-status-update/{order}', [OrderController::class, 'statusUpdate'])->name('single.status.update');
    Route::get('/orders/{id}/invoice', [OrderController::class, 'invoice']);
    Route::get('/order/pending-count', [OrderController::class, 'getPendingCount']);

    Route::resource('attributes', AttributeController::class)->except(['create', 'show']);
    Route::resource('specifications', SpecificationController::class)->except(['create', 'show']);

    Route::resource('teams', TeamController::class)->except(['create', 'show']);
    Route::resource('testimonials', TestimonialController::class)->except(['create', 'show']);

    Route::delete('/contacts/{id}', [HomeController::class, 'contactDestroy'])->name('contacts.destroy');

    Route::get('/newsletter/list', [HomeController::class, 'newsletterList'])->name('newsletter.list');
    Route::delete('/newsletter/{id}', [HomeController::class, 'newsletterDestroy'])->name('newsletter.destroy');

    Route::get('contact-us/data', [HomeController::class, 'contactUsData'])->name('contact.us.data');
    Route::get('/contacts/{id}', [HomeController::class, 'contactShow'])->name('contacts.modal.show');

    Route::resource('customers', BackendCustomerController::class);

    Route::resource('sliders', SliderController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('blog-categories', BlogCategoryController::class);
    Route::resource('shippings', ShippingController::class)->except(['create', 'show']);
    Route::resource('our-services', OurServiceController::class)->except(['create', 'show']);
    Route::resource('clients', ClientController::class)->except(['create', 'show']);
    Route::resource('counters', CounterController::class)->except(['create', 'show']);
    Route::resource('features', FeatureController::class)->except(['create', 'show']);
    Route::resource('materials', MaterialController::class)->except(['create', 'show']);

    Route::get('aboutus', [AboutUsController::class, 'index'])->name('about-us.index');
    Route::post('aboutus', [AboutUsController::class, 'update'])->name('about-us.update');

    Route::get('/categorie/data', [CategoryController::class, 'getData'])->name('categories.data');
    Route::get('/product/search', [PurchaseController::class, 'search'])->name('products.search');
    Route::get('/sales/invoice/{id}', [SaleController::class, 'invoice'])->name('sales.invoice');
    Route::get('/get-product-attributes', [SaleController::class, 'getProductDetails'])->name('get.product.details');

    Route::get('/get-locations/{parent_id}', [LocationController::class, 'getLocations'])->name('get.locations');

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/save', [SettingController::class, 'save'])->name('settings.save');
    Route::get('/settings/{key}', [SettingController::class, 'get'])->name('settings.get');

    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('order/sales', [SaleController::class, 'orderSales'])->name('order.sales');
    Route::get('order/return', [SaleController::class, 'orderReturn'])->name('order.return');
    Route::get('order/cancelled', [SaleController::class, 'orderCancelled'])->name('order.cancelled');

    // Coupons
    Route::resource('coupons', \App\Http\Controllers\backend\CouponController::class);
    Route::post('coupons/{id}/toggle-status', [\App\Http\Controllers\backend\CouponController::class, 'toggleStatus'])->name('coupons.toggle-status');

    // Customer Reviews Moderation
    Route::get('reviews', [\App\Http\Controllers\backend\ReviewController::class, 'index'])->name('admin.reviews.index');
    Route::post('reviews/{id}/toggle-status', [\App\Http\Controllers\backend\ReviewController::class, 'toggleStatus'])->name('admin.reviews.toggle-status');
    Route::delete('reviews/{id}', [\App\Http\Controllers\backend\ReviewController::class, 'destroy'])->name('admin.reviews.destroy');

    // Courier Dispatch
    Route::post('orders/{id}/send-to-steadfast', [OrderController::class, 'sendToSteadfast'])->name('orders.send-to-steadfast');

    // Reports
    Route::get('reports/total-income', [ReportController::class, 'totalIncome'])->name('reports.total-income');
    Route::get('reports/sales', [ReportController::class, 'salesReport'])->name('reports.sales');
    Route::get('reports/purchase', [ReportController::class, 'purchaseReport'])->name('reports.purchase');
    Route::get('reports/low-stock', [ReportController::class, 'lowStock'])->name('reports.low-stock');
    Route::get('reports/orders', [ReportController::class, 'orderReport'])->name('reports.orders');
    Route::get('reports/top-products', [ReportController::class, 'topProducts'])->name('reports.top-products');

    Route::get('/divisions', [LocationController::class, 'divisions'])->name('locations.divisions');
    Route::post('/divisions', [LocationController::class, 'storeDivision'])->name('locations.divisions.store');

    Route::get('/districts', [LocationController::class, 'districts'])->name('locations.districts');
    Route::post('/districts', [LocationController::class, 'storeDistrict'])->name('locations.districts.store');
    Route::get('/districts/{id}/edit', [LocationController::class, 'editDistrict'])->name('locations.districts.edit');
    Route::put('/districts/{id}', [LocationController::class, 'updateDistrict'])->name('locations.districts.update');
    Route::delete('/districts/{id}', [LocationController::class, 'destroyDistrict'])->name('locations.districts.destroy');

    Route::get('/upazilas', [LocationController::class, 'upazilas'])->name('locations.upazilas');
    Route::post('/upazilas', [LocationController::class, 'storeUpazila'])->name('locations.upazilas.store');
    Route::get('/upazilas/{id}/edit', [LocationController::class, 'editUpazila'])->name('locations.upazilas.edit');
    Route::put('/upazilas/{id}', [LocationController::class, 'updateUpazila'])->name('locations.upazilas.update');
    Route::delete('/upazilas/{id}', [LocationController::class, 'destroyUpazila'])->name('locations.upazilas.destroy');

    Route::get('product/barcode', [ProductController::class, 'barcodeIndex'])->name('products.barcode.index');
    Route::post('product/barcode/print', [ProductController::class, 'barcodePrint'])->name('products.barcode.print');

    // Database Backup Routes
    Route::get('/backups', [BackupController::class, 'index'])->name('backups.index');
    Route::post('/backups/create', [BackupController::class, 'create'])->name('backups.create');
    Route::get('/backups/download/{file}', [BackupController::class, 'download'])->name('backups.download');
    Route::delete('/backups/delete/{file}', [BackupController::class, 'destroy'])->name('backups.destroy');
});

// Canonical customer URLs. Existing customer/user URLs below remain compatible.
Route::prefix('account')->name('account.')->group(function () {
    Route::get('/login', [FrontendUserController::class, 'userLogin'])->middleware('customer.guest')->name('login');
    Route::post('/otp/send', [FrontendUserController::class, 'sendOtp'])->middleware('throttle:3,1')->name('otp.send');
    Route::post('/otp/verify', [FrontendUserController::class, 'verifyOtp'])->middleware('throttle:5,1')->name('otp.verify');
    Route::get('/otp/cancel', [FrontendUserController::class, 'cancelOtp'])->name('otp.cancel');
    Route::middleware('customer')->group(function () {
        Route::get('/', [FrontendUserController::class, 'dashboard'])->name('dashboard');
        Route::get('/orders', [FrontendUserController::class, 'orders'])->name('orders.index');
        Route::get('/orders/{orderNumber}', [FrontendUserController::class, 'orderShow'])->name('orders.show');
        Route::get('/profile', [FrontendUserController::class, 'profile'])->name('profile.edit');
        Route::post('/profile', [FrontendUserController::class, 'profileUpdate'])->name('profile.update');
        Route::get('/password', [FrontendUserController::class, 'customerChangePassword'])->name('password.edit');
        Route::post('/password', [FrontendUserController::class, 'updatePassword'])->name('password.update');
        Route::post('/logout', [FrontendUserController::class, 'logout'])->name('logout');
    });
});

Route::middleware('customer.guest')->group(function () {
    Route::get('user-login', [FrontendUserController::class, 'userLogin'])->name('user.login');
    // Route::post('user-login',[FrontendUserController::class, 'storeLogin'])->name('user.login.store');
    // Route::get('user-register',[FrontendUserController::class, 'userRegister'])->name('user.register');
    // Route::post('user-register',[FrontendUserController::class, 'storeRegister'])->name('user.register.store');

});
Route::middleware(['customer'])->group(function () {
    Route::get('/customer/dashboard', [FrontendUserController::class, 'dashboard'])->name('customer.dashboard');
    Route::get('/customer/orders', [FrontendUserController::class, 'orders'])->name('customer.orders');
    Route::get('/customer/orders/{id}', [FrontendUserController::class, 'orderShow'])->name('customer.order.show');
    Route::get('customer-address', [FrontendUserController::class, 'profile'])->name('customer.address');
    Route::post('customer-address-update', [FrontendUserController::class, 'profileUpdate'])->name('customer.address.update');
    Route::get('customer-change-password', [FrontendUserController::class, 'customerChangePassword'])->name('customer.change.password');
    Route::post('/customer/change-password', [FrontendUserController::class, 'updatePassword'])->name('customer.password.update');
    Route::get('customer-profile', [FrontendUserController::class, 'profile'])->name('customer.profile');
    Route::post('customer-profile-update', [FrontendUserController::class, 'profileUpdate'])->name('customer.profile.update');
    Route::post('customer-logout', [FrontendUserController::class, 'logout'])->name('customer.logout');
});

require __DIR__.'/auth.php';





