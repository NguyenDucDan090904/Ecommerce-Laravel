@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 tracking-tight">Thanh toán đơn hàng</h2>

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8 text-base text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            @csrf

            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 border-b border-gray-100 pb-4">Thông tin người nhận</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Họ và tên <span class="text-red-500">*</span></label>
                            <input type="text" name="customer_name" value="{{ old('customer_name', $user->name) }}" class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 p-3 rounded-lg text-base outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Số điện thoại <span class="text-red-500">*</span></label>
                            <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" placeholder="VD: 0912345678" class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 p-3 rounded-lg text-base outline-none" required>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Địa chỉ giao hàng chi tiết <span class="text-red-500">*</span></label>
                        <textarea name="shipping_address" rows="3" placeholder="Số nhà, Tên đường, Phường/Xã, Quận/Huyện, Tỉnh/Thành phố..." class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 p-3 rounded-lg text-base outline-none" required>{{ old('shipping_address') }}</textarea>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 border-b border-gray-100 pb-4">Phương thức thanh toán</h3>
                    <div class="space-y-4">
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" name="payment_method" value="COD" class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500" checked>
                            <span class="ml-3 text-base font-semibold text-gray-800">Thanh toán khi nhận hàng (COD)</span>
                        </label>
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" name="payment_method" value="BANK_TRANSFER" class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="ml-3 text-base font-semibold text-gray-800">Chuyển khoản ngân hàng</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 sticky top-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 uppercase tracking-wider">Đơn hàng của bạn</h3>

                    <div class="space-y-4 mb-6 max-h-80 overflow-y-auto pr-2">
                        @php $total = 0; @endphp
                        @foreach($cart as $details)
                            @php $total += $details['price'] * $details['quantity']; @endphp
                            <div class="flex justify-between items-start text-base">
                                <div class="flex-1 pr-4">
                                    <p class="font-semibold text-gray-800">{{ $details['name'] }}</p>
                                    <p class="text-sm text-gray-500">SL: {{ $details['quantity'] }}</p>
                                </div>
                                <div class="font-bold text-gray-700">
                                    {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }} đ
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-300 pt-4 mb-6">
                        <div class="flex justify-between items-center text-lg">
                            <span class="font-bold text-gray-700">Tổng cộng:</span>
                            <span class="font-black text-2xl text-blue-700">{{ number_format($total, 0, ',', '.') }} đ</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-lg font-bold shadow-sm transition-all">
                        Xác nhận đặt hàng
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
