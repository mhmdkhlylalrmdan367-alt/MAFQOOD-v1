<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة التحكم') - {{ __('messages.app_name') }} للإدارة</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    <aside class="w-64 bg-gray-900 text-white flex-shrink-0">
        <div class="p-6 border-b border-gray-800">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold flex items-center gap-2">
                <i class="fa-solid fa-shield-halved"></i>
                {{ __('messages.app_name') }} للإدارة
            </a>
        </div>

        <nav class="p-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('admin.dashboard') ? 'bg-primary-600' : '' }}">
                <i class="fa-solid fa-chart-line w-5"></i>
                <span>لوحة المعلومات</span>
            </a>
            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('admin.users.*') ? 'bg-primary-600' : '' }}">
                <i class="fa-solid fa-users w-5"></i>
                <span>المستخدمون</span>
            </a>
            <a href="{{ route('admin.items.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('admin.items.*') ? 'bg-primary-600' : '' }}">
                <i class="fa-solid fa-box w-5"></i>
                <span>الإعلانات</span>
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('admin.categories.*') ? 'bg-primary-600' : '' }}">
                <i class="fa-solid fa-tags w-5"></i>
                <span>التصنيفات</span>
            </a>
            <a href="{{ route('admin.reports.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('admin.reports.*') ? 'bg-primary-600' : '' }}">
                <i class="fa-solid fa-flag w-5"></i>
                <span>البلاغات</span>
            </a>
        </nav>

        <div class="p-4 mt-auto border-t border-gray-800">
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition text-gray-400">
                <i class="fa-solid fa-arrow-left w-5"></i>
                <span>العودة للموقع</span>
            </a>
        </div>
    </aside>

    {{-- Main content --}}
    <div class="flex-1 flex flex-col">

        {{-- Topbar --}}
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <h1 class="text-xl font-semibold text-gray-800">@yield('title', 'لوحة التحكم')</h1>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                <img src="{{ auth()->user()->avatarUrl() }}" class="w-9 h-9 rounded-full" alt="">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-600 hover:text-red-700">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </header>

        <main class="flex-1 p-6">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>