<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Hiển thị trang chủ mua sắm cho Khách và User thường
     */
    public function index()
    {
        // Lấy toàn bộ sản phẩm kèm theo quan hệ ảnh (nếu có) để tối ưu câu lệnh SQL (Eager Loading)
        $products = Product::with('images')->latest()->get();

        return view('welcome', compact('products'));
    }
}
