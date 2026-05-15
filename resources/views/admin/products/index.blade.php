@extends('admin.layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Danh sách sản phẩm</h2>
        <a href="{{ route('admin.products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Thêm mới</a>
    </div>

    <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
        <table class="min-w-max w-full table-auto">
            <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm">
                <th class="py-3 px-6 text-left">Tên sản phẩm</th>
                <th class="py-3 px-6 text-left">Danh mục</th>
                <th class="py-3 px-6 text-center">Giá</th>
                <th class="py-3 px-6 text-center">Kho</th>
                <th class="py-3 px-6 text-center">Hành động</th>
            </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
            @foreach($products as $product)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left">{{ $product->name }}</td>
                    <td class="py-3 px-6 text-left">{{ $product->category->name }}</td>
                    <td class="py-3 px-6 text-center">{{ number_format($product->price) }}đ</td>
                    <td class="py-3 px-6 text-center">{{ $product->stock }}</td>
                    <td class="py-3 px-6 text-center">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-500">Sửa</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $products->links() }}
@endsection
