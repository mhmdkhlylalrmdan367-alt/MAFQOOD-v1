@extends('layouts.admin')

@section('title', 'تعديل تصنيف')

@section('description', 'حدّث الاسم والأيقونة وترتيب الظهور مع الحفاظ على رابط التصنيف.')

@section('content')

<div class="max-w-2xl">
    <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-500 hover:text-primary-600 mb-4 inline-block">
        <i class="fa-solid fa-arrow-right ml-1" aria-hidden="true"></i> العودة للتصنيفات
    </a>

    @if($errors->any())
        <div role="alert" tabindex="-1" data-admin-errors class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="bg-white rounded-xl shadow-sm p-6 space-y-4">
        @csrf @method('PUT')
        <div class="admin-form-title"><h2>تفاصيل التصنيف</h2><p>حدّث الاسم والأيقونة وترتيب الظهور مع الحفاظ على رابط التصنيف.</p></div>

        <div>
            <label for="admin-name_ar" class="block text-sm font-medium text-gray-700 mb-1">الاسم بالعربية *</label>
            <input id="admin-name_ar" type="text" name="name_ar" value="{{ old('name_ar', $category->name_ar) }}" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none" @if($errors->has('name_ar')) aria-invalid="true" aria-describedby="admin-name_ar-error" @endif>
            @error('name_ar')<p id="admin-name_ar-error" class="admin-field-error">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="admin-name_en" class="block text-sm font-medium text-gray-700 mb-1">الاسم بالإنجليزية *</label>
            <input id="admin-name_en" type="text" name="name_en" value="{{ old('name_en', $category->name_en) }}" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none" @if($errors->has('name_en')) aria-invalid="true" aria-describedby="admin-name_en-error" @endif dir="ltr">
            @error('name_en')<p id="admin-name_en-error" class="admin-field-error">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="admin-slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
            <input id="admin-slug" type="text" value="{{ $category->slug }}" disabled
                   class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-2.5 text-gray-500 font-mono text-sm">
            <p class="text-xs text-gray-500 mt-1">لا يمكن تغيير الـ slug</p>
        </div>

        <div>
            <label for="admin-icon" class="block text-sm font-medium text-gray-700 mb-1">الأيقونة</label>
            <input id="admin-icon" type="text" name="icon" value="{{ old('icon', $category->icon) }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 font-mono text-sm" @if($errors->has('icon')) aria-invalid="true" aria-describedby="admin-icon-error" @endif dir="ltr">
            @error('icon')<p id="admin-icon-error" class="admin-field-error">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="admin-sort_order" class="block text-sm font-medium text-gray-700 mb-1">ترتيب العرض</label>
            <input id="admin-sort_order" type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5" @if($errors->has('sort_order')) aria-invalid="true" aria-describedby="admin-sort_order-error" @endif>
            @error('sort_order')<p id="admin-sort_order-error" class="admin-field-error">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                <span class="text-sm">نشط</span>
            </label>
        </div>

        <div class="flex gap-3 pt-4 border-t border-gray-100">
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-6 py-2.5 rounded-lg transition">
                <i class="fa-solid fa-check ml-2" aria-hidden="true"></i> حفظ
            </button>
            <a href="{{ route('admin.categories.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-lg transition">
                إلغاء
            </a>
        </div>
    </form>
</div>

@endsection