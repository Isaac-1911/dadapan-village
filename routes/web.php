<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use App\Http\Controllers\Seller\ProfileController as SellerProfileController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\SellerController;
use App\Http\Controllers\Admin\UserController;
use ProductCont

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    return match ($user->role->name) {
        'admin' => redirect()->route('admin.dashboard'),
        'seller' => redirect()->route('seller.dashboard'),
        default => abort(403),
    };
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', fn () => redirect('dashboard'));
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('news', NewsController::class)->except(['show', 'edit']);
        Route::resource('news-categories', NewsCategoryController::class)->except(['show', 'edit']);
        Route::resource('galleries', GalleryController::class)->except(['show', 'edit']);

        Route::resource('products', ProductController::class)->except(['show', 'edit']);
        Route::delete('products/{product}/images/{image}', [ProductController::class, 'destroyImage'])->name('products.images.destroy');
        Route::resource('product-categories', ProductCategoryController::class)->except(['show', 'create', 'edit']);

        Route::resource('sellers', SellerController::class)->except(['show', 'edit']);
        Route::patch('sellers/{seller}/toggle-status', [SellerController::class, 'toggleStatus'])->name('sellers.toggle-status');

        Route::resource('users', UserController::class)->except(['show','edit']);
        Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    });


Route::middleware(['auth', 'role:seller'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {
        Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile/create', [SellerProfileController::class, 'create'])->name('profile.create');
        Route::post('/profile', [SellerProfileController::class, 'store'])->name('profile.store');
        Route::get('/profile/edit', [SellerProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [SellerProfileController::class, 'update'])->name('profile.update');
    });

require __DIR__ . '/auth.php';
