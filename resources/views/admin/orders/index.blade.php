@extends('admin.layouts.app')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Quản lý Đơn hàng</h2>
        <p class="text-base text-gray-500 mt-1.5">Theo dõi và điều phối trạng thái giao dịch của khách hàng.</p>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-gray-600 uppercase text-sm font-bold tracking-wider">
                    <th class="py-4.5 px-6 text-base">Mã ĐH</th>
                    <th class="py-4.5 px-6 text-base">Khách hàng</th>
                    <th class="py-4.5 px-6 text-base">Ngày đặt</th>
                    <th class="py-4.5 px-6 text-base">Tổng tiền</th>
                    <th class="py-4.5 px-6 text-center text-base">Trạng thái</th>
                    <th class="py-4.5 px-6 text-center text-base">Hành động</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700 text-base">
                @forelse($orders as $order)
                    <tr class="hover:bg-gray-50/60 transition-colors group">
                        <td class="py-4.5 px-6 font-bold text-gray-900 text-lg">
                            #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="py-4.5 px-6">
                            <div class="font-bold text-gray-800">{{ $order->customer_name }}</div>
                            <div class="text-sm text-gray-500">{{ $order->customer_phone }}</div>
                        </td>
                        <td class="py-4.5 px-6 text-gray-600">
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="py-4.5 px-6 font-bold text-blue-600 text-lg">
                            {{ number_format($order->total_amount, 0, ',', '.') }} đ
                        </td>
                        <td class="py-4.5 px-6 text-center">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    'processing' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'shipped' => 'bg-purple-100 text-purple-800 border-purple-200',
                                    'completed' => 'bg-green-100 text-green-800 border-green-200',
                                    'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                ];
                                $statusLabels = [
                                    'pending' => 'Chờ xác nhận',
                                    'processing' => 'Đang xử lý',
                                    'shipped' => 'Đang giao hàng',
                                    'completed' => 'Hoàn thành',
                                    'cancelled' => 'Đã hủy',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold border {{ $statusColors[$order->status] }}">
                                {{ $statusLabels[$order->status] }}
                            </span>
                        </td>
                        <td class="py-4.5 px-6 text-center">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-50 hover:bg-blue-50 text-gray-700 hover:text-blue-600 rounded-lg transition-colors border border-gray-200 font-semibold text-sm">
                                Xem chi tiết
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-16 text-center text-gray-400 bg-gray-50/30">
                            <span class="text-lg font-semibold block text-gray-500">Chưa có đơn hàng nào</span>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="bg-gray-50 border-t border-gray-100 px-6 py-4 text-base">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection
