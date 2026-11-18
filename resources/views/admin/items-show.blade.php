@extends('layouts.admin')

@section('title', 'تفاصيل الإعلان')

@section('description', 'معلومات الإعلان وصاحبه، والصور المرفقة والبلاغات المرتبطة به.')

@section('content')

<div class="max-w-4xl">
    <a href="{{ route('admin.items.index') }}" class="text-sm text-gray-500 hover:text-primary-600 mb-4 inline-block">
        <i class="fa-solid fa-arrow-right ml-1" aria-hidden="true"></i> العودة للإعلانات
    </a>

    <div class="bg-white rounded-xl shadow-sm p-6 space-y-4">

        <div class="flex items-start justify-between">
            <div>
                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold text-white mb-2 {{ $item->type === 'lost' ? 'bg-red-500' : 'bg-green-500' }}">
                    {{ $item->type === 'lost' ? 'مفقود' : 'موجود' }}
                </span>
                <h2 class="text-2xl font-bold">{{ $item->title }}</h2>
            </div>
            <span class="text-xs text-gray-400">{{ $item->created_at->format('Y-m-d H:i') }}</span>
        </div>

        @if($item->images->isNotEmpty())
            <div class="admin-detail-images grid grid-cols-2 md:grid-cols-4 gap-2">
                @foreach($item->images as $img)
                    <a href="{{ asset('storage/' . $img->path) }}" target="_blank">
                        <img src="{{ asset('storage/' . $img->path) }}" class="w-full h-24 object-cover rounded-lg" alt="{{ $item->title }}" loading="lazy">
                    </a>
                @endforeach
            </div>
        @endif

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            <div>
                <div class="text-gray-500 text-xs">التصنيف</div>
                <div class="font-medium">{{ $item->category->name }}</div>
            </div>
            <div>
                <div class="text-gray-500 text-xs">المنطقة</div>
                <div class="font-medium">{{ $item->region?->name ?? '—' }}</div>
            </div>
            <div>
                <div class="text-gray-500 text-xs">الحالة</div>
                <div class="font-medium">{{ $item->status_label }}</div>
            </div>
            <div>
                <div class="text-gray-500 text-xs">المشاهدات</div>
                <div class="font-medium">{{ $item->views_count }}</div>
            </div>
        </div>

        <div>
            <div class="text-gray-500 text-xs mb-1">الوصف</div>
            <p class="text-gray-800 whitespace-pre-line">{{ $item->description }}</p>
        </div>

        @if($item->location_description)
            <div>
                <div class="text-gray-500 text-xs mb-1">مكان الفقدان/العثور</div>
                <p>{{ $item->location_description }}</p>
            </div>
        @endif

        <div>
            <div class="text-gray-500 text-xs mb-1">صاحب الإعلان</div>
            <div class="flex items-center gap-2">
                <img src="{{ $item->user->avatarUrl() }}" class="w-8 h-8 rounded-full" alt="">
                <div>
                    <div class="font-medium text-sm">{{ $item->user->name }}</div>
                    <div class="text-xs text-gray-500">{{ $item->user->email }}</div>
                </div>
            </div>
        </div>

        {{-- Reports --}}
        @if($item->reports->isNotEmpty())
            <div class="border-t border-gray-100 pt-4">
                <h3 class="font-bold text-red-600 mb-2"><i class="fa-solid fa-flag ml-1" aria-hidden="true"></i> البلاغات ({{ $item->reports->count() }})</h3>
                <div class="space-y-2">
                    @foreach($item->reports as $report)
                        <div class="bg-red-50 rounded-lg p-3 text-sm">
                            <div class="flex justify-between">
                                <span class="font-medium">{{ $report->reason_label }}</span>
                                <span class="text-xs text-gray-500">{{ $report->created_at->format('Y-m-d') }}</span>
                            </div>
                            @if($report->details)
                                <p class="text-gray-600 text-xs mt-1">{{ $report->details }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="flex gap-3 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.items.edit', $item) }}" class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-5 py-2.5 rounded-lg transition">
                <i class="fa-solid fa-pen ml-1" aria-hidden="true"></i> تعديل
            </a>
            <a href="{{ route('items.show', $item) }}" target="_blank" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-5 py-2.5 rounded-lg transition">
                <i class="fa-solid fa-eye ml-1" aria-hidden="true"></i> عرض في الموقع
            </a>
        </div>
    </div>
</div>

@endsection