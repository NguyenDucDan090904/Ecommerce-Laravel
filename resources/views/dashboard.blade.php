<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cửa hàng Điện tử') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                        <div class="font-bold text-lg mb-2">{{ $product->name }}</div>
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($product->description, 50) }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-red-500 font-bold">{{ number_format($product->price) }}đ</span>
                            <a href="{{ route('products.show', $product->slug) }}" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">Chi tiết</a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
