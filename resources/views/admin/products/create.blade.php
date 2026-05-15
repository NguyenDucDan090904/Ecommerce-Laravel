@extends('admin.layouts.app')

@section('content')
    <h2 class="text-2xl font-bold mb-6">Thêm sản phẩm điện tử mới</h2>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label>Tên sản phẩm</label>
                <input type="text" name="name" class="w-full border p-2 rounded">
            </div>
            <div>
                <label>Danh mục</label>
                <select name="category_id" class="w-full border p-2 rounded">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-4">
            <label>Thông số kỹ thuật (JSON Attributes)</label>
            <div class="grid grid-cols-2 gap-2">
                <input type="text" name="attributes[cpu]" placeholder="CPU (vd: Apple M3)" class="border p-2 rounded">
                <input type="text" name="attributes[ram]" placeholder="RAM (vd: 16GB)" class="border p-2 rounded">
                <input type="text" name="attributes[screen]" placeholder="Màn hình" class="border p-2 rounded">
                <input type="text" name="attributes[battery]" placeholder="Pin" class="border p-2 rounded">
            </div>
        </div>

        <div class="mt-4">
            <label>Hình ảnh sản phẩm (Chọn nhiều ảnh)</label>
            <input type="file" name="images[]" multiple class="w-full border p-2">
        </div>

        <button type="submit" class="mt-6 bg-green-600 text-white px-6 py-2 rounded">Lưu sản phẩm</button>
    </form>
@endsection
