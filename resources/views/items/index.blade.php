@extends('layouts.app')

@section('title', 'البلاغات')

@section('content')

<div class="bg-primary-600 text-white py-12">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-2">كل البلاغات</h1>
        <p class="text-white/80">ابحث بين المفقودات والموجودات</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- Filters --}}
    <form method="GET" action="{{ route('items.index') }}" class="site-surface bg-white rounded-xl shadow-sm p-4 mb-6 grid grid-cols-1 md:grid-cols-4 gap-3">
        <select name="type" class="border border-gray-300 rounded-lg px-3 py-2.5">
            <option value="">كل الأنواع</option>
            <option value="lost" {{ request('type') === 'lost' ? 'selected' : '' }}>مفقود</option>
            <option value="found" {{ request('type') === 'found' ? 'selected' : '' }}>موجود</option>
        </select>

        <select name="category" class="border border-gray-300 rounded-lg px-3 py-2.5">
            <option value="">كل التصنيفات</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>

        <select name="region" class="border border-gray-300 rounded-lg px-3 py-2.5">
            <option value="">كل المناطق</option>
            @foreach($regions as $region)
                <option value="{{ $region->id }}" {{ request('region') == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
            @endforeach
        </select>

        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-semibold transition">
            <i class="fa-solid fa-filter ml-2" aria-hidden="true"></i> تطبيق
        </button>
    </form>

    {{-- Results --}}
    @if($items->isEmpty())
        <div class="text-center py-16 bg-white rounded-xl">
            <i class="fa-solid fa-inbox text-6xl text-gray-300 mb-4" aria-hidden="true"></i>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">لا توجد بلاغات</h3>
            <p class="text-gray-500 mb-6">جرّب تغيير الفلاتر أو كن أول من ينشر بلاغاً</p>
            <a href="{{ route('items.create') }}" class="inline-block bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                <i class="fa-solid fa-plus ml-2" aria-hidden="true"></i> نشر بلاغ
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