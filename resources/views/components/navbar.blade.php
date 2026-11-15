<nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">

            <a href="{{ route('home') }}" class="text-2xl font-bold text-primary-600 flex items-center gap-2">
                <i class="fa-solid fa-magnifying-glass-location"></i>
                MAFQOOD
            </a>

            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary-600 transition">الرئيسية</a>
                <a href="{{ route('items.index', ['type' => 'lost']) }}" class="text-gray-700 hover:text-primary-600 transition">المفقودات</a>
                <a href="{{ route('items.index', ['type' => 'found']) }}" class="text-gray-700 hover:text-primary-600 transition">الموجودات</a>
                <a href="{{ route('categories.index') }}" class="text-gray-700 hover:text-primary-600 transition">التصنيفات</a>
                <a href="{{ route('how-it-works') }}" class="text-gray-700 hover:text-primary-600 transition">كيف يعمل؟</a>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('lang.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
                   class="text-sm text-gray-600 hover:text-primary-600 border border-gray-300 rounded px-2 py-1">
                    {{ app()->getLocale() === 'ar' ? 'EN' : 'ع' }}
                </a>

                @auth
                    @php $unread = auth()->user()->unreadNotifications()->count(); @endphp

                    <a href="{{ route('notifications.index') }}" class="relative text-gray-600 hover:text-primary-600 p-2">
                        <i class="fa-solid fa-bell text-lg"></i>
                        @if($unread > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ $unread }}</span>
                        @endif
                    </a>
                    

                    <a href="{{ route('conversations.index') }}" class="text-gray-600 hover:text-primary-600 p-2">
                        <i class="fa-solid fa-envelope text-lg"></i>
                    </a>

                    <div class="relative group">
                        <button class="flex items-center gap-2 text-gray-700">
                            <img src="{{ auth()->user()->avatarUrl() }}" class="w-9 h-9 rounded-full" alt="">
                            <span class="hidden md:inline">{{ auth()->user()->name }}</span>
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute left-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg hidden group-hover:block z-50">
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-50">لوحة التحكم</a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-50">الملف الشخصي</a>
                            @if(auth()->user()->isModerator())
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-gray-50 text-primary-600">لوحة الإدارة</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100">
                                @csrf
                                <button type="submit" class="w-full text-right px-4 py-2 hover:bg-gray-50 text-red-600">تسجيل الخروج</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary-600 transition">دخول</a>
                    <a href="{{ route('register') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition">إنشاء حساب</a>
                @endauth
            </div>
        </div>
    </div>
</nav>