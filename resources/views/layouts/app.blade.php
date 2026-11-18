<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@hasSection('title')@yield('title') · @endif{{ __('messages.app_name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @stack('styles')
</head>
<body id="page-top" class="site-body min-h-screen flex flex-col">

    @include('components.navbar')

    <main class="flex-1">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    <i class="fa-solid fa-check-circle ml-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    <i class="fa-solid fa-exclamation-circle ml-2"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    @include('components.footer')

    @if(request()->routeIs('home'))
        <a href="{{ route('items.create') }}"
           class="fixed right-4 bottom-[calc(1rem+env(safe-area-inset-bottom))] z-40 inline-flex min-h-12 items-center gap-2 rounded-full border border-white/20 bg-[#153e35] px-4 text-sm font-extrabold text-white shadow-lg transition-colors hover:bg-[#22594b] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#217161] sm:right-6 sm:px-5">
            <i class="fa-solid fa-plus text-[#efd8a8]" aria-hidden="true"></i>
            انشر بلاغ
        </a>
    @endif

    @auth
        <aside data-message-alert data-feed="{{ route('notifications.feed') }}"
               class="fixed bottom-24 right-4 z-50 w-[calc(100%-2rem)] max-w-sm rounded-2xl border border-[#b9cec3] bg-[#fffefa] p-4 text-[#153e35] shadow-xl" hidden>
            <div class="flex items-start justify-between gap-3">
                <a data-message-link class="min-w-0 flex-1 rounded-lg focus-visible:outline-2 focus-visible:outline-[#217161]">
                    <strong data-message-sender class="block text-sm"></strong>
                    <span class="mt-1 block text-xs text-[#53675f]">أرسل لك رسالة جديدة</span>
                    <span data-message-body class="mt-2 block truncate text-sm"></span>
                    <span class="mt-2 block text-xs font-bold underline">افتح المحادثة</span>
                </a>
                <button type="button" data-message-dismiss aria-label="إغلاق التنبيه" class="grid size-9 place-items-center rounded-lg hover:bg-[#e4efe8]">×</button>
            </div>
        </aside>
    @endauth

    @stack('scripts')
</body>
</html>