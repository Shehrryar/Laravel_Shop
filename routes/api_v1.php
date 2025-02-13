<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\admin\DiscountCodeController;
use App\Http\Controllers\API\admin\DiscountController;
use App\Http\Controllers\API\admin\ShippingController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\admin\AdminLoginController;
use App\Http\Controllers\API\admin\HomeController;
use App\Http\Controllers\API\admin\CategoryController;
use App\Http\Controllers\API\admin\imageuploadcontroller;
use App\Http\Controllers\API\admin\SubCategoryController;
use App\Http\Controllers\API\admin\SubSubCategoryController;
use App\Http\Controllers\API\admin\BrandController;
use App\Http\Controllers\API\admin\ProductController;
use App\Http\Controllers\API\admin\ProductSubCategoryController;
use App\Http\Controllers\API\admin\ProductImageControlller;
use App\Http\Controllers\API\FrontController;
use App\Http\Controllers\API\ShopController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\LocalizationController;
use App\Http\Controllers\API\admin\LanguageController;
use App\Http\Controllers\API\admin\OrderController;
use App\Http\Controllers\API\admin\UserController;
use App\Http\Controllers\API\admin\ColorController;
use App\Http\Controllers\API\admin\SizeController;
use App\Http\Controllers\API\SearchController;
use App\Http\Controllers\API\admin\StockManagementController;
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/index', [FrontController::class, 'index'])->name('front.home');
    Route::get('/shop/{cat_slug?}/{subcat_slug?}/{subsubcat_slug?}', [ShopController::class, 'index'])->name('front.shop');
    Route::get('product/{slug}', [ShopController::class, 'product'])->name('front.product');
    Route::get('/cart', [CartController::class, 'cart'])->name('front.cart');
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('front.addToCart');
    Route::post('/update-cart', [CartController::class, 'updateCart'])->name('front.updateCart');
    Route::post('/delete-cart', [CartController::class, 'deleteitem'])->name('front.deleteitem.cart');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('front.checkout');
    Route::post('/process-checkout', [CartController::class, 'processCheckout'])->name('front.processCheckout');
    Route::get('/thanks', [CartController::class, 'thankyou'])->name('front.thankyou');
    Route::post('/get-order-summery', [CartController::class, 'getOrderSummary'])->name('front.getOrderSummary');
    Route::post('/apply-discount', [CartController::class, 'apply_discount'])->name('front.applydiscount');
    Route::post('/remove-discount', [CartController::class, 'removecoupon'])->name('front.removediscount');
    Route::post('/add-to-Wishlist', [FrontController::class, 'addToWishlist'])->name('front.addtowishlist');
    Route::get('/lang/{locale_id}', [LocalizationController::class, 'index'])->name('front.localizationcontroller');
    Route::post('rating-saving/{product_id}', [ShopController::class, 'productRating'])->name('front.productRating');
    Route::post('search', [SearchController::class, 'search'])->name('product.search');
});
Route::group(['prefix' => 'account'], function () {
    Route::post('/process-register', [AuthController::class, 'processRegister'])->name('account.processRegister');
    // Register with Githud
    Route::GET('/auth/redirect', [AuthController::class, 'githubRedirect'])->name('auth.github');
    Route::GET('/auth/callback', [AuthController::class, 'githubCallback'])->name('auth.githubcallback');
    // Register with Google
    Route::GET('/auth/redirect/google', [AuthController::class, 'googleRedirect'])->name('auth.google');
    Route::GET('/auth/callback/google', [AuthController::class, 'googleCallback'])->name('auth.googlecallback');
    // Register with Facebook
    Route::GET('/auth/redirect/facebook', [AuthController::class, 'facebookRedirect'])->name('auth.facebook');
    Route::GET('/auth/callback/facebook', [AuthController::class, 'facebookCallback'])->name('auth.facebookcallback');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('account.authenticate');
    Route::middleware('auth:sanctum')->group(function () {
        Route::GET('/profile', [AuthController::class, 'profile'])->name('account.profile');
        Route::GET('/my-orders', [AuthController::class, 'order'])->name('account.orders');
        Route::GET('/order-detail/{orderid}', [AuthController::class, 'orderdetail'])->name('account.orderdetail');
        Route::GET('/mywishlist', [AuthController::class, 'wishlist'])->name('account.wishlist');
        Route::POST('/remove-product-from-wishlist', [AuthController::class, 'remove_product_from_wishlist'])->name('account.remove_product_from_wislist');
        Route::POST('/logout', [AuthController::class, 'logout'])->name('account.logout');
    });
});
Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', action: [AdminLoginController::class, 'index'])->name('admin.login');
    Route::post('/authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');
        //Localization for admin
        Route::get('/lang/{locale_id}', [LocalizationController::class, 'index'])->name('admin.localizationcontroller');
        // category routes
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/update/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::post('/upload-temp-image', [imageuploadcontroller::class, 'create'])->name('temp-images.create');
        Route::delete('/categories/destroy/{category}', [CategoryController::class, 'destroy'])->name('categories.delete');
        Route::get('/getslug', [CategoryController::class, 'slug_function'])->name('getslug');
        // sub-category routes
        Route::get('/subcategory', [SubCategoryController::class, 'index'])->name('subcategories.index');
        Route::get('/subcategory/create', [SubCategoryController::class, 'create'])->name('subcategory.create');
        Route::post('/subcategory/store', [SubCategoryController::class, 'store'])->name('subcategory.store');
        Route::get('/subcategory/{subcatedit}/edit', [SubCategoryController::class, 'edit'])->name('subcategory.edit');
        Route::put('/subcategory/update/{subcategory}', [SubCategoryController::class, 'update'])->name('subcategory.update');
        Route::delete('/subcategory/delete/{subcategory}', action: [SubCategoryController::class, 'destroy'])->name('subcategory.delete');
        // sub-category routes
        Route::get('/subsubcategory', [SubSubCategoryController::class, 'index'])->name('subsubcategories.index');
        Route::get('/subsubcategory/create', [SubSubCategoryController::class, 'create'])->name('subsubcategory.create');
        Route::post('/subsubcategory/store', [SubSubCategoryController::class, 'store'])->name('subsubcategory.store');
        Route::get('/subsubcategory/{subcatedit}/edit', [SubSubCategoryController::class, 'edit'])->name('subsubcategory.edit');
        Route::put('/subsubcategory/update/{subcategory}', [SubSubCategoryController::class, 'update'])->name('subsubcategory.update');
        Route::delete('/subsubcategory/delete/{subcategory}', [SubSubCategoryController::class, 'destroy'])->name('subsubcategory.delete');
        // these route for the brand
        Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
        Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
        Route::post('/brands/store', [BrandController::class, 'store'])->name('brands.store');
        Route::get('/brands/{brandedit}/edit', [BrandController::class, 'edit'])->name('brands.edit');
        Route::put('/brands/update/{brandupadate}', [BrandController::class, 'update'])->name('brands.update');
        Route::delete('/brands/delete/{brandelete}', [BrandController::class, 'destroy'])->name('brands.delete');
        //these routes is for creating languages
        Route::get('/language', [LanguageController::class, 'index'])->name('language.index');
        Route::get('/language/create', [LanguageController::class, 'create'])->name('language.create');
        Route::post('/language/store', [LanguageController::class, 'store'])->name('language.store');
        Route::get('/language/{languageedit}/edit', [LanguageController::class, 'edit'])->name('language.edit');
        Route::put('/language/update/{languageupadate}', [LanguageController::class, 'update'])->name('language.update');
        Route::delete('/language/delete/{langdelete}', [LanguageController::class, 'destroy'])->name('language.delete');
        // these routes are for the Products
        Route::get('/product', [ProductController::class, 'index'])->name('product.index');
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/product_subcatageries', [ProductSubCategoryController::class, 'index'])->name('productsubcat.index');
        Route::get('/product_subsubcatageries', [ProductSubCategoryController::class, 'subcategory'])->name('productsubcat.subcategory');
        Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/product/update/{productupadate}', [ProductController::class, 'update'])->name('product.update');
        Route::post('/product-images/update', [ProductImageControlller::class, 'update'])->name('product-images.update');
        Route::delete('/product-images', [ProductImageControlller::class, 'destroy'])->name('product-images.destroy');
        Route::delete('/product/delete/{delete}', [ProductController::class, 'delete'])->name('product.delete');
        Route::get('/get-products', [ProductController::class, 'getProducts'])->name('product.getProducts');
        Route::post('/import-products', [ProductController::class, 'importProducts'])->name('product.importProducts');
        // shipping Routes
        Route::get('/shipping/create', [ShippingController::class, 'create'])->name('shipping.create');
        Route::post('/shipping/store', [ShippingController::class, 'store'])->name('shipping.store');
        Route::get('/shipping/{id}', [ShippingController::class, 'edit'])->name('shipping.edit');
        Route::put('/shipping/update/{id}', [ShippingController::class, 'update'])->name('shipping.update');
        Route::delete('/shipping/delete/{id}', [ShippingController::class, 'destroy'])->name('shipping.delete');
        // Order Routes
        Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
        Route::get('/orders/{order_id}', [OrderController::class, 'detail'])->name('order.detail');
        Route::post('/orders/change_status/{id}', [OrderController::class, 'changeOrderStatus'])->name('order.changeorderstatus');
        Route::post('/orders/sent-email/{id}', [OrderController::class, 'sendInvoiceEmail'])->name('order.sendinvoiceemail');
        // Route for the discont coupon
        Route::get('/coupons/index', [DiscountCodeController::class, 'index'])->name('coupon.index');
        Route::get('/coupons/create', [DiscountCodeController::class, 'create'])->name('coupon.create');
        Route::post('/coupons/store', [DiscountCodeController::class, 'store'])->name('coupon.store');
        Route::get('/coupons/{id}/edit', [DiscountCodeController::class, 'edit'])->name('coupon.edit');
        Route::put('/coupons/{id}/update', [DiscountCodeController::class, 'update'])->name('coupon.update');
        Route::delete('/coupons/{id}/delete', [DiscountCodeController::class, 'destroy'])->name('coupon.delete');
        // Route for the discounts
        Route::get('/discount/index', [DiscountController::class, 'index'])->name('discount.index');
        Route::get('/discount/create', [DiscountController::class, 'create'])->name('discount.create');
        Route::post('/discount/store', [DiscountController::class, 'store'])->name('discount.store');
        Route::get('/discount/{id}/edit', [DiscountController::class, 'edit'])->name('discount.edit');
        Route::put('/discount/{id}/update', [DiscountController::class, 'update'])->name('discount.update');
        Route::delete('/discount/{id}/delete', [DiscountController::class, 'destroy'])->name('discount.delete');
        // user routes
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{useredit}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/update/{userupadate}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/delete/{userelete}', [UserController::class, 'destroy'])->name('users.delete');
        // add route for the color
        Route::get('/colorss/index', [ColorController::class, 'index'])->name('colorss.index');
        Route::get('/colorss/create', [ColorController::class, 'create'])->name('colorss.create');
        Route::post('/colorss/store', [ColorController::class, 'store'])->name('colorss.store');
        Route::get('/colorss/{colorsedit}/edit', [ColorController::class, 'edit'])->name('colorss.edit');
        Route::put('/colorss/update/{colorsupadate}', [ColorController::class, 'update'])->name('colorss.update');
        Route::delete('/colorss/delete/{colorselete}', [ColorController::class, 'destroy'])->name('colorss.delete');
        // add route for the size
        Route::get('/sizes/index', [SizeController::class, 'index'])->name('sizes.index');
        Route::get('/sizes/create', [SizeController::class, 'create'])->name('sizes.create');
        Route::post('/sizes/store', [SizeController::class, 'store'])->name('sizes.store');
        Route::get('/sizes/{sizeedit}/edit', [SizeController::class, 'edit'])->name('sizes.edit');
        Route::put('/sizes/update/{sizeupadate}', [SizeController::class, 'update'])->name('sizes.update');
        Route::delete('/sizes/delete/{sizeelete}', [SizeController::class, 'destroy'])->name('sizes.delete');
        // add route for the Stock managment
        Route::get('/stock', [StockManagementController::class, 'index'])->name('stock.index');
        Route::get('/stock/create', [StockManagementController::class, 'create'])->name('stock.create');
        Route::post('/stock/store', [StockManagementController::class, 'store'])->name('stock.store');
        Route::get('/stock/{stockedit}/edit', [StockManagementController::class, 'edit'])->name('stock.edit');
        Route::put('/stock/update/{stockupadate}', [StockManagementController::class, 'update'])->name('stock.update');
        Route::delete('/stock/delete/{stockelete}', [StockManagementController::class, 'destroy'])->name('stock.delete');
        // dashboard
        Route::get('/dashboard/index', [LocalizationController::class, 'dashborad'])->name('dashboard.index');
    });
});