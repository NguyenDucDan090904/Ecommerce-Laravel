@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Danh mục sản phẩm</h2>
            <p class="text-base text-gray-500 mt-1.5">Quản lý các nhóm phân loại thiết bị điện tử.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg font-semibold text-base transition-all shadow-sm shadow-blue-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Thêm danh mục mới
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-gray-600 uppercase text-sm font-bold tracking-wider">
                    <th class="py-4.5 px-6 text-base">Tên danh mục</th>
                    <th class="py-4.5 px-6 text-base">Đường dẫn (Slug)</th>
                    <th class="py-4.5 px-6 text-center text-base">Số lượng SP</th>
                    <th class="py-4.5 px-6 text-center w-40 text-base">Hành động</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700 text-base">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50/60 transition-colors group">
                        <td class="py-4.5 px-6 font-bold text-gray-900 text-lg group-hover:text-blue-600 transition-colors">
                            {{ $category->name }}
                        </td>
                        <td class="py-4.5 px-6 text-gray-500">
                            {{ $category->slug }}
                        </td>
                        <td class="py-4.5 px-6 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $category->products_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                {{ $category->products_count }} SP
                            </span>
                        </td>
                        <td class="py-4.5 px-6 text-center">
                            <div class="flex items-center justify-center space-x-3">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="inline-flex items-center p-2 bg-gray-50 hover:bg-blue-50 text-gray-500 hover:text-blue-600 rounded-lg transition-colors border border-gray-200" title="Chỉnh sửa">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>

                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center p-2 bg-gray-50 hover:bg-red-50 text-gray-500 hover:text-red-600 rounded-lg transition-colors border border-gray-200" title="Xóa">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-16 text-center text-gray-400 bg-gray-50/30">
                            <span class="text-lg font-semibold block text-gray-500">Chưa có danh mục nào</span>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
            <div class="bg-gray-50 border-t border-gray-100 px-6 py-4 text-base">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
@endsection
