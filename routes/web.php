<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

use App\Http\Controllers\GuestItemController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AuthController;

// Root route - redirects to dashboard
Route::get('/', [DashboardController::class, 'index'])->name('home');

// Root dashboard route - redirects based on authentication/role
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('users', UserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);

    Route::resource('product', ProductController::class)->names([
        'index' => 'admin.product.index',
        'create' => 'admin.product.create',
        'store' => 'admin.product.store',
        'show' => 'admin.product.show',
        'edit' => 'admin.product.edit',
        'update' => 'admin.product.update',
        'destroy' => 'admin.product.destroy',
    ]);
    Route::get('/reports', [DashboardController::class, 'reports'])->name('admin.reports');
});

Route::middleware(['auth', 'role:staff'])->prefix('staff')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('staff.dashboard');
    Route::get('/items', [GuestItemController::class, 'index'])->name('staff.items.index');
    Route::get('/items/{item}', [GuestItemController::class, 'show'])->name('staff.items.show');
    Route::get('/products', [ProductController::class, 'index'])->name('staff.products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('staff.products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('staff.products.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('staff.products.show');
    Route::get('/users', [StaffController::class, 'users'])->name('staff.users');
    Route::get('/reports', [StaffController::class, 'reports'])->name('staff.reports');
});

Route::middleware(['auth', 'role:guest'])->prefix('guest')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('guest.dashboard');
    Route::get('/products', [GuestController::class, 'products'])->name('guest.products.index');
    Route::get('/users', [GuestController::class, 'users'])->name('guest.users');
    Route::get('/reports', [GuestController::class, 'reports'])->name('guest.reports');
});

Route::get('/login', [AuthController::class, 'login'])
    ->name('login');

Route::post('/login', [AuthController::class, 'loginProcess'])
    ->name('login.process');

Route::get('/register', [AuthController::class, 'register'])
    ->name('register');

Route::post('/register', [AuthController::class, 'registerProcess'])
    ->name('register.process');

Route::get('/register/staff', [AuthController::class, 'registerStaff'])
    ->name('register.staff');

Route::post('/register/staff', [AuthController::class, 'registerStaffProcess'])
    ->name('register.staff.process');


Route::get('/logout/confirm', [AuthController::class, 'logoutConfirm'])
    ->name('logout.confirm');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');
