@extends('admin.layouts.app')

@section('content')
    <div class="mb-8 flex justify-between items-end">
        <div>
            <div class="flex items-center space-x-2 text-base text-gray-400 mb-2">
                <a href="{{ route('admin.orders.index') }}" class="hover:text-blue-600 transition-colors">Đơn hàng</a>
                <span>/</span>
                <span class="text-gray-600">Chi tiết</span>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Đơn hàng #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h2>
            <p class="text-base text-gray-500 mt-1.5">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 text-base">
        <!-- CỘT TRÁI: Chi tiết sản phẩm mua -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 uppercase tracking-wider border-b border-gray-100 pb-3 mb-4">Danh sách sản phẩm</h3>

                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center justify-between p-4 border border-gray-100 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex items-center space-x-4">
                                <!-- Ảnh SP -->
                                @if($item->product && $item->product->images->isNotEmpty())
                                    <div class="w-16 h-16 rounded-md overflow-hidden border border-gray-200">
                                        <img src="{{ asset('storage/' . $item->product->images->first()->path) }}" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-16 h-16 rounded-md border border-gray-200 bg-gray-100 flex items-center justify-center text-xs text-gray-400">No Img</div>
                                @endif

                                <div>
                                    <h4 class="font-bold text-gray-800 text-lg">{{ $item->product->name ?? 'Sản phẩm đã bị xóa' }}</h4>
                                    <p class="text-gray-500 text-sm">Đơn giá: {{ number_format($item->price, 0, ',', '.') }} đ</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-gray-600">x {{ $item->quantity }}</p>
                                <p class="font-bold text-blue-600 text-lg mt-1">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} đ</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Tổng kết tiền -->
                <div class="mt-6 pt-4 border-t border-gray-200 flex justify-between items-center">
                    <span class="text-lg font-bold text-gray-700 uppercase">Tổng thanh toán:</span>
                    <span class="text-2xl font-bold text-blue-700">{{ number_format($order->total_amount, 0, ',', '.') }} đ</span>
                </div>
            </div>
        </div>

        <!-- CỘT PHẢI: Thông tin khách hàng & Cập nhật trạng thái -->
        <div class="space-y-6">
            <!-- Khối Cập nhật trạng thái -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 uppercase tracking-wider border-b border-gray-100 pb-3 mb-4">Tiến trình đơn hàng</h3>

                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Thay đổi trạng thái:</label>
                        <select name="status" class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 p-3 rounded-lg text-base font-semibold bg-gray-50 outline-none cursor-pointer">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Đang giao hàng</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Hủy đơn</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-base font-bold shadow-sm transition-all shadow-blue-100">
                        Cập nhật tiến trình
                    </button>
                </form>
            </div>

            <!-- Khối Thông tin Giao hàng -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 uppercase tracking-wider border-b border-gray-100 pb-3 mb-4">Thông tin nhận hàng</h3>

                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500 font-semibold mb-1">Người nhận:</p>
                        <p class="font-bold text-gray-800 text-lg">{{ $order->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold mb-1">Điện thoại liên hệ:</p>
                        <p class="font-bold text-gray-800 text-lg">{{ $order->customer_phone }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold mb-1">Phương thức thanh toán:</p>
                        <p class="font-bold text-gray-800 text-base uppercase">{{ $order->payment_method }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold mb-1">Địa chỉ giao hàng chi tiết:</p>
                        <p class="text-base text-gray-700 bg-gray-50 p-3 rounded-lg border border-gray-100 leading-relaxed">{{ $order->shipping_address }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
