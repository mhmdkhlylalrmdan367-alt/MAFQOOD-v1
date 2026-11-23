@extends('layouts.app')

@section('title', 'تعديل البلاغ')

@section('content')

<div class="site-form-page max-w-4xl mx-auto px-4 py-8">
    <header class="site-page-heading"><h1 class="text-2xl font-bold text-gray-900 mb-6">تعديل البلاغ</h1><p>حدّث تفاصيل بلاغك وصوره لتسهيل الوصول إلى صاحبه.</p></header>

    @if($errors->any())
        <div role="alert" tabindex="-1" data-site-errors class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
            <ul class="list-disc list-inside space-y-1 text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('items.update', $item) }}" enctype="multipart/form-data" class="site-surface bg-white rounded-xl shadow-sm p-6 space-y-5">
        @csrf @method('PUT')
        <div class="site-form-intro"><i class="fa-solid fa-pen-to-square" aria-hidden="true"></i><div><h2>تفاصيل البلاغ</h2><p>الحقول المعلّمة بنجمة مطلوبة. احتفظ بعلامة مميّزة للتحقق من صاحب الغرض عند التواصل.</p></div></div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">نوع البلاغ *</label>
            <div class="flex gap-4">
                <label class="flex items-center gap-2 cursor-pointer bg-red-50 px-4 py-2 rounded-lg border border-red-200">
                    <input type="radio" name="type" value="lost" {{ old('type', $item->type) === 'lost' ? 'checked' : '' }} required>
                    <span class="font-medium text-red-700">مفقود</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer bg-green-50 px-4 py-2 rounded-lg border border-green-200">
                    <input type="radio" name="type" value="found" {{ old('type', $item->type) === 'found' ? 'checked' : '' }} required>
                    <span class="font-medium text-green-700">موجود</span>
                </label>
            </div>
        </div>

        <div>
            <label for="site-title" class="block text-sm font-medium text-gray-700 mb-1">عنوان البلاغ *</label>
            <input id="site-title" @if($errors->has('title')) aria-invalid="true" aria-describedby="site-title-error" @endif type="text" name="title" value="{{ old('title', $item->title) }}" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none">
            @error('title')<p id="site-title-error" class="site-field-error">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="site-category_id" class="block text-sm font-medium text-gray-700 mb-1">التصنيف *</label>
            <select id="site-category_id" @if($errors->has('category_id')) aria-invalid="true" aria-describedby="site-category_id-error" @endif name="category_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $item->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            @error('category_id')<p id="site-category_id-error" class="site-field-error">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="site-region_id" class="block text-sm font-medium text-gray-700 mb-1">المنطقة</label>
            <select id="site-region_id" @if($errors->has('region_id')) aria-invalid="true" aria-describedby="site-region_id-error" @endif name="region_id" class="w-full border border-gray-300 rounded-lg px-3 py-2.5">
                    <option value="">اختر المنطقة</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}" {{ old('region_id', $item->region_id) == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                    @endforeach
                </select>
            @error('region_id')<p id="site-region_id-error" class="site-field-error">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label for="site-description" class="block text-sm font-medium text-gray-700 mb-1">وصف الشيء *</label>
            <textarea id="site-description" @if($errors->has('description')) aria-invalid="true" aria-describedby="site-description-error" @endif name="description" rows="5" required
                      class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none">{{ old('description', $item->description) }}</textarea>
            @error('description')<p id="site-description-error" class="site-field-error">{{ $message }}</p>@enderror
        </div>

        <div class="site-form-divider"><h2>المكان والتاريخ</h2><p>تساعد التفاصيل التقريبية الآخرين على الوصول إلى البلاغ المناسب.</p></div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="site-event_date" class="block text-sm font-medium text-gray-700 mb-1">تاريخ الفقدان/العثور</label>
            <input id="site-event_date" @if($errors->has('event_date')) aria-invalid="true" aria-describedby="site-event_date-error" @endif type="date" name="event_date" value="{{ old('event_date', $item->event_date?->format('Y-m-d')) }}" max="{{ date('Y-m-d') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5">
            @error('event_date')<p id="site-event_date-error" class="site-field-error">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="site-location_description" class="block text-sm font-medium text-gray-700 mb-1">مكان الفقدان/العثور</label>
            <input id="site-location_description" @if($errors->has('location_description')) aria-invalid="true" aria-describedby="site-location_description-error" @endif type="text" name="location_description" value="{{ old('location_description', $item->location_description) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5">
            @error('location_description')<p id="site-location_description-error" class="site-field-error">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Current images --}}
        @if($item->images->isNotEmpty())
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">الصور الحالية</label>
                <div class="grid grid-cols-3 md:grid-cols-5 gap-3">
                    @foreach($item->images as $img)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $img->path) }}" class="w-full h-24 object-cover rounded-lg" alt="">
                            <button type="submit" form="delete-image-{{ $img->id }}" onclick="return confirm('حذف الصورة؟')" aria-label="حذف الصورة" class="site-image-delete absolute top-1 left-1 rounded-full bg-red-600 text-white hover:bg-red-700"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="site-form-divider"><h2>صور الغرض</h2><p>اختر صوراً واضحة، وتجنّب إظهار بيانات شخصية أو مستندات حساسة.</p></div>
        <div>
            <label for="site-images" class="block text-sm font-medium text-gray-700 mb-1">إضافة صور جديدة</label>
            <input id="site-images" @if($errors->has('images')) aria-invalid="true" aria-describedby="site-images-error" @endif data-site-upload type="file" name="images[]" multiple accept="image/*"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5">
            @error('images')<p id="site-images-error" class="site-field-error">{{ $message }}</p>@enderror
        </div>

        <div class="site-form-actions flex gap-3 pt-4 border-t border-gray-100">
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-8 py-3 rounded-lg transition">
                <i class="fa-solid fa-check ml-2" aria-hidden="true"></i> حفظ التعديلات
            </button>
            <a href="{{ route('items.show', $item) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-3 rounded-lg transition">
                إلغاء
            </a>
        </div>
    </form>
    @foreach($item->images as $img)
        <form id="delete-image-{{ $img->id }}" method="POST" action="{{ route('items.images.destroy', [$item, $img]) }}" hidden>
            @csrf @method('DELETE')
        </form>
    @endforeach
</div>

@endsection