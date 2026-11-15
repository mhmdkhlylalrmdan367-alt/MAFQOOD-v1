@extends('layouts.app')

@section('title', 'البحث')

@section('content')

<div class="bg-primary-600 text-white py-10">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-4">البحث المتقدم</h1>

        <form method="GET" action="{{ route('search') }}">
            <div class="flex items-center bg-white rounded-xl shadow-lg overflow-hidden max-w-3xl">
                <input type="text" name="q" value="{{ $q }}"
                       placeholder="ابحث عن شيء فقدته أو عثرت عليه..."
                       class="flex-1 px-5 py-3.5 text-gray-800 outline-none">
                <button type="submit" class="bg-accent-500 hover:bg-accent-600 text-white px-6 py-3.5 font-semibold transition">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- Advanced filters --}}
    <form method="GET" action="{{ route('search') }}" class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <input type="hidden" name="q" value="{{ $q }}">

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-3">
            <select name="type" class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
                <option value="">كل الأنواع</option>
                <option value="lost" {{ request('type') === 'lost' ? 'selected' : '' }}>مفقود</option>
                <option value="found" {{ request('type') === 'found' ? 'selected' : '' }}>موجود</option>
            </select>

            <select name="category" class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
                <option value="">كل التصنيفات</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>

            <select name="region" class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
                <option value="">كل المناطق</option>
                @foreach($regions as $region)
                    <option value="{{ $region->id }}" {{ request('region') == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                @endforeach
            </select>

            <select name="status" class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
                <option value="">كل الحالات</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>نشط</option>
                <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>تم استرجاعه</option>
                <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>مغلق</option>
            </select>

            <select name="sort" class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
                <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>الأحدث</option>
                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>الأقدم</option>
            </select>

            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-semibold text-sm transition">
                <i class="fa-solid fa-filter ml-1"></i> تطبيق الفلاتر
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-3">
            <div>
                <label class="block text-xs text-gray-500 mb-1">من تاريخ</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">إلى تاريخ</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div class="flex items-end">
                <a href="{{ route('search') }}" class="text-sm text-gray-500 hover:text-primary-600">
                    <i class="fa-solid fa-times ml-1"></i> مسح الفلاتر
                </a>
            </div>
        </div>
    </form>

    {{-- Results info --}}
    <div class="flex items-center justify-between mb-4">
        <p class="text-gray-600">
            @if($q)
                نتائج البحث عن "<strong>{{ $q }}</strong>" — 
            @endif
            <strong>{{ $items->total() }}</strong> نتيجة
        </p>
    </div>

    {{-- Results --}}
    @if($items->isEmpty())
        <div class="text-center py-16 bg-white rounded-xl shadow-sm">
            <i class="fa-solid fa-search text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">لا توجد نتائج</h3>
            <p class="text-gray-500">جرّب تغيير كلمات البحث أو الفلاتر</p>
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