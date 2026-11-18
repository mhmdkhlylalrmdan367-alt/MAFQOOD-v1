<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@hasSection('title')@yield('title') · @endif{{ __('messages.app_name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="{{ request()->routeIs('register', 'login', 'admin.login') ? 'signup-page' : '' }} {{ request()->routeIs('login', 'admin.login') ? 'login-page' : '' }} bg-gradient-to-br from-primary-600 to-primary-800 min-h-screen flex items-center justify-center p-4">

    <div class="guest-shell w-full max-w-md">
        <div class="guest-brand text-center mb-6">
            <a href="{{ route('home') }}" class="text-white text-3xl font-bold inline-flex items-center gap-2">
                <span class="relative size-12 shrink-0 overflow-hidden rounded-[30%]">
                    <img src="{{ asset('images/luqya-sham-logo.png') }}" alt="" width="1536" height="1024" class="absolute top-0 left-0 h-auto w-[233%] max-w-none -translate-x-[28.5%] -translate-y-[18.4%]">
                </span>
                {{ __('messages.app_name') }}
            </a>
            <p class="text-white/80 mt-2">{{ __('messages.tagline') }}</p>
        </div>

        <div class="signup-panel bg-white rounded-2xl shadow-2xl p-5 sm:p-8">
            @if(session('status'))
                <div class="mb-4 bg-blue-100 text-blue-700 px-4 py-3 rounded-lg text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @yield('content')
        </div>

        <div class="text-center mt-6 text-white/70 text-sm">
            &copy; {{ date('Y') }} {{ __('messages.app_name') }}
        </div>
    </div>

</body>
</html>