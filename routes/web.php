<?php

use App\Http\Controllers\admin\DiscountCodeController;
use App\Http\Controllers\admin\ShippingController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\imageuploadcontroller;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductSubCategoryController;
use App\Http\Controllers\admin\ProductImageControlller;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;



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

Route::get('/', [FrontController::class, 'index'])->name('front.home');
Route::get('/shop/{cat_slug?}/{subcat_slug?}', [ShopController::class, 'index'])->name('front.shop');
Route::get('product/{slug}', [ShopController::class, 'product'])->name('front.product');
Route::get('/cart', [CartController::class, 'cart'])->name('front.cart');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('front.addToCart');
Route::post('/update-cart', [CartController::class, 'updateCart'])->name('front.updateCart');
Route::post('/delete-cart', [CartController::class, 'deleteitem'])->name('front.deleteitem.cart');
Route::get('/checkout', [CartController::class, 'checkout'])->name('front.checkout');
Route::post('/process-checkout', [CartController::class, 'processCheckout'])->name('front.processCheckout');
Route::post('/thanks/{orderId}', [CartController::class, 'thankyou'])->name('front.thankyou');
Route::post('/get-order-summery', [CartController::class, 'getOrderSummary'])->name('front.getOrderSummary');




Route::group(['prefix' => 'account'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::GET('/register', [AuthController::class, 'register'])->name('account.register');
        Route::post('/process-register', [AuthController::class, 'processRegister'])->name('account.processRegister');  
        Route::GET('/login', [AuthController::class, 'login'])->name('account.login');
        Route::post('/login', [AuthController::class, 'authenticate'])->name('account.authenticate');
        
    });
    Route::group(['middleware' => 'auth'], function () {
        Route::GET('/profile', [AuthController::class, 'profile'])->name('account.profile');
        Route::GET('/logout', [AuthController::class, 'logout'])->name('account.logout');

    });
});



Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');

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

        // these route for the brand

        Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
        Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
        Route::post('/brands/store', [BrandController::class, 'store'])->name('brands.store');
        Route::get('/brands/{brandedit}/edit', [BrandController::class, 'edit'])->name('brands.edit');
        Route::put('/brands/{brandupadate}', [BrandController::class, 'update'])->name('brands.update');
        Route::delete('/brands/{brandelete}', [BrandController::class, 'destroy'])->name('brands.delete');

        // these routes are for the Products


        Route::get('/product', [ProductController::class, 'index'])->name('product.index');
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/product', [ProductController::class, 'store'])->name('product.store');
        Route::get('/product_subcatageries', [ProductSubCategoryController::class, 'index'])->name('productsubcat.index');
        Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/product/{productupadate}', [ProductController::class, 'update'])->name('product.update');
        Route::post('/product-images/update', [ProductImageControlller::class, 'update'])->name('product-images.update');
        Route::delete('/product-images', [ProductImageControlller::class, 'destroy'])->name('product-images.destroy');
        Route::delete('/product/{delete}', [ProductController::class, 'delete'])->name('product.delete');
        Route::get('/get-products', [ProductController::class, 'getProducts'])->name('product.getProducts');

        // shipping Routes

        Route::get('/shipping/create', [ShippingController::class, 'create'])->name('shipping.create');
        Route::post('/shipping/store', [ShippingController::class, 'store'])->name('shipping.store');
        Route::get('/shipping/{id}', [ShippingController::class, 'edit'])->name('shipping.edit');
        Route::put('/shipping/{id}', [ShippingController::class, 'update'])->name('shipping.update');
        Route::delete('/shipping/{id}', [ShippingController::class, 'destroy'])->name('shipping.delete');



        // Route for the discont coupon
        

        Route::get('/coupons/create', [DiscountCodeController::class, 'create'])->name('coupon.create');
        Route::post('/coupons/store', [DiscountCodeController::class, 'store'])->name('coupon.store');
        // Route::get('/shipping/{id}', [ShippingController::class, 'edit'])->name('shipping.edit');
        // Route::put('/shipping/{id}', [ShippingController::class, 'update'])->name('shipping.update');
        // Route::delete('/shipping/{id}', [ShippingController::class, 'destroy'])->name('shipping.delete');

    });
});

