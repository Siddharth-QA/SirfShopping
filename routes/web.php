<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\user\AddressController;
use App\Http\Controllers\user\AuthController;
use App\Http\Controllers\user\OrderController;
use App\Http\Controllers\user\ProfileController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

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

Route::get('/clear-cache', function () {
    exec('php artisan up');
    exec('php artisan cache:clear');
    exec('php artisan config:clear');
    exec('php artisan optimize:clear');
    exec('php artisan route:clear');
    exec('php artisan config:cache');
    exec('php artisan view:clear');
    exec('php artisan optimize -force');
    return 'DONE'; //Return anything
});

Route::get('/test', [TestController::class, 'test'])->name('test');

//Home
Route::get('/', [HomeController::class, 'index'])->name('index');

//carts
Route::get('/category/{id}', [HomeController::class, 'category'])->name('category');
Route::post('/save_later', [CartController::class, 'save_later'])->name('save_later');
Route::post('/addToCart', [CartController::class, 'addToCart'])->name('addToCart');
Route::post('/remove', [CartController::class, 'remove'])->name('remove');
Route::post('/updateCart', [CartController::class, 'updateCart'])->name('updateCart');
Route::post('/wishlist', [WishlistController::class, 'wishlist'])->name('wishlist');
Route::post('/wishlist_remove', [WishlistController::class, 'wishlist_remove'])->name('wishlist_remove');
Route::post('/cat-list', [HomeController::class, 'cat_list'])->name('cat-list');

//products Details
Route::get('/detail/{id}', [HomeController::class, 'detail'])->name('detail');
Route::get('/check-out', [HomeController::class, 'check_out'])->name('check-out');
Route::get('/cart', [HomeController::class, 'cart'])->name('cart');
Route::get('/reload/{type}', [HomeController::class, 'reload_cart'])->name('reload.cart');
Route::get('/wishlist', [HomeController::class, 'wishlist'])->name('wishlist');
Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
Route::get('/blog-details', [HomeController::class, 'blog_details'])->name('blog-details');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/404-page', [HomeController::class, 'page_404'])->name('404-page');

//Auth
Route::get('/auth', [AuthController::class, 'index'])->name('login.index');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/auth-reg', [AuthController::class, 'reg'])->name('reg');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => 'user'], function () {

    Route::group(['prefix' => 'user'], function () {

        //Auth
        Route::get('/logout', [AuthController::class, 'logout'])->name('user.logout');
        Route::post('/reset-pass', [AuthController::class, 'reset_pass'])->name('rest.pass');

        //Addresses
        Route::get('/address', [AddressController::class, 'index'])->name('address');
        Route::get('/add-create', [AddressController::class, 'create'])->name('address.create');
        Route::post('/add-store', [AddressController::class, 'store'])->name('address.store');
        Route::get('/edit/{id}', [AddressController::class, 'edit'])->name('address.edit');
        Route::patch('/add-update/{id}', [AddressController::class, 'update'])->name('address.update');
        Route::post('/add-remove', [AddressController::class, 'add_remove'])->name('add_remove');

        //checkOut
        Route::post('/checkout_add', [AddressController::class, 'checkout_add'])->name('checkout_add');
        Route::post('/add-edit', [AddressController::class, 'add_edit'])->name('add_edit');
        Route::post('/address-update', [AddressController::class, 'address_update'])->name('address_update');
        Route::post('/get-state', [CountryController::class, 'get_state']);
        Route::get('/address-status', [AddressController::class, 'address_status'])->name('address_status');

        Route::post('/applyCoupon', [OrderController::class, 'applyCoupon'])->name('applyCoupon');


        //Orders
        Route::get('/order', [HomeController::class, 'order'])->name('order');
        Route::get('/order-details/{id}', [HomeController::class, 'orderDetails'])->name('orderDetails');
        Route::post('/order/update-status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');

        Route::post('/order', [OrderController::class, 'store'])->name('order.store');
        Route::get('/thank-you', [OrderController::class, 'thankYou'])->name('order.thankYou');

        //Profiles
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::post('/profile-update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/change-password', [AuthController::class, 'change_password'])->name('change.password');

                Route::get('/change-password', [AuthController::class, 'change_password'])->name('change.password');

    });
});
