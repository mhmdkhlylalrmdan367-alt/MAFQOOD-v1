@extends('layouts.admin')

@section('title', 'تعديل إعلان')

@section('content')

<div class="max-w-3xl">
    <a href="{{ route('admin.items.index') }}" class="text-sm text-gray-500 hover:text-primary-600 mb-4 inline-block">
        <i class="fa-solid fa-arrow-right ml-1"></i> العودة للإعلانات
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

    <form method="POST" action="{{ route('admin.items.update', $item) }}" class="bg-white rounded-xl shadow-sm p-6 space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">العنوان *</label>
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
                <label class="block text-sm font-medium text-gray-700 mb-1">الحالة *</label>
                <select name="status" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5">
                    <option value="active" {{ old('status', $item->status) === 'active' ? 'selected' : '' }}>نشط</option>
                    <option value="resolved" {{ old('status', $item->status) === 'resolved' ? 'selected' : '' }}>تم الاسترجاع</option>
                    <option value="closed" {{ old('status', $item->status) === 'closed' ? 'selected' : '' }}>مغلق</option>
                    <option value="hidden" {{ old('status', $item->status) === 'hidden' ? 'selected' : '' }}>مخفي</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">الوصف *</label>
            <textarea name="description" rows="5" required
                      class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none">{{ old('description', $item->description) }}</textarea>
        </div>

        <div class="flex gap-3 pt-4 border-t border-gray-100">
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-6 py-2.5 rounded-lg transition">
                <i class="fa-solid fa-check ml-2"></i> حفظ
            </button>
            <a href="{{ route('admin.items.show', $item) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-lg transition">
                إلغاء
            </a>
        </div>
    </form>
</div>

@endsection