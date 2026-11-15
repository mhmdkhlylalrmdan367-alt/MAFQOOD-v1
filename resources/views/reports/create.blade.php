@extends('layouts.app')

@section('title', 'الإبلاغ عن الإعلان')

@section('content')

<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-sm p-6">

        <div class="mb-6">
            <a href="{{ route('items.show', $item) }}" class="text-sm text-gray-500 hover:text-primary-600">
                <i class="fa-solid fa-arrow-right ml-1"></i> العودة للإعلان
            </a>
            <h1 class="text-2xl font-bold text-gray-900 mt-3">الإبلاغ عن الإعلان</h1>
            <p class="text-gray-500 text-sm mt-1">ساعدنا في الحفاظ على جودة المحتوى</p>
        </div>

        {{-- Item preview --}}
        <div class="bg-gray-50 rounded-lg p-3 mb-6 flex items-center gap-3">
            <img src="{{ $item->first_image_url }}" class="w-16 h-16 rounded-lg object-cover" alt="">
            <div class="flex-1 min-w-0">
                <div class="font-medium text-gray-900 line-clamp-1">{{ $item->title }}</div>
                <div class="text-xs text-gray-500">{{ $item->user->name }}</div>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('reports.store', $item) }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">سبب البلاغ *</label>
                <div class="space-y-2">
                    @php
                        $reasons = [
                            'spam' => 'محتوى مزعج أو رسائل غير مرغوبة',
                            'fraud' => 'احتيال أو نصب',
                            'wrong_category' => 'تصنيف خاطئ',
                            'offensive' => 'محتوى مسيء أو غير لائق',
                            'duplicate' => 'إعلان مكرر',
                            'other' => 'سبب آخر',
                        ];
                    @endphp
                    @foreach($reasons as $value => $label)
                        <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition {{ old('reason') === $value ? 'bg-primary-50 border-primary-300' : '' }}">
                            <input type="radio" name="reason" value="{{ $value }}" required {{ old('reason') === $value ? 'checked' : '' }}>
                            <span class="text-sm">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">تفاصيل إضافية (اختياري)</label>
                <textarea name="details" rows="4" placeholder="اشرح المشكلة بمزيد من التفاصيل..."
                          class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none">{{ old('details') }}</textarea>
            </div>

            <div class="flex gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2.5 rounded-lg transition">
                    <i class="fa-solid fa-flag ml-2"></i> إرسال البلاغ
                </button>
                <a href="{{ route('items.show', $item) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-lg transition">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

@endsection