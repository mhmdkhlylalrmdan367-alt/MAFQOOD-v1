@extends('layouts.admin')

@section('title', 'تصنيف جديد')

@section('content')

<div class="max-w-2xl">
    <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-500 hover:text-primary-600 mb-4 inline-block">
        <i class="fa-solid fa-arrow-right ml-1"></i> العودة للتصنيفات
    </a>

    @if($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.categories.store') }}" class="bg-white rounded-xl shadow-sm p-6 space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">الاسم بالعربية *</label>
            <input type="text" name="name_ar" value="{{ old('name_ar') }}" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">الاسم بالإنجليزية *</label>
            <input type="text" name="name_en" value="{{ old('name_en') }}" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">الأيقونة (Font Awesome class)</label>
            <input type="text" name="icon" value="{{ old('icon', 'fa-box') }}" placeholder="fa-box"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 font-mono text-sm">
            <p class="text-xs text-gray-500 mt-1">مثال: fa-mobile-screen، fa-wallet، fa-key</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">ترتيب العرض</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5">
        </div>

        <div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                <span class="text-sm">نشط</span>
            </label>
        </div>

        <div class="flex gap-3 pt-4 border-t border-gray-100">
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-6 py-2.5 rounded-lg transition">
                <i class="fa-solid fa-check ml-2"></i> إنشاء
            </button>
            <a href="{{ route('admin.categories.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-lg transition">
                إلغاء
            </a>
        </div>
    </form>
</div>

@endsection