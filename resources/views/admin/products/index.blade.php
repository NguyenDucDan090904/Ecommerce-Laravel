@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Quản lý kho sản phẩm</h2>
            <p class="text-base text-gray-500 mt-1.5">Danh sách các thiết bị điện tử hiện có trên hệ thống cửa hàng.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="shrink-0 inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg font-semibold text-base transition-all shadow-sm shadow-blue-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Thêm sản phẩm mới
        </a>
    </div>

    <div class="mb-8 bg-gray-50 p-4 rounded-xl border border-gray-200 flex flex-col xl:flex-row xl:items-center justify-between gap-4">
        <div class="text-sm text-gray-600">
            <span class="font-bold">Mẫu file CSV chuẩn:</span> Tên sản phẩm, ID Danh mục, Giá, Tồn kho, Pin, CPU, RAM, Màn hình, Mô tả.
        </div>
        <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row sm:items-center gap-3 shrink-0">
            @csrf
            <input type="file" name="file" accept=".csv" required
                   class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-all">
            <button type="submit" class="shrink-0 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm px-4 py-2 rounded-lg transition-colors shadow-sm shadow-emerald-100">
                Nhập Excel/CSV
            </button>
        </form>
    </div>

    <form action="{{ route('admin.products.index') }}" method="GET" class="mb-6 bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex flex-col md:flex-row gap-4 items-end">

        <div class="flex-1 w-full">
            <label class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Nhập tên sản phẩm..."
                       class="pl-10 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm h-10 border px-3">
            </div>
        </div>

        <div class="w-full md:w-64">
            <label class="block text-sm font-medium text-gray-700 mb-1">Danh mục</label>
            <select name="category_id" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm h-10 border px-3">
                <option value="">Tất cả danh mục</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex gap-2 w-full md:w-auto">
            <button type="submit" class="flex-1 md:flex-none bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-5 py-2.5 rounded-lg transition-colors h-10">
                Lọc dữ liệu
            </button>
            <a href="{{ route('admin.products.index') }}" class="flex-1 md:flex-none bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-sm px-5 py-2.5 rounded-lg transition-colors h-10 text-center flex items-center justify-center">
                Xóa lọc
            </a>
        </div>
    </form>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-gray-600 uppercase text-sm font-bold tracking-wider">
                    <th class="py-4.5 px-6 w-28 whitespace-nowrap">Hình ảnh</th>

                    <th class="py-4.5 px-6 text-base w-[35%]">Thông tin sản phẩm</th>

                    <th class="py-4.5 px-6 text-base whitespace-nowrap w-32">Danh mục</th>

                    <th class="py-4.5 px-6 text-center text-base whitespace-nowrap w-36">Dung lượng Pin</th>

                    <th class="py-4.5 px-6 text-right text-base w-[20%]">Giá bán</th>

                    <th class="py-4.5 px-6 text-center text-base whitespace-nowrap w-32">Tồn kho</th>

                    <th class="py-4.5 px-6 text-center w-40 whitespace-nowrap">Hành động</th>

                    <th class="py-4.5 px-6 text-center w-40 whitespace-nowrap">Trạng thái</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700 text-base">
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50/60 transition-colors group">
                        <td class="py-4.5 px-6 vertical-align-middle">
                            @if($product->images->isNotEmpty())
                                <div class="relative w-16 h-16 rounded-lg overflow-hidden border border-gray-200 bg-gray-50 shadow-sm">
                                    <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="w-16 h-16 rounded-lg border border-dashed border-gray-300 bg-gray-50 flex items-center justify-center text-gray-400 italic text-xs">
                                    No Image
                                </div>
                            @endif
                        </td>

                        <td class="py-4.5 px-6">
                                <div class="font-bold text-gray-900 text-lg group-hover:text-blue-600 transition-colors">{{ $product->name }}</div>
                        </td>

                        <td class="py-4.5 px-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-semibold bg-gray-100 text-gray-700 border border-gray-200/60">
                                {{ $product->category->name }}
                            </span>
                        </td>

                        <td class="py-4.5 px-6 text-center">
                            @if(isset($product->attributes['battery']) && $product->attributes['battery'] !== '')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                    ⚡ {{ $product->attributes['battery'] }}
                                </span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>

                        <td class="py-4.5 px-6 text-right font-bold text-gray-900 text-lg">
                            {{ number_format($product->price, 0, ',', '.') }} <span class="text-sm font-normal text-gray-500">đ</span>
                        </td>

                        <td class="py-4.5 px-6 text-center">
                            @if($product->stock == 0)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-red-100 text-red-800">
                                    Hết hàng
                                </span>
                            @elseif($product->stock <= 5)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800" title="Cần nhập thêm hàng">
                                    Chỉ còn {{ $product->stock }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                    {{ $product->stock }} SP
                                </span>
                            @endif
                        </td>

                        <td class="py-4.5 px-6 text-center">
                            <div class="flex items-center justify-center space-x-3">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="inline-flex items-center p-2 bg-gray-50 hover:bg-blue-50 text-gray-500 hover:text-blue-600 rounded-lg transition-colors border border-gray-200" title="Chỉnh sửa">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>

                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này? Thao tác này không thể hoàn tác!')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center p-2 bg-gray-50 hover:bg-red-50 text-gray-500 hover:text-red-600 rounded-lg transition-colors border border-gray-200" title="Xóa">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <button type="button"
                                    onclick="toggleStatus(this)"
                                    data-url="{{ route('admin.products.toggle-status', $product->id) }}"
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $product->is_active ? 'bg-emerald-500' : 'bg-gray-300' }}"
                                    role="switch"
                                    aria-checked="{{ $product->is_active ? 'true' : 'false' }}">

                                <span aria-hidden="true"
                                      class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $product->is_active ? 'translate-x-5' : 'translate-x-0' }}">
                                </span>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-16 text-center text-gray-400 bg-gray-50/30">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span class="text-lg font-semibold block text-gray-500">Kho hàng trống</span>
                            <p class="text-sm text-gray-400 mt-1.5">Hãy bắt đầu thêm sản phẩm điện tử đầu tiên của bạn.</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="bg-gray-50 border-t border-gray-100 px-6 py-4 text-base">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    <script>
        function toggleStatus(buttonElement) {
            buttonElement.disabled = true;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            // Lấy URL chuẩn xác từ thuộc tính data-url của nút
            const targetUrl = buttonElement.getAttribute('data-url');

            fetch(targetUrl, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const innerCircle = buttonElement.querySelector('span');

                        if (data.is_active) {
                            buttonElement.classList.remove('bg-gray-300');
                            buttonElement.classList.add('bg-emerald-500');
                            innerCircle.classList.remove('translate-x-0');
                            innerCircle.classList.add('translate-x-5');
                            buttonElement.setAttribute('aria-checked', 'true');
                        } else {
                            buttonElement.classList.remove('bg-emerald-500');
                            buttonElement.classList.add('bg-gray-300');
                            innerCircle.classList.remove('translate-x-5');
                            innerCircle.classList.add('translate-x-0');
                            buttonElement.setAttribute('aria-checked', 'false');
                        }
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Lỗi Route hoặc Server! Vui lòng kiểm tra F12 -> Network.');
                })
                .finally(() => {
                    buttonElement.disabled = false;
                });
        }
    </script>
@endsection
