@extends('layouts.app')

@section('title', 'تعديل الإعلان')

@section('content')

<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">تعديل الإعلان</h1>

    @if($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
            <ul class="list-disc list-inside space-y-1 text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('items.update', $item) }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm p-6 space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">نوع الإعلان *</label>
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
            <label class="block text-sm font-medium text-gray-700 mb-1">عنوان الإعلان *</label>
            <input type="text" name="title" value="{{ old('title', $item->title) }}" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">التصنيف *</label>
                <select name="category_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $item->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">المنطقة</label>
                <select name="region_id" class="w-full border border-gray-300 rounded-lg px-3 py-2.5">
                    <option value="">اختر المنطقة</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}" {{ old('region_id', $item->region_id) == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">وصف الشيء *</label>
            <textarea name="description" rows="5" required
                      class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none">{{ old('description', $item->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">تاريخ الفقدان/العثور</label>
                <input type="date" name="event_date" value="{{ old('event_date', $item->event_date?->format('Y-m-d')) }}" max="{{ date('Y-m-d') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">مكان الفقدان/العثور</label>
                <input type="text" name="location_description" value="{{ old('location_description', $item->location_description) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5">
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
                            <form method="POST" action="{{ route('items.images.destroy', [$item, $img]) }}" class="absolute top-1 left-1">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('حذف الصورة؟')"
                                        class="bg-red-600 text-white w-6 h-6 rounded-full text-xs hover:bg-red-700">
                                    <i class="fa-solid fa-times"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">إضافة صور جديدة</label>
            <input type="file" name="images[]" multiple accept="image/*"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5">
        </div>

        <div class="flex gap-3 pt-4 border-t border-gray-100">
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-8 py-3 rounded-lg transition">
                <i class="fa-solid fa-check ml-2"></i> حفظ التعديلات
            </button>
            <a href="{{ route('items.show', $item) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-3 rounded-lg transition">
                إلغاء
            </a>
        </div>
    </form>
</div>

@endsection