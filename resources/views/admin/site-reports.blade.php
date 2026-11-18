@extends('layouts.admin')
@section('title', 'تقارير الموقع')
@section('description', 'تابع نشاط المنصة خلال فترة محددة، ونزّل التقرير بصيغة Excel.')

@section('content')
<section class="admin-report-toolbar admin-panel">
    <div class="admin-section-heading"><div><h2>اختر فترة التقرير</h2><p>من {{ $from }} إلى {{ $to }} · يشمل يوم البداية والنهاية</p></div><a href="{{ route('admin.site-reports.export', ['from' => $from, 'to' => $to]) }}" class="admin-button admin-button-primary"><i class="fa-solid fa-file-excel" aria-hidden="true"></i> تصدير Excel</a></div>
    @if($errors->any())
        <div class="admin-alert admin-alert-error" role="alert">{{ $errors->first() }}</div>
    @endif
    <form method="GET" action="{{ route('admin.site-reports.index') }}" class="admin-report-filters">
        <div class="admin-filter-field"><label for="report-from">من تاريخ</label><input id="report-from" type="date" name="from" value="{{ old('from', $from) }}" required></div>
        <div class="admin-filter-field"><label for="report-to">إلى تاريخ</label><input id="report-to" type="date" name="to" value="{{ old('to', $to) }}" required></div>
        <button type="submit" class="admin-button admin-button-primary"><i class="fa-solid fa-filter" aria-hidden="true"></i> عرض التقرير</button>
        <a href="{{ route('admin.site-reports.index') }}" class="admin-button admin-button-secondary">آخر 30 يوماً</a>
    </form>
</section>

<div class="admin-report-note"><i class="fa-solid fa-circle-info" aria-hidden="true"></i><p>تُحدّد الفترة بحسب تاريخ إنشاء الحساب أو الإعلان أو البلاغ. الاسترجاع والحالات والمشاهدات تعرض قيمها الحالية للسجلات المنشأة في الفترة، ولا تشمل الإعلانات المحذوفة.</p></div>

<section class="admin-stats-grid" aria-label="ملخص الفترة">
    @foreach([
        ['users', 'المستخدمون الجدد', 'fa-users', 'حسابات سُجّلت خلال الفترة'],
        ['items', 'الإعلانات المنشورة', 'fa-box-open', 'إعلانات أُضيفت خلال الفترة'],
        ['resolved', 'تم استرجاعها حالياً', 'fa-hand-holding-heart', 'من إعلانات الفترة المحددة'],
        ['reports', 'البلاغات الواردة', 'fa-shield-halved', 'بلاغات أُرسلت خلال الفترة'],
    ] as [$key, $label, $icon, $hint])
        <div class="admin-stat"><div class="admin-stat-top"><span>{{ $label }}</span><span class="admin-stat-icon"><i class="fa-solid {{ $icon }}" aria-hidden="true"></i></span></div><strong class="admin-stat-value">{{ number_format($summary[$key]) }}</strong><span class="admin-stat-foot">{{ $hint }}</span></div>
    @endforeach
</section>

<div class="admin-analysis-grid">
    <section class="admin-panel">
        <div class="admin-section-heading"><div><h2>حالة إعلانات الفترة</h2><p>{{ number_format($summary['lost']) }} مفقودات · {{ number_format($summary['found']) }} موجودات</p></div><span class="admin-result-count">{{ number_format($summary['views']) }} مشاهدة</span></div>
        <dl class="admin-report-breakdown">
            @foreach(['active' => 'نشطة', 'resolved' => 'تم استرجاعها', 'hidden' => 'مخفية', 'closed' => 'مغلقة'] as $key => $label)
                <div><dt>{{ $label }}</dt><dd>{{ number_format($summary[$key]) }}</dd></div>
            @endforeach
        </dl>
    </section>
    <section class="admin-panel">
        <div class="admin-section-heading"><div><h2>متابعة بلاغات الفترة</h2><p>الحالة الحالية للبلاغات الواردة ضمن الفترة</p></div></div>
        <dl class="admin-report-breakdown">
            @foreach(['pending_reports' => 'قيد المراجعة', 'reviewed_reports' => 'تمت المراجعة', 'accepted_reports' => 'مقبولة', 'rejected_reports' => 'مرفوضة'] as $key => $label)
                <div><dt>{{ $label }}</dt><dd>{{ number_format($summary[$key]) }}</dd></div>
            @endforeach
        </dl>
    </section>
</div>

<section class="admin-panel admin-report-categories">
    <div class="admin-section-heading"><div><h2>أداء التصنيفات</h2><p>الإعلانات المنشورة في الفترة والمسترجعة منها حالياً</p></div></div>
    <div class="admin-table-scroll" role="region" aria-label="أداء التصنيفات" tabindex="0"><table class="w-full text-sm"><thead><tr><th scope="col">التصنيف</th><th scope="col">الإعلانات</th><th scope="col">المسترجعة حالياً</th></tr></thead><tbody>
        @forelse($categories as $category)
            <tr class="border-b border-gray-100"><td>{{ $category->name_ar }}</td><td>{{ number_format($category->items_count) }}</td><td>{{ number_format($category->resolved_count) }}</td></tr>
        @empty
            <tr><td colspan="3">لا توجد تصنيفات لعرضها.</td></tr>
        @endforelse
    </tbody></table></div>
</section>

<section class="admin-panel">
    <div class="admin-section-heading"><div><h2>إعلانات الفترة</h2><p>يعرض الموقع 20 إعلاناً في الصفحة. ملف Excel يتضمن جميع نتائج الفترة.</p></div><span class="admin-result-count">{{ number_format($items->total()) }} إعلان</span></div>
    <div class="admin-table-scroll" role="region" aria-label="إعلانات الفترة" tabindex="0"><table class="w-full text-sm"><thead><tr><th scope="col">الإعلان</th><th scope="col">التصنيف</th><th scope="col">النوع</th><th scope="col">الحالة الحالية</th><th scope="col">تاريخ النشر</th></tr></thead><tbody>
        @forelse($items as $item)
            <tr class="border-b border-gray-100"><td><a class="text-primary-600" href="{{ route('admin.items.show', $item) }}">{{ $item->title }}</a></td><td>{{ $item->category?->name_ar ?? 'بدون تصنيف' }}</td><td>{{ $item->type === 'lost' ? 'مفقود' : 'موجود' }}</td><td>{{ $item->status_label }}</td><td><time datetime="{{ $item->created_at->toDateString() }}">{{ $item->created_at->format('Y-m-d') }}</time></td></tr>
        @empty
            <tr><td colspan="5">لا توجد إعلانات ضمن الفترة المختارة. جرّب توسيع الفترة.</td></tr>
        @endforelse
    </tbody></table></div>
    <div class="mt-4">{{ $items->links() }}</div>
</section>
@endsection
