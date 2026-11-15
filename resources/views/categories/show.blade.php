@extends('layouts.app')

@section('title', $category->name)

@section('content')

<div class="bg-primary-600 text-white py-12">
    <div class="max-w-7xl mx-auto px-4">
        <nav class="text-sm text-white/70 mb-3">
            <a href="{{ route('home') }}" class="hover:text-white">الرئيسية</a>
            <span class="mx-2">/</span>
            <a href="{{ route('categories.index') }}" class="hover:text-white">التصنيفات</a>
            <span class="mx-2">/</span>
            <span>{{ $category->name }}</span>
        </nav>
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                <i class="fa-solid {{ $category->icon ?? 'fa-box' }} text-2xl"></i>
            </div>
            <div>
                <h1 class="text-3xl font-bold">{{ $category->name }}</h1>
                <p class="text-white/80">{{ $items->total() }} إعلان</p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-8">
    @if($items->isEmpty())
        <div class="text-center py-16 bg-white rounded-xl shadow-sm">
            <i class="fa-solid fa-inbox text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">لا توجد إعلانات في هذا التصنيف</h3>
            <p class="text-gray-500 mb-6">كن أول من ينشر إعلانًا هنا</p>
            <a href="{{ route('items.create') }}" class="inline-block bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                <i class="fa-solid fa-plus ml-2"></i> نشر إعلان
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($items as $item)
                <x-item-card :item="$item" />
            @endforeach
        </div>

        <div class="flex justify-center">
            {{ $items->links() }}
        </div>
    @endif
</div>

@endsection