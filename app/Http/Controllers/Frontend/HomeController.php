<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }
    public function index()
    {
        $products = $this->productService->getActiveProducts();

        return view('welcome', compact('products'));
    }

    public function show($id)
    {
        try {
            // Lấy thông tin sản phẩm từ Repository qua Service
            // (Đảm bảo ProductRepository của bạn đã eager load 'images' và 'category' trong hàm findById)
            $product = $this->productService->getProductById($id);

            // Nếu sản phẩm đang ở trạng thái ẩn (is_active = 0), không cho khách xem
            if (!$product || !$product->is_active) {
                abort(404);
            }

            return view('frontend.products.show', compact('product'));
        } catch (\Exception $e) {
            abort(404);
        }
    }
}
