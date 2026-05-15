@extends('admin.layouts.app')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-blue-500 text-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold">Sản phẩm</h3>
            <p class="text-3xl">{{ \App\Models\Product::count() }}</p>
        </div>
        <div class="bg-green-500 text-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold">Đơn hàng mới</h3>
            <p class="text-3xl">{{ \App\Models\Order::where('status', 'pending')->count() }}</p>
        </div>
        <div class="bg-purple-500 text-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold">Danh mục</h3>
            <p class="text-3xl">{{ \App\Models\Category::count() }}</p>
        </div>
    </div>

    <div class="mt-8 bg-white p-6 rounded-lg shadow">
        <h3 class="text-xl font-bold mb-4">Lối tắt quản lý</h3>
        <div class="flex gap-4">
            <a href="{{ route('admin.products.index') }}" class="bg-gray-800 text-white px-4 py-2 rounded">Danh sách sản phẩm</a>
            <a href="{{ route('admin.products.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">Thêm sản phẩm mới</a>
        </div>
    </div>
@endsection
