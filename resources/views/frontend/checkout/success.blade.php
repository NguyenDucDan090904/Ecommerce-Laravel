@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-16 text-center">
        <div class="mb-8 flex justify-center">
            <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center text-green-500">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
        </div>

        <h2 class="text-4xl font-black text-gray-900 mb-4">Đặt hàng thành công!</h2>
        <p class="text-lg text-gray-600 mb-8">Cảm ơn bạn đã mua sắm. Đơn hàng của bạn đang được xử lý.</p>

        <div class="bg-gray-50 border border-gray-200 rounded-xl p-8 mb-8 text-left">
            <div class="grid grid-cols-2 gap-4 text-base">
                <div><span class="text-gray-500">Mã đơn hàng:</span> <span class="font-bold text-gray-900">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span></div>
                <div><span class="text-gray-500">Ngày đặt:</span> <span class="font-bold text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</span></div>
                <div><span class="text-gray-500">Tổng thanh toán:</span> <span class="font-bold text-blue-600">{{ number_format($order->total_amount, 0, ',', '.') }} đ</span></div>
                <div><span class="text-gray-500">Phương thức:</span> <span class="font-bold text-gray-900 uppercase">{{ $order->payment_method }}</span></div>
            </div>
        </div>

        <a href="{{ url('/') }}" class="inline-block px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold text-base transition-colors">
            Tiếp tục mua sắm
        </a>
    </div>
@endsection
