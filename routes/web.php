<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Buyer\CartController;
use App\Http\Controllers\Buyer\ReviewController;
use App\Http\Controllers\DeliveryAddressController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\CategoryController;
use App\Http\Controllers\Seller\OrderController;
use App\Http\Controllers\Seller\ShippingController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('buyer.dashboard');
})->name('home');

Route::get('/welcome', [BuyerController::class, 'index'])->name('buyer.dashboard');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {  
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/admin/manage-seller', [AdminController::class, 'showManageSeller'])->name('manage-seller');
    Route::get('/admin/manage-buyer', [AdminController::class, 'showManageBuyer'])->name('manage-buyer');
});



Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerController::class, 'index'])->name('dashboard');
    
    Route::resource('products', ProductController::class)->except(['show']);
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('shippings', ShippingController::class)->except(['show']);
    Route::resource('orders', OrderController::class)->except(['show']);
});

Route::middleware(['auth'])->prefix('profile')->name('profile.')->group(function () {
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('update');
});

Route::middleware(['auth', 'role:buyer'])->group(function () {
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // buyer account
    Route::get('/my-account', [BuyerController::class, 'showAccount'])->name('my-account');
    Route::resource('delivery-addresses', DeliveryAddressController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    
    // REVIEWS
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

require __DIR__.'/auth.php';
