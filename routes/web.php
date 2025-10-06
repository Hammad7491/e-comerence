<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductViewController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;

use App\Http\Controllers\Auth\SocialController;

/*
|--------------------------------------------------------------------------
| Public (guest) routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth (manual)
Route::get('/login',     [AuthController::class, 'loginform'])->name('loginform');
Route::post('/login',    [AuthController::class, 'login'])->name('login');
Route::get('/register',  [AuthController::class, 'registerform'])->name('registerform');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::view('/error', 'auth.errors.error403')->name('auth.error403');

// Social auth (optional)
Route::get('login/google',            [SocialController::class, 'redirectToGoogle'])->name('google.login');
Route::get('login/google/callback',   [SocialController::class, 'handleGoogleCallback']);
Route::get('login/facebook',          [SocialController::class, 'redirectToFacebook'])->name('facebook.login');
Route::get('login/facebook/callback', [SocialController::class, 'handleFacebookCallback']);

// Product detail (frontend)
Route::get('/product/{product}', [ProductViewController::class, 'show'])->name('product.show');

/*
|--------------------------------------------------------------------------
| Authenticated (any logged-in user)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Simple user dashboard placeholder
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Cart
|--------------------------------------------------------------------------
*/
Route::get('/cart',  [CartController::class, 'index'])->name('cart.index');

// add-to-cart requires login
Route::post('/cart', [CartController::class, 'store'])
    ->middleware('auth')
    ->name('cart.store');

// remove from cart (named exactly as used in the view)
Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');

/*
|--------------------------------------------------------------------------
| Checkout (must be authenticated)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Show checkout form
    Route::get('/checkout',  [CheckoutController::class, 'create'])->name('checkout.create');
    // Submit order
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});

/*
|--------------------------------------------------------------------------
| Admin area
| Use ONE admin group. Choose either `role:admin` (if you store role on users)
| or `can:admin` if you defined a Gate. Here we use `role:admin`.
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Users management
        Route::resource('users', UserController::class)->except(['show']);

        // Products CRUD
        Route::resource('products', ProductController::class);

        // Orders moderation
        Route::get('/orders/check',  [OrderController::class, 'check'])->name('orders.check');   // pending/rejected list
        Route::get('/orders',        [OrderController::class, 'index'])->name('orders.index');   // approved list
        Route::patch('/orders/{order}/approve', [OrderController::class, 'approve'])->name('orders.approve');
        Route::patch('/orders/{order}/reject',  [OrderController::class, 'reject'])->name('orders.reject');
    });

   // routes/web.php

Route::prefix('admin')->middleware(['auth','role:admin'])->name('admin.')->group(function () {
    // …your other admin routes…

    // download the payment proof (forces download)
    Route::get('/orders/{order}/download-proof', [\App\Http\Controllers\Admin\OrderController::class, 'downloadProof'])
        ->name('orders.download-proof');

    // delete an order
    Route::delete('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'destroy'])
        ->name('orders.destroy');
});



Route::middleware('auth')->group(function () {
    // Profile (name/email etc.)
    Route::get('/profile/edit',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Password change (separate screen)
    Route::get('/change-password',  [ProfileController::class, 'showChangePasswordForm'])
        ->name('password.change');

    Route::post('/change-password', [ProfileController::class, 'updatePassword'])
        ->name('password.update');
});



// Logged-in user: My Orders
Route::middleware('auth')->get('/my-orders', [\App\Http\Controllers\OrderHistoryController::class, 'index'])
     ->name('orders.mine');

     // Brand page route
Route::get('/brand', function () {
    return view('frontend.brand');
})->name('brand');



Route::get('/contact-us', function () {
    return view('frontend.contactus');
})->name('contact');



Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');});