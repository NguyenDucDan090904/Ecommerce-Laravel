@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Giỏ hàng của bạn</h2>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-8">
                <p class="text-green-700 font-medium text-base">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('cart') && count(session('cart')) > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-600 uppercase text-sm font-bold">
                        <th class="py-4 px-6">Sản phẩm</th>
                        <th class="py-4 px-6 text-center">Đơn giá</th>
                        <th class="py-4 px-6 text-center w-40">Số lượng</th>
                        <th class="py-4 px-6 text-center">Thành tiền</th>
                        <th class="py-4 px-6 text-center">Xóa</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-base text-gray-700">
                    @php $total = 0; @endphp
                    @foreach(session('cart') as $id => $details)
                        @php $total += $details['price'] * $details['quantity']; @endphp
                        <tr>
                            <td class="py-4 px-6 flex items-center space-x-4">
                                @if($details['image'])
                                    <img src="{{ asset('storage/' . $details['image']) }}" class="w-16 h-16 object-cover rounded border border-gray-200">
                                @else
                                    <div class="w-16 h-16 bg-gray-100 rounded border border-gray-200 flex items-center justify-center text-xs text-gray-400">No Img</div>
                                @endif
                                <span class="font-bold text-gray-900">{{ $details['name'] }}</span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                {{ number_format($details['price'], 0, ',', '.') }} đ
                            </td>
                            <td class="py-4 px-6 text-center">
                                <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center justify-center space-x-2">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" class="w-16 px-2 py-1 border border-gray-300 rounded text-center focus:outline-none focus:border-blue-500">
                                    <button type="submit" class="p-1.5 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition" title="Cập nhật">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    </button>
                                </form>
                            </td>
                            <td class="py-4 px-6 text-center font-bold text-blue-600">
                                {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }} đ
                            </td>
                            <td class="py-4 px-6 text-center">
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition" title="Xóa">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="p-6 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center">
                    <a href="{{ url('/') }}" class="text-blue-600 hover:underline font-medium mb-4 sm:mb-0">
                        &larr; Tiếp tục mua sắm
                    </a>
                    <div class="flex items-center space-x-6">
                        <div class="text-lg text-gray-700">Tổng cộng: <span class="text-2xl font-bold text-blue-700 ml-2">{{ number_format($total, 0, ',', '.') }} đ</span></div>
                        <a href="{{ url('/checkout') }}" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold text-base shadow-sm transition">
                            Thanh toán ngay
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white p-12 text-center rounded-xl border border-gray-100 shadow-sm">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <p class="text-xl text-gray-500 font-medium mb-6">Giỏ hàng của bạn đang trống</p>
                <a href="{{ url('/') }}" class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">Về trang chủ mua sắm</a>
            </div>
        @endif
    </div>
@endsection
