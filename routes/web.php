<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Dành cho khách vãng lai)
|--------------------------------------------------------------------------
*/
// Trang chủ công cộng
Route::get('/', [HomeController::class, 'index'])->name('home');

// Xem chi tiết sản phẩm ngoài Frontend (Đã đổi tên name thành 'frontend.products.show' để không đụng hàng)
Route::get('/products/{id}', [HomeController::class, 'show'])->name('frontend.products.show');


/*
|--------------------------------------------------------------------------
| Giỏ hàng (Cart Routes)
|--------------------------------------------------------------------------
*/
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::post('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::post('/remove/{id}', [CartController::class, 'remove'])->name('remove');
});


/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Khách hàng đã đăng nhập)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Giao diện Dashboard của người dùng (Đã sửa: Trả về view dashboard tiêu chuẩn của Laravel Breeze)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Quản lý Profile cá nhân của khách
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Đặt hàng & Thanh toán (Checkout)
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/', [CheckoutController::class, 'process'])->name('process');
        Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
    });
});


/*
|--------------------------------------------------------------------------
| Admin Routes (Yêu cầu đăng nhập & quyền Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Trang chủ quản trị
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // BẮT BUỘC: Nút gạt AJAX trạng thái phải nằm TRÊN Route Resource sản phẩm
        Route::patch('products/{id}/toggle-status', [ProductController::class, 'toggleStatus'])
            ->name('products.toggle-status');

        // Toàn bộ các route CRUD sản phẩm (Tự động sinh ra các tên: admin.products.index, admin.products.edit, ...)
        Route::resource('products', ProductController::class);

        // Các tính năng mở rộng của Sản phẩm
        Route::delete('/products/images/{image}', [ProductController::class, 'deleteImage'])->name('products.delete-image');
        Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');

        // Quản lý Danh mục (Categories)
        Route::resource('categories', CategoryController::class);

        // Quản lý Đơn hàng (Orders)
        Route::resource('orders', OrderController::class)->only(['index', 'show', 'update']);
        Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    });

require __DIR__.'/auth.php';
