<?php
use App\Http\Controllers\admin\DiscountCodeController;
use App\Http\Controllers\admin\DiscountController;
use App\Http\Controllers\admin\ShippingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\imageuploadcontroller;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\SubSubCategoryController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductSubCategoryController;
use App\Http\Controllers\admin\ProductImageControlller;
use App\Http\Controllers\admin\LanguageController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\ColorController;
use App\Http\Controllers\admin\SizeController;
use App\Http\Controllers\admin\StockManagementController;
use App\Http\Controllers\admin\ProductAttributeController;
use App\Http\Controllers\admin\CurrencyController;
use App\Http\Controllers\admin\adminChatController;
use App\Http\Controllers\admin\ApiRoutesController;
use App\Http\Controllers\admin\FrontApiController;
use App\Http\Controllers\admin\promotionController;
use App\Http\Controllers\admin\onboardingController;
use App\Http\Controllers\admin\ThemeController;
use App\Http\Controllers\admin\HomepageLabelController;
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
Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });
    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/dashboard', [HomeController::class, 'dashborad'])->name('dashboard.index');
        Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');
        //Localization for admin
        // category routes
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::post('/upload-temp-image', [imageuploadcontroller::class, 'create'])->name('temp-images.create');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.delete');
        Route::get('/getslug', [CategoryController::class, 'slug_function'])->name('getslug');
        // sub-category routes
        Route::get('/subcategory', [SubCategoryController::class, 'index'])->name('subcategories.index');
        Route::get('/subcategory/create', [SubCategoryController::class, 'create'])->name('subcategory.create');
        Route::post('/subcategory/store', [SubCategoryController::class, 'store'])->name('subcategory.store');
        Route::get('/subcategory/{subcatedit}/edit', [SubCategoryController::class, 'edit'])->name('subcategory.edit');
        Route::put('/subcategory/{subcategory}', [SubCategoryController::class, 'update'])->name('subcategory.update');
        Route::delete('/subcategory/{subcategory}', [SubCategoryController::class, 'destroy'])->name('subcategory.delete');
        // sub-category routes
        Route::get('/subsubcategory', [SubSubCategoryController::class, 'index'])->name('subsubcategories.index');
        Route::get('/subsubcategory/create', [SubSubCategoryController::class, 'create'])->name('subsubcategory.create');
        Route::post('/subsubcategory/store', [SubSubCategoryController::class, 'store'])->name('subsubcategory.store');
        Route::get('/subsubcategory/{subcatedit}/edit', [SubSubCategoryController::class, 'edit'])->name('subsubcategory.edit');
        Route::put('/subsubcategory/{subcategory}', [SubSubCategoryController::class, 'update'])->name('subsubcategory.update');
        Route::delete('/subsubcategory/{subcategory}', [SubSubCategoryController::class, 'destroy'])->name('subsubcategory.delete');
        // these route for the brand
        Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
        Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
        Route::post('/brands/store', [BrandController::class, 'store'])->name('brands.store');
        Route::get('/brands/{brandedit}/edit', [BrandController::class, 'edit'])->name('brands.edit');
        Route::put('/brands/{brandupadate}', [BrandController::class, 'update'])->name('brands.update');
        Route::delete('/brands/{brandelete}', [BrandController::class, 'destroy'])->name('brands.delete');
        //these routes is for creating languages
        Route::get('/language', [LanguageController::class, 'index'])->name('language.index');
        Route::get('/language/create', [LanguageController::class, 'create'])->name('language.create');
        Route::post('/language/store', [LanguageController::class, 'store'])->name('language.store');
        Route::get('/language/{languageedit}/edit', [LanguageController::class, 'edit'])->name('language.edit');
        Route::put('/language/{languageupadate}', [LanguageController::class, 'update'])->name('language.update');
        Route::delete('/language/{langdelete}', [LanguageController::class, 'destroy'])->name('language.delete');
        // these routes are for the Products
        Route::get('/product', [ProductController::class, 'index'])->name('product.index');
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/product', [ProductController::class, 'store'])->name('product.store');
        Route::get('/product_subcatageries', [ProductSubCategoryController::class, 'index'])->name('productsubcat.index');
        Route::get('/product_subsubcatageries', [ProductSubCategoryController::class, 'subcategory'])->name('productsubcat.subcategory');
        Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/product/{productupadate}', [ProductController::class, 'update'])->name('product.update');
        Route::post('/product-images/update', [ProductImageControlller::class, 'update'])->name('product-images.update');
        Route::delete('/product-images', [ProductImageControlller::class, 'destroy'])->name('product-images.destroy');
        Route::delete('/product/{delete}', [ProductController::class, 'delete'])->name('product.delete');
        Route::get('/get-products', [ProductController::class, 'getProducts'])->name('product.getProducts');
        Route::post('/import-products', [ProductController::class, 'importProducts'])->name('product.importProducts');
        // Prodcut attribute Routes
        Route::get('/productattribute', [ProductAttributeController::class, 'index'])->name('productattribute.index');
        Route::get('/productattribute/create', [ProductAttributeController::class, 'create'])->name('productattribute.create');
        Route::post('/productattribute/store', [ProductAttributeController::class, 'store'])->name('productattribute.store');
        Route::get('/productattribute/edit/{id}', [ProductAttributeController::class, 'edit'])->name('productattribute.edit');
        Route::put('/productattribute/update/{id}', [ProductAttributeController::class, 'update'])->name('productattribute.update');
        Route::delete('/productattribute/delete/{id}', [ProductAttributeController::class, 'destroy'])->name('productattribute.delete');
        // shipping Routes
        Route::get('/shipping/create', [ShippingController::class, 'create'])->name('shipping.create');
        Route::post('/shipping/store', [ShippingController::class, 'store'])->name('shipping.store');
        Route::get('/shipping/{id}', [ShippingController::class, 'edit'])->name('shipping.edit');
        Route::put('/shipping/{id}', [ShippingController::class, 'update'])->name('shipping.update');
        Route::delete('/shipping/{id}', [ShippingController::class, 'destroy'])->name('shipping.delete');
        // Order Routes
        Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
        Route::get('/orders/{order_id}', [OrderController::class, 'detail'])->name('order.detail');
        Route::get('/orderspdf/{order_id}', [OrderController::class, 'getOrderDetailPdf'])->name('order.detailPdf');
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
        Route::put('/users/{userupadate}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{userelete}', [UserController::class, 'destroy'])->name('users.delete');
        // add route for the color
        Route::get('/colorss', [ColorController::class, 'index'])->name('colorss.index');
        Route::get('/colorss/create', [ColorController::class, 'create'])->name('colorss.create');
        Route::post('/colorss/store', [ColorController::class, 'store'])->name('colorss.store');
        Route::get('/colorss/{colorsedit}/edit', [ColorController::class, 'edit'])->name('colorss.edit');
        Route::put('/colorss/{colorsupadate}', [ColorController::class, 'update'])->name('colorss.update');
        Route::delete('/colorss/{colorselete}', [ColorController::class, 'destroy'])->name('colorss.delete');
        Route::get('/themes/index', [ThemeController::class, 'index'])->name('themes.index');
        Route::get('/themes/create', [ThemeController::class, 'create'])->name('themes.create');
        Route::post('/themes/store', [ThemeController::class, 'store'])->name('themes.store');
        Route::get('/themes/{themeedit}/edit', [ThemeController::class, 'edit'])->name('themes.edit');
        Route::put('/themes/{themeupdate}/update', [ThemeController::class, 'update'])->name('themes.update');
        Route::delete('/themes/{themedelete}/delete', [ThemeController::class, 'destroy'])->name('themes.delete');
        // add route for the size
        Route::get('/sizes', [SizeController::class, 'index'])->name('sizes.index');
        Route::get('/sizes/create', [SizeController::class, 'create'])->name('sizes.create');
        Route::post('/sizes/store', [SizeController::class, 'store'])->name('sizes.store');
        Route::get('/sizes/{sizeedit}/edit', [SizeController::class, 'edit'])->name('sizes.edit');
        Route::put('/sizes/{sizeupadate}', [SizeController::class, 'update'])->name('sizes.update');
        Route::delete('/sizes/{sizeelete}', [SizeController::class, 'destroy'])->name('sizes.delete');
        // add route for the Stock
        Route::get('/stock', [StockManagementController::class, 'index'])->name('stock.index');
        Route::get('/stock/create', [StockManagementController::class, 'create'])->name('stock.create');
        Route::post('/stock/store', [StockManagementController::class, 'store'])->name('stock.store');
        Route::get('/stock/{sizeedit}/edit', [StockManagementController::class, 'edit'])->name('stock.edit');
        Route::put('/stock/{sizeupadate}', [StockManagementController::class, 'update'])->name('stock.update');
        Route::delete('/stock/{sizeelete}', [StockManagementController::class, 'destroy'])->name('stock.delete');
        // added route for the currencies
        Route::get('/currencies', [CurrencyController::class, 'index'])->name('currency.index');
        Route::get('/currencies/create', [CurrencyController::class, 'create'])->name('currency.create');
        Route::post('/currencies/store', [CurrencyController::class, 'store'])->name('currency.store');
        Route::get('/currencies/edit/{currenedit}', [CurrencyController::class, 'edit'])->name('currency.edit');
        Route::put('/currencies/update/{currenedit}', [CurrencyController::class, 'update'])->name('currency.update');
        Route::delete('/currencies/delete/{currenedit}', [CurrencyController::class, 'delete'])->name('currency.delete');
        // added route for the promotions
        Route::get('/promotions', [promotionController::class, 'index'])->name('promotion.index');
        Route::get('/promotions/create', [promotionController::class, 'create'])->name('promotion.create');
        Route::post('/promotions/store', [promotionController::class, 'store'])->name('promotion.store');
        Route::get('/promotions/edit/{promoedit}', [promotionController::class, 'edit'])->name('promotion.edit');
        Route::put('/promotions/update/{promoedit}', [promotionController::class, 'update'])->name('promotion.update');
        Route::delete('/promotions/delete/{promoedit}', [promotionController::class, 'destroy'])->name('promotion.delete');
        // added route for the onboarding
        Route::get('/onboarding', [onboardingController::class, 'index'])->name('onboarding.index');
        Route::get('/onboarding/create', [onboardingController::class, 'create'])->name('onboarding.create');
        Route::post('/onboarding/store', [onboardingController::class, 'store'])->name('onboarding.store');
        Route::get('/onboarding/edit/{bordedit}', [onboardingController::class, 'edit'])->name('onboarding.edit');
        Route::put('/onboarding/update/{bordupdate}', [onboardingController::class, 'update'])->name('onboarding.update');
        Route::delete('/onboarding/delete/{borddel}', [onboardingController::class, 'destroy'])->name('onboarding.delete');
        // route for homepagelable
        Route::get('homepage-labels', [HomepageLabelController::class, 'index'])->name('homepage-labels.index');
        Route::get('homepage-labels/create', [HomepageLabelController::class, 'create'])->name('homepage-labels.create');
        Route::post('homepage-labels', [HomepageLabelController::class, 'store'])->name('homepage-labels.store');
        Route::get('homepage-labels/{id}/edit', [HomepageLabelController::class, 'edit'])->name('homepage-labels.edit');
        Route::put('homepage-labels/{id}', [HomepageLabelController::class, 'update'])->name('homepage-labels.update');
        Route::delete('homepage-labels/{id}', [HomepageLabelController::class, 'destroy'])->name('homepage-labels.delete');
        // added route for the chat
        Route::get('/chat-view', [adminChatController::class, 'index'])->name('chat.index');
        Route::post('/message', [adminChatController::class, 'chatDisplayBox'])->name('chat.chatdisplaybox');
        Route::post('/send-text', [adminChatController::class, 'sendMessage'])->name('chat.sentmessage');
        Route::get('/checkSocket', [adminChatController::class, 'checkSocketMessage'])->name('chat.checkSocketMessage');
        // added route for the webservices
        // route for admin side 
        Route::get('/webservice', [ApiRoutesController::class, 'index'])->name('webservice.index');
        Route::post('/webservice', [ApiRoutesController::class, 'create'])->name('webservice.create');
        // route for front side 
        Route::get('/webservice/front', [FrontApiController::class, 'index'])->name('Frontapi.index');
        Route::post('/webservice/front', [FrontApiController::class, 'create'])->name('FrontApi.create');
    });
});