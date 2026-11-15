@extends('layouts.admin')

@section('title', 'البلاغات')

@section('content')

<div class="bg-white rounded-xl shadow-sm p-4 mb-4">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <select name="status" class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            <option value="">كل الحالات</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
            <option value="reviewed" {{ request('status') === 'reviewed' ? 'selected' : '' }}>تمت المراجعة</option>
            <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>مقبول</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>مرفوض</option>
        </select>

        <select name="reason" class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            <option value="">كل الأسباب</option>
            <option value="spam" {{ request('reason') === 'spam' ? 'selected' : '' }}>محتوى مزعج</option>
            <option value="fraud" {{ request('reason') === 'fraud' ? 'selected' : '' }}>احتيال</option>
            <option value="wrong_category" {{ request('reason') === 'wrong_category' ? 'selected' : '' }}>تصنيف خاطئ</option>
            <option value="offensive" {{ request('reason') === 'offensive' ? 'selected' : '' }}>محتوى مسيء</option>
            <option value="duplicate" {{ request('reason') === 'duplicate' ? 'selected' : '' }}>مكرر</option>
            <option value="other" {{ request('reason') === 'other' ? 'selected' : '' }}>آخر</option>
        </select>

        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-semibold text-sm transition">
            <i class="fa-solid fa-filter ml-1"></i> تطبيق
        </button>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 border-b border-gray-200">
            <tr>
                <th class="text-right py-3 px-4">#</th>
                <th class="text-right py-3 px-4">المبلغ</th>
                <th class="text-right py-3 px-4">الإعلان</th>
                <th class="text-right py-3 px-4">السبب</th>
                <th class="text-right py-3 px-4">الحالة</th>
                <th class="text-right py-3 px-4">التاريخ</th>
                <th class="text-right py-3 px-4">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $report)
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="py-3 px-4 text-xs">#{{ $report->id }}</td>
                    <td class="py-3 px-4 text-xs">{{ $report->user?->name ?? '—' }}</td>
                    <td class="py-3 px-4">
                        @if($report->reportable_type === \App\Models\Item::class && $report->reportable)
                            <a href="{{ route('items.show', $report->reportable) }}" target="_blank" class="text-primary-600 hover:underline text-xs line-clamp-1">
                                {{ $report->reportable->title }}
                            </a>
                        @else
                            <span class="text-gray-400 text-xs">—</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 text-xs">{{ $report->reason_label }}</td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            {{ $report->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $report->status === 'accepted' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $report->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                            {{ $report->status === 'reviewed' ? 'bg-blue-100 text-blue-700' : '' }}">
                            {{ $report->status }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-xs text-gray-500">{{ $report->created_at->format('Y-m-d') }}</td>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-2">
                            <form method="POST" action="{{ route('admin.reports.action', $report) }}" class="inline">
                                @csrf
                                <input type="hidden" name="action" value="hide_item">
                                <button type="submit" class="text-yellow-600 hover:text-yellow-700" title="إخفاء الإعلان" {{ $report->status !== 'pending' ? 'disabled' : '' }}>
                                    <i class="fa-solid fa-eye-slash"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.reports.action', $report) }}" class="inline" onsubmit="return confirm('حذف الإعلان؟')">
                                @csrf
                                <input type="hidden" name="action" value="delete_item">
                                <button type="submit" class="text-red-600 hover:text-red-700" title="حذف الإعلان" {{ $report->status !== 'pending' ? 'disabled' : '' }}>
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.reports.action', $report) }}" class="inline">
                                @csrf
                                <input type="hidden" name="action" value="dismiss">
                                <button type="submit" class="text-gray-600 hover:text-gray-700" title="تجاهل البلاغ" {{ $report->status !== 'pending' ? 'disabled' : '' }}>
                                    <i class="fa-solid fa-times"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center py-10 text-gray-400">لا توجد بلاغات</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="flex justify-center mt-4">
    {{ $reports->links() }}
</div>

@endsection