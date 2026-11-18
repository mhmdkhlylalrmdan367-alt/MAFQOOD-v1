@extends('layouts.admin')

@section('title', 'تفاصيل البلاغ')

@section('description', 'راجع تفاصيل البلاغ والإعلان قبل تحديث الحالة أو اتخاذ إجراء.')

@section('content')

<div class="max-w-3xl">
    <a href="{{ route('admin.reports.index') }}" class="text-sm text-gray-500 hover:text-primary-600 mb-4 inline-block">
        <i class="fa-solid fa-arrow-right ml-1" aria-hidden="true"></i> العودة للبلاغات
    </a>

    <div class="bg-white rounded-xl shadow-sm p-6 space-y-4">

        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-2xl font-bold">بلاغ #{{ $report->id }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ $report->created_at->format('Y-m-d H:i') }}</p>
            </div>
            <span class="px-3 py-1 rounded-full text-sm font-semibold
                {{ $report->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                {{ $report->status === 'accepted' ? 'bg-green-100 text-green-700' : '' }}
                {{ $report->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                {{ $report->status === 'reviewed' ? 'bg-blue-100 text-blue-700' : '' }}">
                {{ ['pending' => 'قيد المراجعة', 'reviewed' => 'تمت المراجعة', 'accepted' => 'مقبول', 'rejected' => 'مرفوض'][$report->status] ?? $report->status }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-xs text-gray-500 mb-1">المُبلِّغ</div>
                <div class="font-medium">{{ $report->user?->name ?? '—' }}</div>
                <div class="text-xs text-gray-500">{{ $report->user?->email ?? '' }}</div>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-xs text-gray-500 mb-1">السبب</div>
                <div class="font-medium">{{ $report->reason_label }}</div>
            </div>
        </div>

        @if($report->details)
            <div>
                <div class="text-xs text-gray-500 mb-1">التفاصيل</div>
                <p class="bg-yellow-50 rounded-lg p-3 text-sm">{{ $report->details }}</p>
            </div>
        @endif

        @if($report->reportable_type === \App\Models\Item::class && $report->reportable)
            <div class="border-t border-gray-100 pt-4">
                <h3 class="font-bold mb-2">الإعلان المُبلَّغ عنه</h3>
                <div class="bg-gray-50 rounded-lg p-4 flex items-center gap-3">
                    <img src="{{ $report->reportable->first_image_url }}" class="w-16 h-16 rounded-lg object-cover" alt="">
                    <div class="flex-1">
                        <a href="{{ route('items.show', $report->reportable) }}" target="_blank" class="font-medium hover:text-primary-600">
                            {{ $report->reportable->title }}
                        </a>
                        <div class="text-xs text-gray-500">{{ $report->reportable->user->name }}</div>
                    </div>
                </div>
            </div>
        @endif

        @if($errors->any())<div class="admin-alert admin-alert-error" role="alert" tabindex="-1" data-admin-errors><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        {{-- Update status --}}
        <form method="POST" action="{{ route('admin.reports.update', $report) }}" class="border-t border-gray-100 pt-4 space-y-3">
            @csrf @method('PUT')

            <div>
                <label for="admin-status" class="block text-sm font-medium text-gray-700 mb-1">تحديث الحالة</label>
            <select id="admin-status" name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2.5" @if($errors->has('status')) aria-invalid="true" aria-describedby="admin-status-error" @endif>
                    <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                    <option value="reviewed" {{ $report->status === 'reviewed' ? 'selected' : '' }}>تمت المراجعة</option>
                    <option value="accepted" {{ $report->status === 'accepted' ? 'selected' : '' }}>مقبول</option>
                    <option value="rejected" {{ $report->status === 'rejected' ? 'selected' : '' }}>مرفوض</option>
                </select>
            @error('status')<p id="admin-status-error" class="admin-field-error">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="admin-admin_note" class="block text-sm font-medium text-gray-700 mb-1">ملاحظة (اختياري)</label>
            <textarea id="admin-admin_note" name="admin_note" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-2.5" @if($errors->has('admin_note')) aria-invalid="true" aria-describedby="admin-admin_note-error" @endif>{{ old('admin_note', $report->admin_note) }}</textarea>
            @error('admin_note')<p id="admin-admin_note-error" class="admin-field-error">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-6 py-2.5 rounded-lg transition">
                <i class="fa-solid fa-check ml-2" aria-hidden="true"></i> حفظ التحديث
            </button>
        </form>

        {{-- Actions --}}
        @if($report->status === 'pending')
            <div class="border-t border-gray-100 pt-4">
                <h3 class="font-bold mb-3">إجراءات سريعة</h3>
                <div class="flex gap-2 flex-wrap">
                    <form method="POST" action="{{ route('admin.reports.action', $report) }}" class="inline">
                        @csrf
                        <input type="hidden" name="action" value="hide_item">
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                            <i class="fa-solid fa-eye-slash ml-1" aria-hidden="true"></i> إخفاء الإعلان
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.reports.action', $report) }}" onsubmit="return confirm('حذف الإعلان نهائيًا؟')" class="inline">
                        @csrf
                        <input type="hidden" name="action" value="delete_item">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                            <i class="fa-solid fa-trash ml-1" aria-hidden="true"></i> حذف الإعلان
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.reports.action', $report) }}" class="inline">
                        @csrf
                        <input type="hidden" name="action" value="dismiss">
                        <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                            <i class="fa-solid fa-times ml-1" aria-hidden="true"></i> تجاهل البلاغ
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection