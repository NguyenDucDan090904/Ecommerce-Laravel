<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

// Xem danh sách và chi tiết sản phẩm (Khách vãng lai cũng có thể xem)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');


/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Customer)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard của khách hàng
    Route::get('/dashboard', [ProductController::class, 'index'])->name('dashboard');

    // Quản lý hồ sơ cá nhân
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Trang chủ quản trị
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Quản lý sản phẩm & danh mục (Resourceful)
        // Lưu ý: Route name sẽ là admin.products.index, admin.categories.store...
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::delete('/product-images/{image}', [ProductController::class, 'deleteImage'])->name('products.delete-image');

        // Bạn có thể thêm quản lý đơn hàng sau này tại đây
        // Route::resource('orders', OrderController::class)->only(['index', 'show', 'update']);
    });

require __DIR__.'/auth.php';
