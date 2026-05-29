@extends('layouts.app') {{-- Hoặc tên file layout chính của bạn --}}

@section('title', $product->name . ' - E-Shop')

@section('content')
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 md:p-8">
        <a href="{{ url('/') }}" class="inline-flex items-center space-x-2 text-sm font-semibold text-gray-500 hover:text-blue-600 mb-8 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Quay lại trang chủ</span>
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div>
                <div class="bg-gray-50 rounded-2xl aspect-square overflow-hidden border border-gray-100 mb-4 relative">
                    @if($product->images && $product->images->isNotEmpty())
                        <img id="main-product-image" src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition duration-300">
                    @else
                        <div class="absolute inset-0 flex items-center justify-center text-gray-400 bg-gray-100 text-base font-semibold">No Image</div>
                    @endif
                </div>

                @if($product->images && $product->images->count() > 1)
                    <div class="grid grid-cols-5 gap-3">
                        @foreach($product->images as $image)
                            <button type="button"
                                    onclick="changeMainImage('{{ asset('storage/' . $image->path) }}', this)"
                                    class="aspect-square bg-gray-50 rounded-xl overflow-hidden border-2 {{ $loop->first ? 'border-blue-600' : 'border-transparent' }} hover:border-blue-600 transition thumbnail-btn">
                                <img src="{{ asset('storage/' . $image->path) }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="flex flex-col justify-between">
                <div>
                <span class="text-xs font-bold text-blue-600 uppercase tracking-widest bg-blue-50 px-3 py-1 rounded-full">
                    {{ $product->category->name ?? 'Chưa phân loại' }}
                </span>

                    <h1 class="text-2xl md:text-3xl font-black text-gray-900 mt-4 leading-tight">
                        {{ $product->name }}
                    </h1>

                    <p class="text-3xl font-black text-blue-600 mt-4 tracking-tight">
                        {{ number_format($product->price, 0, ',', '.') }} đ
                    </p>

                    <div class="mt-4 flex items-center space-x-2 text-sm text-gray-500 font-medium">
                        <span class="inline-block w-2 h-2 rounded-full {{ $product->stock > 0 ? 'bg-green-500' : 'bg-red-500' }}"></span>
                        <span>Tình trạng: {{ $product->stock > 0 ? 'Còn hàng (' . $product->stock . ' sản phẩm)' : 'Hết hàng' }}</span>
                    </div>

                    <hr class="my-6 border-gray-100">

                    @if(!empty($product->attributes) && is_array($product->attributes))
                        <div class="mb-6">
                            <h3 class="text-sm font-black text-gray-900 uppercase tracking-wider mb-3">Thông số kỹ thuật</h3>
                            <div class="border border-gray-100 rounded-xl overflow-hidden">
                                <table class="w-full text-sm text-left text-gray-500">
                                    <tbody class="divide-y divide-gray-100">
                                    @foreach($product->attributes as $key => $value)
                                        <tr class="bg-white">
                                            <td class="px-4 py-3 font-semibold text-gray-700 bg-gray-50/50 w-1/3 capitalize">{{ str_replace('_', ' ', $key) }}</td>
                                            <td class="px-4 py-3 text-gray-900 font-medium">{{ $value }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="mt-8">
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                                {{ $product->stock <= 0 ? 'disabled' : '' }}
                                class="w-full md:w-auto md:px-12 py-4 {{ $product->stock > 0 ? 'bg-gray-900 hover:bg-blue-600' : 'bg-gray-300 cursor-not-allowed' }} text-white rounded-xl text-base font-bold shadow-md transition-all flex items-center justify-center space-x-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <span>{{ $product->stock > 0 ? 'Thêm vào giỏ hàng' : 'Hết hàng tạm thời' }}</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function changeMainImage(imagePath, buttonElement) {
            // 1. Thay đổi thuộc tính src của ảnh lớn
            document.getElementById('main-product-image').src = imagePath;

            // 2. Reset viền của toàn bộ các nút nhỏ
            document.querySelectorAll('.thumbnail-btn').forEach(btn => {
                btn.classList.remove('border-blue-600');
                btn.classList.add('border-transparent');
            });

            // 3. Thêm viền xanh làm nổi bật nút vừa được click
            buttonElement.classList.remove('border-transparent');
            buttonElement.classList.add('border-blue-600');
        }
    </script>
@endsection
