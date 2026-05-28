<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart();
        return view('frontend.cart.index', compact('cart'));
    }

    public function add(Request $request, $product_id)
    {
        // Có thể tạo FormRequest riêng nếu có tham số số lượng (quantity)
        $quantity = $request->input('quantity', 1);
        $this->cartService->addToCart($product_id, $quantity);

        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $this->cartService->updateCart($id, $request->quantity);

        return redirect()->route('cart.index')->with('success', 'Đã cập nhật giỏ hàng.');
    }

    public function remove($id)
    {
        $this->cartService->removeFromCart($id);

        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }
}
