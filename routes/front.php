<?php
use App\Http\Controllers\front\AuthController;
use App\Http\Controllers\front\FrontCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\front\FrontController;
use App\Http\Controllers\front\ShopController;
use App\Http\Controllers\front\CartController;
use App\Http\Controllers\front\PaymentController;
use App\Http\Controllers\front\LocalizationController;
use App\Http\Controllers\front\SearchController;
use App\Http\Controllers\front\ChatController;
use App\Http\Controllers\front\AttributeController;
use App\Http\Controllers\front\SettingsController;
use App\Http\Controllers\API\ProductSearchController;
use App\Http\Controllers\front\ChatbotController;
use Inertia\Inertia;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware ApiRoutesControllergroup. Make something great!
|
*/
// Route::get('/test', function(){
// });
Route::get('/prosearch', [ProductSearchController::class, 'search']);
Route::post('/chatbot/message', [ChatbotController::class, 'reply'])->name('front.chatbot.reply');
Route::get('/', [FrontController::class, 'index'])->name('front.home');
Route::get('/settings', [SettingsController::class, 'index'])->name('front.settings');
Route::get('/shop/{cat_slug?}/{subcat_slug?}/{subsubcat_slug?}', [ShopController::class, 'index'])->name('front.shop');
Route::get('search', [SearchController::class, 'search'])->name('product.search');
Route::get('/search/products', [SearchController::class, 'searchProducts'])
    ->name('front.search.products');
// Route::post('/shopfilter', [ShopController::class, 'filterRequest'])->name('front.shopfilter');
Route::get('product/{slug}', [ShopController::class, 'product'])->name('front.product');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('front.addToCart');
Route::post('/updateCartItem', [CartController::class, 'updateCartItem'])->name('front.updateCartItem');
Route::post('/update-cart', [CartController::class, 'updateCart'])->name('front.updateCart');
Route::post('/delete-cart', [CartController::class, 'deleteitem'])->name('front.deleteitem.cart');
Route::post('/move-item', [CartController::class, 'moveItemToWishlist'])->name('front.moveitemtowishlist.cart');
Route::get('/checkout', [CartController::class, 'checkout'])->name('front.checkout');
Route::get('/payment', [CartController::class, 'Payment'])->name('front.payment');
Route::post('/process-checkout', [PaymentController::class, 'processCheckout'])->name('front.processCheckout');
Route::get('/stripeSuccess', [PaymentController::class, 'stripeSuccess'])->name('front.stripeSuccess');
Route::get('stripe/cancel', [PaymentController::class, 'stripeCancel'])->name('stripe.cancel');
Route::get('paypal/payment', [PaymentController::class, 'payWithPaypal'])->name('paypal.payment');
Route::get('paypal/success', [PaymentController::class, 'paypalSuccess'])->name('paypal.success');
Route::get('paypal/cancel', [PaymentController::class, 'paypalCancel'])->name('paypal.cancel');
Route::get('/order-placed', [CartController::class, 'orderPlaced'])->name('front.orderPlaced');
Route::get('/order-details/{orderId}', [AuthController::class, 'orderDetails'])->name('front.orderDetails');
Route::get('/order/invoice-html/{orderId}', [AuthController::class, 'invoiceHtml'])->name('order.invoice-html')->middleware('auth');
Route::get('/thanks', [CartController::class, 'thankyou'])->name('front.thankyou');
Route::post('/get-order-summery', [CartController::class, 'getOrderSummary'])->name('front.getOrderSummary');
Route::post('/apply-coupon', [CartController::class, 'apply_discount'])->name('front.applycoupon');
Route::post('/remove-discount', [CartController::class, 'removecoupon'])->name('front.removediscount');
Route::get('/coupons', [CartController::class, 'couponPage'])->name('front.coupons');
Route::post('/add-to-Wishlist', [FrontController::class, 'addToWishlist'])->name('front.addtowishlist');
Route::get('/languages', [LocalizationController::class, 'show'])->name('account.languages');
Route::get('/currency', [LocalizationController::class, 'showCurrency'])->name('front.currency');
Route::post('/currency/change', [LocalizationController::class, 'change'])->name('currency.change');
Route::get('/lang/{locale_id}', [LocalizationController::class, 'index'])->name('front.localizationcontroller');
Route::post('rating-saving/', action: [ShopController::class, 'productRating'])->name('front.productRating');
Route::get('/brand/{id}', [ShopController::class, 'brandProducts'])->name('front.brandProducts');
Route::get('Categories', [FrontCategoryController::class, 'getAllCategory'])->name('product.getCategories');
Route::get('InnerCategory/{categoryid}', [FrontCategoryController::class, 'getInnerCategory'])->name('product.getInnerCategory');
Route::post('color', [AttributeController::class, 'change_color'])->name('product.change_color');
Route::post('size', [AttributeController::class, 'sizeChange'])->name('product.sizeChange');
Route::post('getcolor', [AttributeController::class, 'getcolors'])->name('product.getcolor');
Route::get('/load-product-modal/{productId}', [FrontController::class, 'loadProductModal'])->name('load-product-modal');
Route::get('/lang/{locale_id}', [LocalizationController::class, 'index'])->name('front.localizationcontroller');
Route::group(['prefix' => 'account'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::GET('/register', [AuthController::class, 'register'])->name('account.register');
        Route::post('/process-register', [AuthController::class, 'processRegister'])->name('account.processRegister');
        Route::GET('/login', [AuthController::class, 'login'])->name('account.login');
        Route::post('/login', [AuthController::class, 'authenticate'])->name('account.authenticate');
        // Register with Github
        Route::GET('/auth/redirect', [AuthController::class, 'githubRedirect'])->name('auth.github');
        Route::GET('/auth/callback', [AuthController::class, 'githubCallback'])->name('auth.githubcallback');
        // Register with Google
        Route::GET('/auth/redirect/google', [AuthController::class, 'googleRedirect'])->name('auth.google');
        Route::GET('/auth/callback/google', [AuthController::class, 'googleCallback'])->name('auth.googlecallback');
        // Register with Facebook
        Route::GET('/auth/redirect/facebook', [AuthController::class, 'facebookRedirect'])->name('auth.facebook');
        Route::GET('/auth/callback/facebook', [AuthController::class, 'facebookCallback'])->name('auth.facebookcallback');
        // Login with Google
        Route::GET('/auth/callbacklogin/google', [AuthController::class, 'googleCallbacklogin'])->name('auth.googlecallbacklogin');
        // Login with Facebook
        Route::GET('/auth/callbacklogin/facebook', [AuthController::class, 'facebookCallbacklogin'])->name('auth.facebookcallbacklogin');
        Route::GET('/search-orders', [AuthController::class, 'searchOrders'])->name('account.searchOrders');
    });
    Route::group(['middleware' => 'auth'], function () {
        Route::GET('/profile', [AuthController::class, 'profile'])->name('account.profile');
        Route::GET('/address', [AuthController::class, 'address'])->name('account.address');
        Route::GET('/savedAddress', [AuthController::class, 'savedAddress'])->name('account.savedAddress');
        Route::GET('/newAddress', [AuthController::class, 'newAddress'])->name('account.newAddress');
        Route::GET('/editAddress/{address_id}', [AuthController::class, 'EditAddress'])->name('account.EditAddress');
        Route::POST('/storeAddress', [AuthController::class, 'storeAddress'])->name('account.storeAddress');
        Route::post('/remove-address', [AuthController::class, 'removeAddress'])->name('account.removeAddress');
        Route::PUT('/addressupdate', [AuthController::class, 'addressupdate'])->name('account.addressupdate');
        Route::GET('/profileedit', [AuthController::class, 'profileEdit'])->name('account.profileEdit');
        Route::put('/profileedit', [AuthController::class, 'updateProfileData'])->name('account.updateProfileData');
        Route::GET('/my-orders', [AuthController::class, 'order'])->name('account.orders');
        Route::GET('/order-detail/{orderid}', [AuthController::class, 'orderdetail'])->name('account.orderdetail');
        Route::GET('/mywishlist', [AuthController::class, 'wishlist'])->name('account.wishlist');
        Route::POST('/remove-product-from-wishlist', [AuthController::class, 'remove_product_from_wishlist'])->name('account.remove_product_from_wislist');
        Route::GET('/logout', [AuthController::class, 'logout'])->name('account.logout');
        Route::get('/chat-box', [ChatController::class, 'renderchatbox'])->name('front.chat');
        Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('send.message');
        Route::get('/fetch-messages/{receiverId}', [ChatController::class, 'fetchMessages'])->name('fetch.messages');
        Route::post('/mark-as-read/{receiverId}', [ChatController::class, 'markAsRead'])->name('mark.as.read');
        Route::get('/cart', [CartController::class, 'cart'])->name('front.cart');
    });
});
Route::fallback(function () {
    return Inertia::render('Front/PageNotFound')
        ->toResponse(request())
        ->setStatusCode(404);
});