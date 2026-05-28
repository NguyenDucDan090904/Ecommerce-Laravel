<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CheckoutRequest;
use App\Services\CheckoutService;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected $checkoutService;

    // Inject Service vào Controller
    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    public function index()
    {
        $cart = session()->get('cart');

        if (!$cart || count($cart) == 0) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        return view('frontend.checkout.index', [
            'cart' => $cart,
            'user' => Auth::user()
        ]);
    }

    // Sử dụng CheckoutRequest để tự động Validate
    public function process(CheckoutRequest $request)
    {
        try {
            // Service xử lý toàn bộ logic
            $order = $this->checkoutService->processOrder($request->validated());

            return redirect()->route('checkout.success', $order->id);

        } catch (\Exception $e) {
            // Bắt lỗi (ví dụ giỏ hàng trống hoặc lỗi DB)
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())->withInput();
        }
    }

    public function success(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('frontend.checkout.success', compact('order'));
    }
}
