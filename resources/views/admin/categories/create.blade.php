@extends('admin.layouts.app')

@section('content')
    <div class="mb-8">
        <div class="flex items-center space-x-2 text-base text-gray-400 mb-2">
            <a href="{{ route('admin.categories.index') }}" class="hover:text-blue-600 transition-colors">Danh mục</a>
            <span>/</span>
            <span class="text-gray-600">Thêm mới</span>
        </div>
        <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Thêm danh mục mới</h2>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="max-w-3xl bg-white p-8 rounded-xl shadow-sm border border-gray-100 text-base space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-bold text-gray-700 uppercase mb-2 tracking-wider">Tên danh mục <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="VD: Điện thoại di động, Laptop..." class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 p-3 rounded-lg text-base transition-all outline-none" required>
            @error('name')
            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 uppercase mb-2 tracking-wider">Mô tả chi tiết</label>
            <textarea name="description" placeholder="Mô tả ngắn gọn về phân loại này..." class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 p-3 rounded-lg text-base transition-all outline-none" rows="4">{{ old('description') }}</textarea>
        </div>

        <div class="flex items-center justify-end space-x-4 border-t border-gray-100 pt-6 mt-6">
            <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 border border-gray-200 text-gray-700 rounded-lg text-base font-semibold hover:bg-gray-50 transition-all">Hủy bỏ</a>
            <button type="submit" class="px-7 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-base font-bold shadow-sm transition-all shadow-blue-100">Lưu danh mục</button>
        </div>
    </form>
@endsection
