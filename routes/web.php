<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

// Admin area controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\SocialController;

// Social auth (keep if you use them)
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Public (guest) routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

// (Frontend product page; stub controller if you don’t have one yet)
Route::get('/products/{product}', [ProductController::class, 'show'])
     ->name('products.show');

Route::get('/login',     [AuthController::class, 'loginform'])->name('loginform');
Route::post('/login',    [AuthController::class, 'login'])->name('login');

Route::get('/register',  [AuthController::class, 'registerform'])->name('registerform');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::view('/error', 'auth.errors.error403')->name('auth.error403');

/*
|--------------------------------------------------------------------------
| Social Auth (optional)
|--------------------------------------------------------------------------
*/
Route::get('login/google',            [SocialController::class, 'redirectToGoogle'])->name('google.login');
Route::get('login/google/callback',  [SocialController::class, 'handleGoogleCallback']);
Route::get('login/facebook',         [SocialController::class, 'redirectToFacebook'])->name('facebook.login');
Route::get('login/facebook/callback',[SocialController::class, 'handleFacebookCallback']);

/*
|--------------------------------------------------------------------------
| Authenticated (any logged-in user)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // User dashboard (non-admin)
    // Create a simple view/controller for this if you don't have one
    Route::get('/dashboard', function () {
        return view('user.dashboard'); // resources/views/user/dashboard.blade.php
    })->name('user.dashboard');

    // Profile (edit own name/email/password)
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',  [ProfileController::class, 'update'])->name('profile.update');
});


Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        // Admin dashboard (single index)
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Users management (CRUD)
        Route::resource('users', UserController::class)->except(['show']);

        // Products (CRUD)
        Route::resource('products', ProductController::class);
    });

