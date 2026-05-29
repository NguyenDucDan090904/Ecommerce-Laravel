@extends('admin.layouts.app')

@section('content')
    <div class="p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-800">Tổng quan kinh doanh</h1>

            <form method="GET" action="{{ route('admin.dashboard') }}" id="filterForm">
                <select name="filter" onchange="document.getElementById('filterForm').submit()"
                        class="bg-white border border-gray-200 rounded-lg px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="today" {{ $current_filter == 'today' ? 'selected' : '' }}>Hôm nay</option>
                    <option value="yesterday" {{ $current_filter == 'yesterday' ? 'selected' : '' }}>Hôm qua</option>
                    <option value="7_days" {{ $current_filter == '7_days' ? 'selected' : '' }}>7 ngày qua</option>
                    <option value="30_days" {{ $current_filter == '30_days' ? 'selected' : '' }}>30 ngày qua</option>
                    <option value="this_month" {{ $current_filter == 'this_month' ? 'selected' : '' }}>Tháng này</option>
                    <option value="all" {{ $current_filter == 'all' ? 'selected' : '' }}>Tất cả thời gian</option>
                </select>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="text-sm font-medium text-gray-500 uppercase">Tổng doanh thu</div>
                <div class="text-3xl font-black text-blue-600 mt-2">{{ number_format($total_revenue, 0, ',', '.') }} đ</div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="text-sm font-medium text-gray-500 uppercase">Tổng đơn hàng</div>
                <div class="text-3xl font-black text-gray-800 mt-2">{{ $total_orders }}</div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="text-sm font-medium text-gray-500 uppercase">Khách hàng</div>
                <div class="text-3xl font-black text-gray-800 mt-2">{{ $total_users }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Doanh thu 6 tháng gần nhất</h2>
                <canvas id="revenueChart" height="200"></canvas>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Sản phẩm bán chạy</h2>
                <div class="space-y-4">
                    @foreach($top_products as $item)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-lg overflow-hidden">
                                    @if($item->product->images->first())
                                        <img src="{{ asset('storage/' . $item->product->images->first()->path) }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ $item->product->name }}</span>
                            </div>
                            <span class="text-sm font-bold text-blue-600">{{ $item->total_qty }} lượt bán</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chart_labels) !!},
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: {!! json_encode($chart_data) !!},
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
@endsection
