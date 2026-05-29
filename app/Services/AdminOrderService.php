<?php

namespace App\Services;

use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AdminOrderService
{
    protected $orderRepo;

    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function changeStatus(int $orderId, string $newStatus)
    {
        return DB::transaction(function () use ($orderId, $newStatus) {
            $order = $this->orderRepo->findByIdWithDetails($orderId);
            $oldStatus = $order->status;

            // Nếu trạng thái không thay đổi thì bỏ qua
            if ($oldStatus === $newStatus) {
                return $order;
            }

            // LOGIC ĐẶC BIỆT: Nếu hủy đơn hàng, cộng lại tồn kho cho sản phẩm
            if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
                foreach ($order->items as $item) {
                    if ($item->product) {
                        $item->product->increment('stock', $item->quantity);
                    }
                }
            }

            // Nếu đơn hàng từ trạng thái Hủy được khôi phục lại (Ví dụ bấm nhầm thành Pending)
            if ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
                foreach ($order->items as $item) {
                    if ($item->product) {
                        // Trừ bớt kho đi, nếu không đủ kho có thể throw Exception tại đây
                        $item->product->decrement('stock', $item->quantity);
                    }
                }
            }

            // Cập nhật trạng thái mới vào DB
            return $this->orderRepo->updateStatus($orderId, $newStatus);
        });
    }
}
