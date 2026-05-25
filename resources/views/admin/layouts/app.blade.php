<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard - {{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
<div class="min-h-screen flex">
    <div class="w-64 bg-gray-800 text-white p-6">
        <h1 class="text-2xl font-bold mb-8">Admin Panel</h1>
        <nav>
            <ul class="space-y-4">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-blue-400">Dashboard</a></li>
                <li><a href="{{ route('admin.products.index') }}" class="hover:text-blue-400">Sản phẩm</a></li>
                <li><a href="{{ route('admin.categories.index') }}" class="hover:text-blue-400">Danh mục</a></li>
                <li class="pt-4 border-t border-gray-700">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-400">Đăng xuất</button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>

    <div class="flex-1 p-10">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>
</div>
</body>
</html>
