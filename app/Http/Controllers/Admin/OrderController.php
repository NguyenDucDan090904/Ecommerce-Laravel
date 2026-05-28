<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusUpdated;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->orderBy('id', 'desc')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Load sẵn quan hệ để tránh N+1 query
        $order->load('items.product', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled'
        ]);

        // Lưu trạng thái cũ để so sánh xem có thực sự thay đổi không
        $oldStatus = $order->status;

        $order->update(['status' => $request->status]);

        // Chỉ gửi email nếu admin thực sự chuyển sang trạng thái khác
        if ($oldStatus !== $request->status) {
            // Tạm thời gửi vào một email cố định để bạn test,
            // sau này sẽ đổi thành: $order->user->email hoặc trường email riêng của đơn hàng
            Mail::to('test-customer@example.com')->send(new OrderStatusUpdated($order));
        }

        return redirect()->back()->with('success', 'Đã cập nhật trạng thái đơn hàng thành công!');
    }
}
