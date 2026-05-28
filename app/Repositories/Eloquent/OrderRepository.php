<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{
    public function createOrderWithItems(array $orderData, array $cartItems)
    {
        return DB::transaction(function () use ($orderData, $cartItems) {
            // 1. Lưu Order
            $order = Order::create($orderData);

            // 2. Lưu Order Items
            foreach ($cartItems as $productId => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);
            }

            return $order;
        });
    }
}
