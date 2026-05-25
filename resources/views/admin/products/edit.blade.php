@extends('admin.layouts.app')

@section('content')
    <div class="mb-8">
        <div class="flex items-center space-x-2 text-base text-gray-400 mb-2">
            <a href="{{ route('admin.products.index') }}" class="hover:text-blue-600 transition-colors">Sản phẩm</a>
            <span>/</span>
            <span class="text-gray-600">Chỉnh sửa</span>
        </div>
        <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Chỉnh sửa sản phẩm</h2>
        <p class="text-base text-gray-500 mt-1.5">Cập nhật thông tin, thay đổi thông số phần cứng hoặc làm mới bộ sưu tập hình ảnh.</p>
    </div>

    <form id="main-update-form" action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-5xl text-base">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-5">
                    <h3 class="text-base font-bold text-gray-800 uppercase tracking-wider border-b border-gray-100 pb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Thông tin cơ bản
                    </h3>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 uppercase mb-1.5 tracking-wider">Tên sản phẩm <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 p-3 rounded-lg text-base transition-all outline-none" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 uppercase mb-1.5 tracking-wider">Mô tả sản phẩm</label>
                        <textarea name="description" class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 p-3 rounded-lg text-base transition-all outline-none" rows="5">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-5">
                    <h3 class="text-base font-bold text-gray-800 uppercase tracking-wider border-b border-gray-100 pb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Cấu hình & Thông số kỹ thuật
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-gray-600 uppercase mb-1.5">Bộ vi xử lý (CPU)</label>
                            <input type="text" name="attributes[cpu]" value="{{ old('attributes.cpu', $product->attributes['cpu'] ?? '') }}" class="w-full border border-gray-300 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 p-3 rounded-lg text-base transition-all outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-600 uppercase mb-1.5">Bộ nhớ trong (RAM)</label>
                            <input type="text" name="attributes[ram]" value="{{ old('attributes.ram', $product->attributes['ram'] ?? '') }}" class="w-full border border-gray-300 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 p-3 rounded-lg text-base transition-all outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-600 uppercase mb-1.5">Màn hình</label>
                            <input type="text" name="attributes[screen]" value="{{ old('attributes.screen', $product->attributes['screen'] ?? '') }}" class="w-full border border-gray-300 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 p-3 rounded-lg text-base transition-all outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-600 uppercase mb-1.5">Dung lượng Pin</label>
                            <input type="text" name="attributes[battery]" value="{{ old('attributes.battery', $product->attributes['battery'] ?? '') }}" class="w-full border border-gray-300 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 p-3 rounded-lg text-base transition-all outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-5">
                    <h3 class="text-base font-bold text-gray-800 uppercase tracking-wider border-b border-gray-100 pb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Phân loại & Giá bán
                    </h3>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 uppercase mb-1.5 tracking-wider">Danh mục <span class="text-red-500">*</span></label>
                        <select name="category_id" class="w-full border border-gray-300 focus:border-green-500 focus:ring-1 focus:ring-green-500 p-3 rounded-lg text-base transition-all outline-none bg-white cursor-pointer" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 uppercase mb-1.5 tracking-wider">Giá bán (VNĐ) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" class="w-full border border-gray-300 focus:border-green-500 focus:ring-1 focus:ring-green-500 p-3 pr-12 rounded-lg text-lg transition-all outline-none font-bold text-gray-900" required>
                            <span class="absolute right-4 top-3 text-gray-500 text-base font-semibold">đ</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 uppercase mb-1.5 tracking-wider">Số lượng kho <span class="text-red-500">*</span></label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full border border-gray-300 focus:border-green-500 focus:ring-1 focus:ring-green-500 p-3 rounded-lg text-base transition-all outline-none font-bold text-gray-900" required>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-5">
                    <h3 class="text-base font-bold text-gray-800 uppercase tracking-wider border-b border-gray-100 pb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Quản lý hình ảnh
                    </h3>

                    @if($product->images->isNotEmpty())
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            @foreach($product->images as $key => $image)
                                <div class="relative bg-gray-50 p-2.5 rounded-xl border border-gray-200 flex flex-col items-center group">
                                    @if($key === 0)
                                        <span class="absolute top-2 left-2 bg-green-500 text-white text-[10px] px-2 py-0.5 rounded font-bold shadow-sm z-10">Ảnh đại diện</span>
                                    @endif

                                    <div class="w-full h-24 rounded-lg overflow-hidden border border-gray-200 bg-white mb-2.5">
                                        <img src="{{ asset('storage/' . $image->path) }}" class="w-full h-full object-cover">
                                    </div>

                                    <button type="submit" form="delete-image-form-{{ $image->id }}" class="w-full text-xs bg-red-50 hover:bg-red-500 text-red-600 hover:text-white py-1.5 rounded-md transition-colors font-semibold">
                                        Xóa ảnh
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-400 italic text-center py-3">Chưa có hình ảnh nào cho sản phẩm này.</p>
                    @endif

                    <div class="space-y-3 border-t border-gray-100 pt-4">
                        <label class="block text-sm font-bold text-gray-600 uppercase tracking-wider">Tải lên thêm ảnh mới</label>
                        <div class="border-2 border-dashed border-gray-300 hover:border-blue-500 rounded-xl p-5 text-center cursor-pointer bg-gray-50/50 transition-colors relative group">
                            <input type="file" name="images[]" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <svg class="w-8 h-8 text-gray-400 mx-auto mb-1 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="text-sm font-bold text-gray-700 block">Chọn thêm ảnh</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-4 border-t border-gray-200 pt-6">
            <a href="{{ route('admin.products.index') }}" class="px-6 py-3 border border-gray-200 text-gray-700 rounded-lg text-base font-semibold hover:bg-gray-50 transition-all">
                Hủy bỏ
            </a>
            <button type="submit" form="main-update-form" class="px-7 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-base font-bold shadow-sm transition-all shadow-blue-100">
                Lưu thay đổi
            </button>
        </div>
    </form>

    @foreach($product->images as $image)
        <form id="delete-image-form-{{ $image->id }}" action="{{ route('admin.products.delete-image', $image->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa hình ảnh này không?')">
            @csrf
            @method('DELETE')
        </form>
    @endforeach

@endsection
