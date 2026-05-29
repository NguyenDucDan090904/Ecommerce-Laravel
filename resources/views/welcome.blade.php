<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Shop - Trang chủ mua sắm</title>


    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">

<header class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <a href="{{ url('/') }}" class="text-2xl font-black text-blue-600 tracking-tight uppercase">
            E-Shop
        </a>

        <div class="flex items-center space-x-6 text-base font-semibold">
            <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-blue-600 flex items-center space-x-1.5 relative group">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span>Giỏ hàng</span>
                @if(session('cart') && count(session('cart')) > 0)
                    <span class="absolute -top-2 -right-3 bg-red-500 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full shadow-sm animate-bounce">
                            {{ count(session('cart')) }}
                        </span>
                @endif
            </a>

            @auth
                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600 bg-gray-100 px-4 py-2 rounded-xl transition">
                    Chào, {{ auth()->user()->name }}
                </a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-xl transition shadow-md shadow-blue-600/10">
                        Quản trị viên
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600">Đăng nhập</a>
                <a href="{{ route('register') }}" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-xl transition shadow-md shadow-blue-600/10">Đăng ký</a>
            @endauth
        </div>
    </div>
</header>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 md:p-12 shadow-xl mb-12 text-white flex flex-col justify-center">
        <h2 class="text-3xl md:text-5xl font-black mb-4 tracking-tight leading-tight">Chào mừng đến với E-Shop</h2>
        <p class="text-base md:text-lg text-blue-100 font-medium max-w-xl mb-6">Trải nghiệm không gian mua sắm trực tuyến hiện đại với hàng ngàn sản phẩm chất lượng cao cùng mức giá ưu đãi nhất.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-8 rounded-r-xl shadow-sm">
            <p class="text-green-700 font-semibold text-base">{{ session('success') }}</p>
        </div>
    @endif

    <h3 class="text-2xl font-black text-gray-900 mb-8 tracking-tight uppercase">Sản phẩm nổi bật</h3>

    @if(isset($products) && $products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach($products as $product)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col justify-between group hover:shadow-xl transition-all duration-300">

                    <a href="{{ route('frontend.products.show', $product->id) }}" class="relative bg-gray-50 pt-[100%] overflow-hidden block">
                        @if($product->images && $product->images->first())
                            <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center text-gray-400 bg-gray-100 text-sm font-semibold">No Image</div>
                        @endif
                    </a>

                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div class="mb-4">
                            <h4 class="text-base font-bold text-gray-900 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                <a href="{{ route('frontend.products.show', $product->id) }}">
                                    {{ $product->name }}
                                </a>
                            </h4>
                            <p class="text-xl font-black text-blue-600 mt-2">
                                {{ number_format($product->price, 0, ',', '.') }} đ
                            </p>
                        </div>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-3 bg-gray-900 hover:bg-blue-600 text-white rounded-xl text-base font-bold shadow-sm transition-all flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                <span>Thêm vào giỏ</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-2xl border border-gray-100 shadow-sm">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <p class="text-lg text-gray-500 font-medium">Hiện tại hệ thống chưa cập nhật sản phẩm nào.</p>
        </div>
    @endif
</main>

</body>
</html>
