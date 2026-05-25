@extends('admin.layouts.app')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
        <p class="text-gray-600">Chào mừng bạn quay trở lại hệ thống quản trị.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="box"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="mb-2 text-sm font-medium text-gray-600">Tổng sản phẩm</p>
                    <p class="text-2xl font-semibold text-gray-700">{{ \App\Models\Product::count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="folder"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="mb-2 text-sm font-medium text-gray-600">Danh mục</p>
                    <p class="text-2xl font-semibold text-gray-700">{{ \App\Models\Category::count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="shopping-cart"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="mb-2 text-sm font-medium text-gray-600">Đơn hàng mới</p>
                    <p class="text-2xl font-semibold text-gray-700">{{ \App\Models\Order::where('status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 bg-white p-6 rounded-lg shadow-sm">
        <h3 class="text-lg font-bold mb-4">Thao tác nhanh</h3>
        <div class="flex space-x-4">
            <a href="{{ route('admin.products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                + Thêm sản phẩm
            </a>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded transition">
                Quản lý kho hàng
            </a>
        </div>
    </div>
@endsection
