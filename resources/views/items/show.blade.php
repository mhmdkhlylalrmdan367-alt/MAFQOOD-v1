@extends('layouts.app')

@section('title', $item->title)

@section('content')

<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-500 mb-4">
        <a href="{{ route('home') }}" class="hover:text-primary-600">الرئيسية</a>
        <span class="mx-2">/</span>
        <a href="{{ route('items.index', ['type' => $item->type]) }}" class="hover:text-primary-600">
            {{ $item->type === 'lost' ? 'المفقودات' : 'الموجودات' }}
        </a>
        <span class="mx-2">/</span>
        <span class="text-gray-700">{{ $item->title }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Main --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Images --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                @if($item->images->isNotEmpty())
                    <div class="aspect-video bg-gray-100">
                        <img id="main-image" src="{{ asset('storage/' . $item->images->first()->path) }}"
                             alt="{{ $item->title }}" class="w-full h-full object-cover">
                    </div>
                    @if($item->images->count() > 1)
                        <div class="p-3 flex gap-2 overflow-x-auto">
                            @foreach($item->images as $img)
                                <img src="{{ asset('storage/' . $img->path) }}"
                                     onclick="document.getElementById('main-image').src=this.src"
                                     class="w-20 h-20 object-cover rounded-lg cursor-pointer hover:ring-2 hover:ring-primary-500">
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="aspect-video bg-gray-100 flex items-center justify-center text-gray-400">
                        <i class="fa-solid fa-image text-6xl"></i>
                    </div>
                @endif
            </div>

            {{-- Info --}}
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold text-white mb-2 {{ $item->type === 'lost' ? 'bg-red-500' : 'bg-green-500' }}">
                            {{ $item->type === 'lost' ? 'مفقود' : 'موجود' }}
                        </span>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $item->title }}</h1>
                    </div>
                    <span class="text-sm text-gray-400">{{ $item->created_at->diffForHumans() }}</span>
                </div>

                <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-6">
                    <span><i class="fa-solid fa-tag ml-1 text-primary-600"></i> {{ $item->category->name }}</span>
                    @if($item->region)
                        <span><i class="fa-solid fa-location-dot ml-1 text-primary-600"></i> {{ $item->region->name }}</span>
                    @endif
                    @if($item->event_date)
                        <span><i class="fa-solid fa-calendar ml-1 text-primary-600"></i> {{ $item->event_date->format('Y-m-d') }}</span>
                    @endif
                    <span><i class="fa-solid fa-eye ml-1 text-primary-600"></i> {{ $item->views_count }} مشاهدة</span>
                </div>

                <h2 class="font-bold text-lg mb-2">الوصف</h2>
                <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $item->description }}</p>

                @if($item->location_description)
                    <h2 class="font-bold text-lg mt-6 mb-2">مكان الفقدان/العثور</h2>
                    <p class="text-gray-700">{{ $item->location_description }}</p>
                @endif

                @if($item->status !== 'active')
                    <div class="mt-6 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg">
                        <i class="fa-solid fa-circle-check ml-2"></i>
                        حالة الإعلان: <strong>{{ $item->status_label }}</strong>
                    </div>
                @endif
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">

            {{-- Owner --}}
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-gray-900 mb-4">صاحب الإعلان</h3>
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ $item->user->avatarUrl() }}" class="w-12 h-12 rounded-full" alt="">
                    <div>
                        <div class="font-semibold text-gray-900">{{ $item->user->name }}</div>
                        <div class="text-xs text-gray-500">عضو منذ {{ $item->user->created_at->format('Y-m-d') }}</div>
                    </div>
                </div>

                @auth
                    @if(auth()->id() !== $item->user_id)
                        <form method="POST" action="{{ route('conversations.store') }}" class="space-y-2">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                            <textarea name="body" rows="3" required
                                      placeholder="اكتب رسالتك لصاحب الإعلان..."
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 outline-none"></textarea>
                            <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 rounded-lg transition">
                                <i class="fa-solid fa-paper-plane ml-2"></i> إرسال رسالة
                            </button>
                        </form>

                        <a href="{{ route('reports.create', $item) }}" class="block text-center text-sm text-red-600 hover:underline mt-3">
                            <i class="fa-solid fa-flag ml-1"></i> الإبلاغ عن الإعلان
                        </a>
                    @else
                        <div class="space-y-2">
                            <a href="{{ route('items.edit', $item) }}" class="block text-center bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-2.5 rounded-lg transition">
                                <i class="fa-solid fa-pen ml-2"></i> تعديل الإعلان
                            </a>
                            <form method="POST" action="{{ route('items.destroy', $item) }}" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-full text-red-600 hover:bg-red-50 font-semibold py-2.5 rounded-lg transition">
                                    <i class="fa-solid fa-trash ml-2"></i> حذف الإعلان
                                </button>
                            </form>
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="block text-center bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 rounded-lg transition">
                        سجّل الدخول للتواصل
                    </a>
                @endauth
            </div>

            {{-- Related --}}
            @if($related->isNotEmpty())
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-4">إعلانات مشابهة</h3>
                    <div class="space-y-3">
                        @foreach($related as $rel)
                            <a href="{{ route('items.show', $rel) }}" class="flex gap-3 hover:bg-gray-50 p-2 -mx-2 rounded-lg transition">
                                <img src="{{ $rel->first_image_url }}" class="w-16 h-16 rounded-lg object-cover" alt="">
                                <div class="flex-1 min-w-0">
                                    <div class="font-medium text-sm text-gray-900 line-clamp-1">{{ $rel->title }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $rel->created_at->diffForHumans() }}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection