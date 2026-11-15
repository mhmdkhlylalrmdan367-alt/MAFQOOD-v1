@extends('layouts.app')

@section('title', 'التصنيفات')

@section('content')

<div class="bg-primary-600 text-white py-12">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-2">التصنيفات</h1>
        <p class="text-white/80">اختر التصنيف للبحث عن المفقودات والموجودات</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-8">
    @if($categories->isEmpty())
        <div class="text-center py-16 text-gray-400">
            <i class="fa-solid fa-tags text-6xl mb-3"></i>
            <p>لا توجد تصنيفات بعد</p>
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('categories.show', $category) }}"
                   class="bg-white rounded-xl shadow-sm hover:shadow-lg transition p-6 text-center border border-gray-100 group">
                    <div class="w-16 h-16 bg-primary-50 text-primary-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-600 group-hover:text-white transition">
                        <i class="fa-solid {{ $category->icon ?? 'fa-box' }} text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">{{ $category->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $category->items_count }} إعلان</p>
                </a>
            @endforeach
        </div>
    @endif
</div>

@endsection