<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{
    public function createOrderWithItems(array $orderData, array $cartItems)
    {
        return DB::transaction(function () use ($orderData, $cartItems) {
            $order = Order::create($orderData);
            foreach ($cartItems as $productId => $details) {
                $order->items()->create([
                    'product_id' => $productId,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);
            }
            return $order;
        });
    }

    public function getAllPaginated(int $perPage = 10)
    {
        // Lấy kèm thông tin User đặt hàng
        return Order::with('user')->latest()->paginate($perPage);
    }

    public function findByIdWithDetails(int $id)
    {
        // Tải kèm thông tin chi tiết đơn hàng và sản phẩm bên trong để tránh lỗi N+1 query
        return Order::with(['user', 'items.product'])->findOrFail($id);
    }

    public function updateStatus(int $id, string $status)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $status]);
        return $order;
    }
}
