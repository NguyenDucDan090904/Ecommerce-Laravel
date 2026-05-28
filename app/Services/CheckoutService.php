<?php

namespace App\Services;

use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Exception;

class CheckoutService
{
    protected $orderRepository;

    // Inject Repository vào Service
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function processOrder(array $validatedData)
    {
        $cart = session()->get('cart');

        if (!$cart || count($cart) === 0) {
            throw new Exception('Giỏ hàng trống.');
        }

        // Tính tổng tiền
        $totalAmount = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        // Chuẩn bị data cho bảng Order
        $orderData = [
            'user_id' => Auth::id(),
            'customer_name' => $validatedData['customer_name'],
            'customer_phone' => $validatedData['customer_phone'],
            'shipping_address' => $validatedData['shipping_address'],
            'total_amount' => $totalAmount,
            'payment_method' => $validatedData['payment_method'],
            'status' => 'pending',
        ];

        // Gọi Repository để lưu vào DB (đã bọc Transaction bên trong Repository)
        $order = $this->orderRepository->createOrderWithItems($orderData, $cart);

        // Xóa giỏ hàng sau khi thành công
        session()->forget('cart');

        return $order;
    }
}
