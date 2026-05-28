<!DOCTYPE html>
<html>
<head>
    <title>Cập nhật trạng thái đơn hàng</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
<div style="max-w: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 8px;">
    <h2 style="color: #2563eb;">Xin chào {{ $order->customer_name }},</h2>

    <p>Đơn hàng <strong>#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong> của bạn vừa được cập nhật trạng thái mới:</p>

    @php
        $statusLabels = [
            'pending' => 'Chờ xác nhận',
            'processing' => 'Đang xử lý',
            'shipped' => 'Đang giao hàng',
            'completed' => 'Đã giao thành công',
            'cancelled' => 'Đã hủy',
        ];
    @endphp

    <div style="background-color: #f8f9fa; padding: 15px; border-left: 4px solid #2563eb; margin: 20px 0;">
        <strong style="font-size: 18px; color: #1e40af;">{{ $statusLabels[$order->status] }}</strong>
    </div>

    <p><strong>Tổng thanh toán:</strong> {{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</p>
    <p><strong>Địa chỉ nhận hàng:</strong> {{ $order->shipping_address }}</p>

    <p style="margin-top: 30px;">Cảm ơn bạn đã mua sắm tại hệ thống của chúng tôi!</p>
</div>
</body>
</html>
