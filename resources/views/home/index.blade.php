@extends('layouts.app')

@section('title', 'الرئيسية')

@section('content')

{{-- Hero --}}
<section class="bg-gradient-to-br from-primary-600 to-primary-800 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-4">
            ابحث عن مفقوداتك أو أعدها لأصحابها
        </h1>
        <p class="text-lg md:text-xl text-white/90 mb-8 max-w-2xl mx-auto">
            منصة MAFQOOD تساعدك على نشر المفقودات والموجودات والتواصل مع أصحابها بأمان وسهولة
        </p>

        <form action="{{ route('search') }}" method="GET" class="max-w-2xl mx-auto mb-8">
            <div class="flex items-center bg-white rounded-xl shadow-lg overflow-hidden">
                <input type="text" name="q" placeholder="ابحث عن شيء فقدته أو عثرت عليه..."
                       class="flex-1 px-5 py-4 text-gray-800 outline-none">
                <button type="submit" class="bg-accent-500 hover:bg-accent-600 text-white px-6 py-4 font-semibold transition">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </form>

        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('items.create', ['type' => 'lost']) }}"
               class="bg-white text-primary-700 hover:bg-gray-100 px-6 py-3 rounded-lg font-semibold transition">
                <i class="fa-solid fa-circle-exclamation ml-2"></i>
                أبلغ عن شيء مفقود
            </a>
            <a href="{{ route('items.create', ['type' => 'found']) }}"
               class="bg-accent-500 hover:bg-accent-600 text-white px-6 py-3 rounded-lg font-semibold transition">
                <i class="fa-solid fa-hand-holding-heart ml-2"></i>
                أبلغ عن شيء عثرت عليه
            </a>
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="text-center">
            <div class="text-3xl font-bold text-primary-600">{{ number_format($stats['items']) }}</div>
            <div class="text-gray-500 text-sm mt-1">إعلان نشط</div>
        </div>
        <div class="text-center">
            <div class="text-3xl font-bold text-red-500">{{ number_format($stats['lost']) }}</div>
            <div class="text-gray-500 text-sm mt-1">مفقود</div>
        </div>
        <div class="text-center">
            <div class="text-3xl font-bold text-green-500">{{ number_format($stats['found']) }}</div>
            <div class="text-gray-500 text-sm mt-1">موجود</div>
        </div>
        <div class="text-center">
            <div class="text-3xl font-bold text-blue-500">{{ number_format($stats['resolved']) }}</div>
            <div class="text-gray-500 text-sm mt-1">تم استرجاعه</div>
        </div>
    </div>
</section>

{{-- Categories --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">التصنيفات</h2>
            <p class="text-gray-500">اختر التصنيف المناسب للبحث فيه</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($categories as $category)
                <a href="{{ route('categories.show', $category) }}"
                   class="bg-white rounded-xl p-5 text-center hover:shadow-lg transition border border-gray-100 group">
                    <div class="w-14 h-14 bg-primary-50 text-primary-600 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:bg-primary-600 group-hover:text-white transition">
                        <i class="fa-solid {{ $category->icon ?? 'fa-box' }} text-xl"></i>
                    </div>
                    <div class="font-medium text-gray-900 text-sm">{{ $category->name }}</div>
                    <div class="text-xs text-gray-400 mt-1">{{ $category->items_count }} إعلان</div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Latest Lost --}}
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">أحدث المفقودات</h2>
                <p class="text-gray-500 mt-1">ساعد أصحابها في العثور عليها</p>
            </div>
            <a href="{{ route('items.index', ['type' => 'lost']) }}" class="text-primary-600 hover:underline font-medium">
                عرض الكل <i class="fa-solid fa-arrow-left mr-1"></i>
            </a>
        </div>

        @if($latestLost->isEmpty())
            <div class="text-center py-12 text-gray-400">
                <i class="fa-solid fa-inbox text-5xl mb-3"></i>
                <p>لا توجد إعلانات مفقودات بعد</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($latestLost as $item)
                    <x-item-card :item="$item" />
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- Latest Found --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">أحدث الموجودات</h2>
                <p class="text-gray-500 mt-1">هل هذا الشيء لك؟</p>
            </div>
            <a href="{{ route('items.index', ['type' => 'found']) }}" class="text-primary-600 hover:underline font-medium">
                عرض الكل <i class="fa-solid fa-arrow-left mr-1"></i>
            </a>
        </div>

        @if($latestFound->isEmpty())
            <div class="text-center py-12 text-gray-400">
                <i class="fa-solid fa-inbox text-5xl mb-3"></i>
                <p>لا توجد إعلانات موجودات بعد</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($latestFound as $item)
                    <x-item-card :item="$item" />
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- How it works --}}
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">كيف يعمل الموقع؟</h2>
            <p class="text-gray-500">ثلاث خطوات بسيطة</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-user-plus text-2xl"></i>
                </div>
                <h3 class="font-bold text-lg mb-2">1. أنشئ حسابًا</h3>
                <p class="text-gray-500 text-sm">سجّل مجانًا وابدأ بنشر إعلاناتك</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-accent-100 text-accent-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-bullhorn text-2xl"></i>
                </div>
                <h3 class="font-bold text-lg mb-2">2. انشر إعلانك</h3>
                <p class="text-gray-500 text-sm">أضف صورًا ووصفًا دقيقًا للشيء</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-handshake text-2xl"></i>
                </div>
                <h3 class="font-bold text-lg mb-2">3. استرجع ممتلكاتك</h3>
                <p class="text-gray-500 text-sm">تواصل مع الطرف الآخر بأمان</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 bg-primary-600 text-white">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">جاهز للبدء؟</h2>
        <p class="text-white/90 mb-6">انضم إلى آلاف المستخدمين الذين استعادوا ممتلكاتهم</p>
        <a href="{{ route('register') }}"
           class="inline-block bg-white text-primary-700 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold transition">
            إنشاء حساب مجاني
        </a>
    </div>
</section>

@endsection