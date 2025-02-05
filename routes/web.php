<?php
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController; // Tambahkan Controller Cart jika ada


Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->name('home');


// Rute untuk produk
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');



// Admin Dashboard
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Rute untuk halaman profile admin
Route::get('/admin/profile', function () {
    return view('admin.profile');
})->name('admin.profile');

// Registrasi
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

// Login user
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// Logout user
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Rute Admin untuk Produk
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('products', ProductController::class);
});

// Rute Admin untuk Kategori
Route::prefix('admin')->name('admin.')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::resource('kategori', KategoriController::class);
});

// User Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// User Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth Routes
require __DIR__.'/auth.php';


Route::get('/chatroom', function () {
    return view('chatroom');
})->name('chatroom');




// Definisikan route untuk detail produk
Route::get('/produk/{id}', [ProductController::class, 'show'])->name('detail');






Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::delete('/cart/{id}', [CartController::class, 'delete'])->name('cart.delete');





use App\Http\Controllers\ChatbotController;

// Route::post('/chat', [ChatbotController::class, 'chat']);



