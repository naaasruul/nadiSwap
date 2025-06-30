<?php

use App\Http\Controllers\Admin\ListOrderController;
use App\Http\Controllers\Admin\RatingController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Buyer\CartController;
use App\Http\Controllers\Buyer\ReviewController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DeliveryAddressController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Rent\RentController;
use App\Http\Controllers\Seller\BankAccountController;
use App\Http\Controllers\Seller\CategoryController;
use App\Http\Controllers\Seller\OrderController;
use App\Http\Controllers\Seller\ReportController;
use App\Http\Controllers\Seller\ShippingController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Category;
use App\Models\UserCategoryPreference;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

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

    Route::get('/contact', [ContactController::class, 'show'])->name('contact.index');
    Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/admin/manage-seller', [AdminController::class, 'showManageSeller'])->name('manage-seller');
    Route::get('/admin/manage-buyer', [AdminController::class, 'showManageBuyer'])->name('manage-buyer');

    Route::resource('transactions', TransactionController::class)->except(['show']);
    Route::resource('ratings', RatingController::class)->except(['show']);
    Route::resource('orders', ListOrderController::class)->except(['show']);
});



Route::middleware(['auth', 'role:seller','verified'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerController::class, 'index'])->name('dashboard');
    
    Route::resource('products', ProductController::class)->except(['show']);
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('shippings', ShippingController::class)->except(['show']);
    Route::resource('orders', OrderController::class)->except(['show']);
    Route::resource('reviews', ReviewController::class)->except(['show']);
    Route::resource('reports', ReportController::class)->except(['show']);
    Route::resource('bank-account', BankAccountController::class)->except(['show']);
    
    Route::post('reviews/{review}', [ReviewController::class, 'respond'])->name('reviews.respond');
    Route::post('orders/{order}/update-payment-status', [OrderController::class, 'updatePaymentStatus']);
    Route::post('orders/{order}/update-delivery-status', [OrderController::class, 'updateDeliveryStatus']);
    Route::post('orders/{order}/update-order-status', [OrderController::class, 'updateOrderStatus']);
    
    Route::post('/products/delete-multiple', [ProductController::class, 'deleteMultiple'])->name('seller.products.delete-multiple');
});

Route::middleware(['auth'])->prefix('profile')->name('profile.')->group(function () {
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('update');
});

Route::middleware(['auth', 'role:buyer'])->group(function () {
    Route::delete('/buyer/address/{address}', [BuyerController::class, 'destroyAddress'])->name('buyer.address.destroy');
    Route::put('/buyer/address/{address}', [BuyerController::class, 'updateAddress'])->name('buyer.address.update');

    Route::delete('/buyer/address/{address}', [BuyerController::class, 'destroyAddress'])->name('buyer.address.destroy');
    Route::put('/buyer/address/{address}', [BuyerController::class, 'updateAddress'])->name('buyer.address.update');

    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // buyer account
    Route::get('/my-account', [BuyerController::class, 'showAccount'])->name('my-account');
    Route::resource('delivery-addresses', DeliveryAddressController::class);
    Route::post('/buyer/profile/update', [ProfileController::class, 'update'])->name('buyer.profile.update');
    
    Route::post('/buyer/reset-recommendations', [BuyerController::class, 'resetRecommendations'])->name('buyer.reset_recommendations')->middleware('auth');
    
    // Add this route for all categories
    Route::get('/categories', [BuyerController::class, 'allCategories'])->name('buyer.all_categories');
    Route::get('/invoice/{order}', [BuyerController::class, 'showInvoice'])->name('invoice.show');

    Route::get('/find-housemate', [RentController::class, 'findHousemate'])->name('rent.view');
    Route::post('/post-housemate', [RentController::class, 'store'])->name('rent.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    
    // REVIEWS
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});


require __DIR__ . '/auth.php';
