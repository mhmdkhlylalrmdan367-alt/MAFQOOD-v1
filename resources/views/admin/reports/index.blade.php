@extends('layouts.admin')

@section('title', 'البلاغات')

@section('description', 'راجع البلاغات وتفاصيلها قبل اتخاذ الإجراء المناسب.')

@section('content')
<x-flash-message/>
<div class="admin-resource-intro"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i><div><strong>مجتمع آمن يبدأ بالمراجعة</strong><p>راجع البلاغات وتفاصيلها قبل اتخاذ الإجراء المناسب.</p></div></div>

<div class="admin-filter-panel bg-white rounded-xl shadow-sm p-4 mb-4">
    <div class="admin-section-heading"><div><h2>البحث والتصفية</h2><p>حدّد حالة البلاغ وسببه للوصول إلى ما يحتاج إلى مراجعة.</p></div></div>
    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <div class="admin-filter-field">
            <label for="filter-status">حالة البلاغ</label>
            <select id="filter-status" name="status" class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            <option value="">كل الحالات</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
            <option value="reviewed" {{ request('status') === 'reviewed' ? 'selected' : '' }}>تمت المراجعة</option>
            <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>مقبول</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>مرفوض</option>
        </select>
        </div>

        <div class="admin-filter-field">
            <label for="filter-reason">سبب البلاغ</label>
            <select id="filter-reason" name="reason" class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            <option value="">كل الأسباب</option>
            <option value="spam" {{ request('reason') === 'spam' ? 'selected' : '' }}>محتوى مزعج</option>
            <option value="fraud" {{ request('reason') === 'fraud' ? 'selected' : '' }}>احتيال</option>
            <option value="wrong_category" {{ request('reason') === 'wrong_category' ? 'selected' : '' }}>تصنيف خاطئ</option>
            <option value="offensive" {{ request('reason') === 'offensive' ? 'selected' : '' }}>محتوى مسيء</option>
            <option value="duplicate" {{ request('reason') === 'duplicate' ? 'selected' : '' }}>مكرر</option>
            <option value="other" {{ request('reason') === 'other' ? 'selected' : '' }}>آخر</option>
        </select>
        </div>

        <div class="admin-filter-actions">
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-semibold text-sm transition">
            <i class="fa-solid fa-filter ml-1" aria-hidden="true"></i> تطبيق
        </button>
        <a href="{{ route('admin.reports.index') }}" class="admin-button admin-button-secondary">مسح التصفية</a>
        </div>
    </form>
</div>

<div class="admin-table-scroll bg-white rounded-xl shadow-sm overflow-hidden" role="region" aria-label="جدول البلاغات" tabindex="0">
    <table class="w-full text-sm">
        <caption class="admin-table-caption">البلاغات<small>{{ number_format($reports->total()) }} نتيجة</small></caption>
        <thead class="bg-gray-50 text-gray-600 border-b border-gray-200">
            <tr>
                <th scope="col" class="text-right py-3 px-4">#</th>
                <th scope="col" class="text-right py-3 px-4">المبلغ</th>
                <th scope="col" class="text-right py-3 px-4">الإعلان</th>
                <th scope="col" class="text-right py-3 px-4">السبب</th>
                <th scope="col" class="text-right py-3 px-4">الحالة</th>
                <th scope="col" class="text-right py-3 px-4">التاريخ</th>
                <th scope="col" class="text-right py-3 px-4">إجراءات</th>
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
                            {{ ['pending' => 'قيد المراجعة', 'reviewed' => 'تمت المراجعة', 'accepted' => 'مقبول', 'rejected' => 'مرفوض'][$report->status] ?? $report->status }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-xs text-gray-500">{{ $report->created_at->format('Y-m-d') }}</td>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.reports.show', $report) }}" class="text-primary-600" aria-label="مراجعة تفاصيل البلاغ" title="مراجعة التفاصيل"><i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
                            <form method="POST" action="{{ route('admin.reports.action', $report) }}" class="inline">
                                @csrf
                                <input type="hidden" name="action" value="hide_item">
                                <button type="submit" class="text-yellow-600 hover:text-yellow-700" title="إخفاء الإعلان" {{ $report->status !== 'pending' ? 'disabled' : '' }}>
                                    <i class="fa-solid fa-eye-slash" aria-hidden="true"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.reports.action', $report) }}" class="inline" onsubmit="return confirm('حذف الإعلان؟')">
                                @csrf
                                <input type="hidden" name="action" value="delete_item">
                                <button type="submit" class="text-red-600 hover:text-red-700" title="حذف الإعلان" {{ $report->status !== 'pending' ? 'disabled' : '' }}>
                                    <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.reports.action', $report) }}" class="inline">
                                @csrf
                                <input type="hidden" name="action" value="dismiss">
                                <button type="submit" class="text-gray-600 hover:text-gray-700" title="تجاهل البلاغ" {{ $report->status !== 'pending' ? 'disabled' : '' }}>
                                    <i class="fa-solid fa-times" aria-hidden="true"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center py-10 text-gray-400">لا توجد بلاغات مطابقة. يمكنك تغيير التصفية لعرض بقية البلاغات.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="flex justify-center mt-4">
    {{ $reports->links() }}
</div>

@endsection
