<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\ShippingMethodController;
use App\Http\Controllers\WebhookController;
Route::get('/', function () {
    return view('welcome');
});


// Login user
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});


// route logout
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Route Registrasi
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);


Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/redirect-after-login', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('home'); // untuk user biasa
})->middleware('auth'); 


// Auth Routes
require __DIR__.'/auth.php';



// Rute untuk produk
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

// Definisikan route untuk detail produk
Route::get('/produk/{id}', [ProductController::class, 'show'])
    ->middleware('auth')
    ->name('detail');

    Route::middleware('auth')->prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
    
        Route::get('/alamat', [ProfileController::class, 'alamat'])->name('profile.alamat');
        Route::get('/alamat/edit', [ProfileController::class, 'editAlamat'])->name('profile.editalamat');
        Route::put('/alamat/update', [ProfileController::class, 'updateAlamat'])->name('profile.updateAlamat');
    
        Route::get('/password', [ProfileController::class, 'password'])->name('profile.password');
        Route::put('/password/update', [ProfileController::class, 'updatePassword'])->name('profile.updatepassword');
    });
    


Route::get('/chatroom', function () {
    return view('chatroom');
})->name('chatroom');


Route::middleware('auth')->group(function () {
    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartId}', [CartController::class, 'remove'])->name('cart.remove');
});
    
// checkout 
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
    Route::post('/checkout/apply-voucher', [CheckoutController::class, 'applyVoucher'])->name('checkout.applyVoucher');
});

// orders user
Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrdersController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrdersController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/cancel', [OrdersController::class, 'cancel'])->name('orders.cancel');
    Route::get('/orders/{id}/pay', [OrdersController::class, 'pay'])->name('orders.pay');
});



    // profile admin
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {
         // voucher admin
         Route::resource('voucher', VoucherController::class);
         
        
        // dashboard admin
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');

        // category admin
        Route::resource('categories', CategoryController::class);

        // rekomendasi produk admin
        Route::post('/admin/products/update-rekomendasi/{id}', [ProductController::class, 'updateRekomendasi']);

        // produk admin
        Route::resource('products', ProductController::class);

        // order admin
        Route::get('/order', [OrderController::class, 'index'])->name('order.index');
        Route::put('/orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');

        // sales admin
        Route::resource('sales', SaleController::class);

        // pengiriman admin
        Route::resource('shipping', ShippingMethodController::class);
        
    });

   
