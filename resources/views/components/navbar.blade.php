@php
    $navLinks = [
        ['الرئيسية', route('home'), request()->routeIs('home')],
        ['المفقودات', route('items.index', ['type' => 'lost']), request()->routeIs('items.index') && request('type') === 'lost'],
        ['الموجودات', route('items.index', ['type' => 'found']), request()->routeIs('items.index') && request('type') === 'found'],
        ['التصنيفات', route('categories.index'), request()->routeIs('categories.*')],
        ['كيف يعمل؟', route('how-it-works'), request()->routeIs('how-it-works')],
    ];
@endphp

<nav aria-label="التنقّل الرئيسي" class="sham-nav sticky top-0 z-50 border-b border-[#e6e3d9] bg-[#fcfbf7] text-[#193d35] shadow-sm">
    <div class="relative mx-auto flex min-h-18 max-w-7xl items-center justify-between gap-2 px-3 sm:px-6">
        <a href="{{ route('home') }}" class="sham-brand inline-flex shrink-0 items-center gap-2 text-sm font-extrabold tracking-wide sm:text-lg">
            <span class="sham-brand-icon relative size-9 shrink-0 overflow-hidden rounded-[30%] sm:size-11">
                <img src="{{ asset('images/luqya-sham-logo.png') }}" alt="" width="1536" height="1024"
                     class="absolute top-0 left-0 h-auto w-[233%] max-w-none -translate-x-[28.5%] -translate-y-[18.4%]">
            </span>
            @if(app()->getLocale() === 'ar')
                <span class="inline-flex items-baseline gap-1.5 whitespace-nowrap tracking-normal">
                    <span class="text-[1.22em] leading-none">لُقيا</span>
                    <span class="text-[0.83em] font-bold">الشام</span>
                </span>
            @else
                {{ __('messages.app_name') }}
            @endif
        </a>

        <div class="sham-nav-links hidden items-center gap-1 rounded-full border border-[#e6e3d9] bg-[#f2f1e9] p-1 lg:flex">
            @foreach($navLinks as [$label, $url, $active])
                <a href="{{ $url }}" @if($active) aria-current="page" @endif
                   class="rounded-full px-3 py-2 text-sm font-semibold transition {{ $active ? 'bg-[#153e35] text-white' : 'hover:bg-white' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <div class="flex items-center gap-1.5 sm:gap-2">
            <div class="flex items-center gap-0.5 rounded-xl border border-[#dce6db] bg-[#eef4ed] p-0.5 sm:gap-1 sm:p-1">
                <a href="{{ route('lang.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}" aria-label="تبديل اللغة"
                   class="inline-flex h-8 items-center justify-center gap-1.5 rounded-lg px-1.5 text-[11px] font-extrabold text-[#28594b] transition-colors hover:bg-white sm:px-2.5">
                    <i class="fa-solid fa-globe hidden sm:inline" aria-hidden="true"></i>
                    {{ app()->getLocale() === 'ar' ? 'EN' : 'ع' }}
                </a>
                @auth
                    @php $unread = auth()->user()->unreadNotifications()->count(); @endphp
                    <a href="{{ route('notifications.index') }}" aria-label="الإشعارات ({{ $unread }} غير مقروء)"
                       class="sham-nav-bell {{ $unread > 0 ? 'sham-nav-bell--unread' : '' }} relative grid size-8 place-items-center rounded-lg text-[#28594b] transition-colors hover:bg-white">
                        <i class="fa-regular fa-bell" aria-hidden="true"></i>
                        @if($unread > 0)
                            <span aria-hidden="true" class="absolute -top-1 -end-1 rounded-full bg-[#ad553c] px-1 text-[10px] font-bold text-white">{{ $unread > 99 ? '99+' : $unread }}</span>
                        @endif
                    </a>
                    <a href="{{ route('conversations.index') }}" aria-label="الرسائل"
                       class="grid size-8 place-items-center rounded-lg text-[#28594b] transition-colors hover:bg-white">
                        <i class="fa-regular fa-comment-dots" aria-hidden="true"></i>
                    </a>
                @endauth
            </div>
            @auth
                <details class="relative">
                    <summary aria-label="قائمة الحساب" class="flex min-h-10 cursor-pointer list-none items-center gap-2 rounded-xl border border-[#cbdcd0] bg-white px-1.5 py-1 transition-colors hover:bg-[#eef4ed] sm:px-2 [&::-webkit-details-marker]:hidden">
                        @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatarUrl() }}" class="size-7 rounded-lg object-cover" alt="">
                        @else
                            <span aria-hidden="true" class="grid size-7 place-items-center rounded-lg bg-[#18594b] text-xs font-extrabold text-[#fff4d8]">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr(auth()->user()->name, 0, 1)) }}</span>
                        @endif
                        <span class="hidden max-w-24 truncate text-sm font-extrabold xl:inline">{{ auth()->user()->name }}</span>
                        <i class="fa-solid fa-chevron-down hidden text-[9px] text-[#53675f] sm:inline" aria-hidden="true"></i>
                    </summary>

                    <div class="absolute end-0 top-full mt-3 w-48 rounded-xl border border-[#e6e3d9] bg-white p-1.5 text-sm shadow-lg">
                        <a href="{{ route('dashboard') }}" class="block rounded-lg px-3 py-2 hover:bg-[#e7efe9]">لوحة التحكم</a>
                        <a href="{{ route('profile.edit') }}" class="block rounded-lg px-3 py-2 hover:bg-[#e7efe9]">الملف الشخصي</a>
                        @if(auth()->user()->isModerator())
                            <a href="{{ route('admin.dashboard') }}" class="block rounded-lg px-3 py-2 hover:bg-[#e7efe9]">لوحة الإدارة</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="mt-1 border-t border-[#e6e3d9] pt-1">
                            @csrf
                            <button type="submit" class="w-full rounded-lg px-3 py-2 text-start text-[#a94736] hover:bg-red-50">تسجيل الخروج</button>
                        </form>
                    </div>
                </details>
            @else
                <a href="{{ route('login') }}" class="rounded-full px-2 py-2 text-sm font-semibold hover:bg-[#e7efe9]">دخول</a>
                <a href="{{ route('register') }}" class="hidden rounded-full bg-[#153e35] px-4 py-2 text-sm font-bold text-white sm:inline-block">إنشاء حساب</a>
            @endauth

            <details class="lg:hidden">
                <summary aria-label="قائمة التنقّل" class="grid size-9 cursor-pointer list-none place-items-center rounded-xl border border-[#e6e3d9] [&::-webkit-details-marker]:hidden">
                    <i class="fa-solid fa-bars" aria-hidden="true"></i>
                </summary>
                <div class="absolute inset-x-3 top-full mt-2 grid gap-1 rounded-xl border border-[#e6e3d9] bg-[#fcfbf7] p-2 text-sm shadow-lg">
                    @foreach($navLinks as [$label, $url, $active])
                        <a href="{{ $url }}" @if($active) aria-current="page" @endif
                           class="rounded-lg px-4 py-2.5 {{ $active ? 'bg-[#153e35] text-white' : 'hover:bg-[#e7efe9]' }}">{{ $label }}</a>
                    @endforeach
                    @guest
                        <a href="{{ route('register') }}" class="rounded-lg px-4 py-2.5 font-bold sm:hidden">إنشاء حساب</a>
                    @endguest
                </div>
            </details>
        </div>
    </div>
</nav>
