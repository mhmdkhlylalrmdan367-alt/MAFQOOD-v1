<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة التحكم') - {{ __('messages.app_name') }} للإدارة</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @include('admin.partials.styles')
    @stack('styles')
</head>
<body class="admin-body">
<a href="#admin-content" class="admin-skip">انتقل إلى المحتوى</a>
<div class="admin-shell">
    <aside class="admin-sidebar" id="admin-navigation" aria-label="القائمة الرئيسية">
        <a href="{{ route('admin.dashboard') }}" class="admin-brand">
            <span class="admin-brand-mark"><i class="fa-solid fa-location-crosshairs" aria-hidden="true"></i></span>
            <span><strong>{{ __('messages.app_name') }}</strong><small>مساحة الإدارة</small></span>
        </a>
        <div class="admin-nav-caption">إدارة المنصة</div>
        <nav class="admin-nav" aria-label="أقسام الإدارة">
            @foreach([
                ['admin.dashboard', 'admin.dashboard', 'fa-chart-pie', 'نظرة عامة', 'متابعة أداء المنصة'],
                ['admin.users.index', 'admin.users.*', 'fa-users', 'المستخدمون', 'الحسابات والصلاحيات'],
                ['admin.items.index', 'admin.items.*', 'fa-box-open', 'الإعلانات', 'المفقودات والموجودات'],
                ['admin.categories.index', 'admin.categories.*', 'fa-layer-group', 'التصنيفات', 'تنظيم محتوى المنصة'],
                ['admin.reports.index', 'admin.reports.*', 'fa-shield-halved', 'البلاغات', 'المراجعة وحماية المجتمع'],
            ] as [$link, $pattern, $icon, $label, $description])
                <a href="{{ route($link) }}" class="admin-nav-link {{ request()->routeIs($pattern) ? 'is-active' : '' }}" @if(request()->routeIs($pattern)) aria-current="page" @endif>
                    <i class="fa-solid {{ $icon }}" aria-hidden="true"></i>
                    <span><strong>{{ $label }}</strong><small>{{ $description }}</small></span>
                    @if(request()->routeIs($pattern))<span class="admin-nav-dot" aria-hidden="true"></span>@endif
                </a>
            @endforeach
        </nav>
        <div class="admin-sidebar-bottom">
            <div class="admin-purpose"><i class="fa-solid fa-hand-holding-heart" aria-hidden="true"></i><strong>كل عودة، بداية حكاية.</strong><p>مساحة أكثر أماناً تجمع المفقودات بأصحابها.</p></div>
            <a href="{{ route('home') }}" class="admin-site-link"><i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i> زيارة الموقع</a>
            <span class="admin-sidebar-note">{{ __('messages.app_name') }} · لوحة الإدارة</span>
        </div>
    </aside>
    <div class="admin-workspace">
        <header class="admin-topbar">
            <div class="admin-topbar-start">
                <button class="admin-menu-button admin-icon-button" type="button" aria-label="فتح قائمة الإدارة" aria-controls="admin-navigation" aria-expanded="false" data-admin-menu><i class="fa-solid fa-bars" aria-hidden="true"></i></button>
                <a href="{{ route('admin.dashboard') }}" class="admin-breadcrumb-home">الإدارة</a><span class="admin-breadcrumb-divider" aria-hidden="true">/</span><span>@yield('title', 'لوحة التحكم')</span>
            </div>
            <div class="admin-topbar-actions">
                <span class="admin-date"><i class="fa-regular fa-calendar" aria-hidden="true"></i> {{ now()->format('Y / m / d') }}</span>
                <div class="admin-account"><img src="{{ auth()->user()->avatarUrl() }}" width="40" height="40" alt=""><span><strong>{{ auth()->user()->name }}</strong><small>إدارة المنصة</small></span></div>
                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="admin-icon-button admin-logout" aria-label="تسجيل الخروج" title="تسجيل الخروج"><i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i></button></form>
            </div>
        </header>
        <main id="admin-content" class="admin-content" tabindex="-1">
            <div class="admin-page-heading"><div><p class="admin-page-kicker">{{ __('messages.app_name') }} / مساحة الإدارة</p><h1>@yield('title', 'لوحة التحكم')</h1><p>@yield('description', 'أدر تفاصيل المنصة، وتابع ما يحتاج إلى اهتمامك من مكان واحد.')</p></div><a href="{{ route('home') }}" class="admin-button admin-button-secondary"><i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i> عرض الموقع</a></div>
            @if(session('success'))<div class="admin-alert admin-alert-success" role="status"><i class="fa-solid fa-circle-check" aria-hidden="true"></i>{{ session('success') }}</div>@endif
            @if(session('error'))<div class="admin-alert admin-alert-error" role="alert"><i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>{{ session('error') }}</div>@endif
            @yield('content')
        </main>
        <footer class="admin-footer"><span>{{ __('messages.app_name') }} · نقرّب المسافات، ونعيد الأمانات.</span><span>إدارة المنصة</span></footer>
    </div>
</div>
@include('admin.partials.scripts')
@stack('scripts')
</body>
</html>
