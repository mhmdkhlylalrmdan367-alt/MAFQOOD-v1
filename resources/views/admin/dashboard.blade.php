@extends('layouts.admin')
@section('title', 'نظرة عامة')
@section('description', 'صورة واضحة لحركة المنصة، وأولويات اليوم، وأثر كل عملية استرجاع.')
@section('content')
@php
    $resolvedPercent = $stats['items'] > 0 ? min(100, round($stats['resolved'] / $stats['items'] * 100)) : 0;
    $overviewCards = [
        ['users', 'المستخدمون', 'fa-users', 'admin.users.index', 'حسابات مجتمع لقيا'],
        ['items', 'إجمالي الإعلانات', 'fa-box-open', 'admin.items.index', 'مفقودات وموجودات المنصة'],
        ['resolved', 'تم استرجاعها', 'fa-hand-holding-heart', 'admin.items.index', 'أمانات عادت إلى أصحابها'],
        ['reports', 'إجمالي البلاغات', 'fa-shield-halved', 'admin.reports.index', 'متابعة وحماية المجتمع'],
    ];
@endphp
<section class="admin-overview-banner" aria-labelledby="review-heading">
    <div>
        <h2 id="review-heading">{{ $stats['pending_reports'] > 0 ? 'بلاغات تنتظر اهتمامك' : 'قائمة المراجعة محدثة' }}</h2>
        <p>@if($stats['pending_reports'] > 0) لديك {{ number_format($stats['pending_reports']) }} بلاغ قيد المراجعة. راجع التفاصيل واتخذ الإجراء المناسب للحفاظ على مجتمع آمن. @else لا توجد بلاغات معلقة حالياً. تابع إعلانات المنصة وحافظ على تجربة موثوقة للجميع. @endif</p>
    </div>
    <a href="{{ route('admin.reports.index', ['status' => 'pending']) }}" class="admin-button"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i> مراجعة البلاغات <span aria-hidden="true">←</span></a>
</section>
<section class="admin-stats-grid" aria-label="إحصاءات المنصة">
    @foreach($overviewCards as [$key, $label, $icon, $route, $hint])
        <a href="{{ route($route, $key === 'resolved' ? ['status' => 'resolved'] : []) }}" class="admin-stat">
            <div class="admin-stat-top"><span>{{ $label }}</span><span class="admin-stat-icon"><i class="fa-solid {{ $icon }}" aria-hidden="true"></i></span></div>
            <strong class="admin-stat-value">{{ number_format($stats[$key]) }}</strong>
            <span class="admin-stat-foot"><i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i> {{ $hint }}</span>
        </a>
    @endforeach
</section>
<div class="admin-analysis-grid">
    <section class="admin-panel" aria-labelledby="monthly-heading">
        <div class="admin-section-heading"><div><h2 id="monthly-heading">حركة الإعلانات</h2><p>الإعلانات المنشورة خلال آخر 6 أشهر</p></div><span class="admin-result-count">{{ number_format($monthlyItems->sum('total')) }} إعلان</span></div>
        @if($monthlyItems->sum('total') > 0)
            <div class="admin-chart-summary"><span><i class="admin-chart-dot" aria-hidden="true"></i> عدد الإعلانات المنشورة</span></div>
            <div class="admin-chart-wrap"><canvas id="monthlyChart" role="img" aria-label="حركة الإعلانات خلال آخر ستة أشهر. البيانات متاحة أسفل الرسم."></canvas></div>
            <details class="admin-data-summary"><summary>عرض بيانات الإعلانات</summary><dl>@foreach($monthlyItems as $month)<dt>{{ $month->month }}</dt><dd>{{ number_format($month->total) }} إعلان</dd>@endforeach</dl></details>
        @else
            <div class="admin-chart-fallback"><i class="fa-solid fa-chart-line" aria-hidden="true"></i><p>لا توجد إعلانات خلال هذه الفترة.</p><a href="{{ route('admin.items.index') }}" class="admin-button admin-button-secondary">استعراض الإعلانات</a></div>
        @endif
    </section>
    <section class="admin-panel" aria-labelledby="category-heading">
        <div class="admin-section-heading"><div><h2 id="category-heading">الإعلانات حسب التصنيف</h2><p>أكثر التصنيفات استخداماً · حتى 10 تصنيفات</p></div></div>
        @if($categoryStats->sum('items_count') > 0)
            <div class="admin-chart-wrap"><canvas id="categoryChart" role="img" aria-label="مقارنة أعداد الإعلانات حسب التصنيف. البيانات متاحة أسفل الرسم."></canvas></div>
            <details class="admin-data-summary"><summary>عرض بيانات التصنيفات</summary><dl>@foreach($categoryStats as $category)<dt>{{ $category->name_ar }}</dt><dd>{{ number_format($category->items_count) }} إعلان</dd>@endforeach</dl></details>
        @else
            <div class="admin-chart-fallback"><i class="fa-solid fa-layer-group" aria-hidden="true"></i><p>ستظهر المقارنة عند إضافة إعلانات للتصنيفات.</p><a href="{{ route('admin.categories.index') }}" class="admin-button admin-button-secondary">إدارة التصنيفات</a></div>
        @endif
    </section>
</div>
<div class="admin-lower-grid">
    <section class="admin-panel" aria-labelledby="impact-heading">
        <div class="admin-section-heading"><div><h2 id="impact-heading">وراء كل رقم، أمانة.</h2><p>توزيع الإعلانات وأثر المنصة في إعادة المفقودات</p></div><i class="fa-solid fa-hand-holding-heart" aria-hidden="true" style="color:var(--admin-green);font-size:24px"></i></div>
        <div class="admin-distribution"><div><span>إعلانات المفقودات</span><strong>{{ number_format($stats['lost']) }}</strong></div><div><span>إعلانات الموجودات</span><strong>{{ number_format($stats['found']) }}</strong></div><div><span>تم استرجاعها</span><strong>{{ number_format($stats['resolved']) }}</strong></div></div>
        <div class="admin-progress-track" role="progressbar" aria-label="نسبة الإعلانات المسترجعة من إجمالي الإعلانات" aria-valuenow="{{ $resolvedPercent }}" aria-valuemin="0" aria-valuemax="100"><span style="width:{{ $resolvedPercent }}%"></span></div>
        <div class="admin-progress-caption"><span>الإعلانات المسترجعة من الإجمالي</span><strong>{{ $resolvedPercent }}%</strong></div>
    </section>
    <section class="admin-panel" aria-labelledby="quick-heading">
        <div class="admin-section-heading"><div><h2 id="quick-heading">وصول سريع</h2><p>الأدوات التي تحتاجها لإدارة يومك</p></div></div>
        <div class="admin-quick-links">
            @foreach([['admin.site-reports.index', 'fa-file-excel', 'تقارير الموقع', 'إحصاءات الفترة وتصدير Excel'], ['admin.items.index', 'fa-box-open', 'إدارة الإعلانات', 'مراجعة المحتوى وتحديث حالته'], ['admin.users.index', 'fa-user-shield', 'المستخدمون والصلاحيات', 'متابعة الحسابات وإدارة الأدوار'], ['admin.categories.create', 'fa-plus', 'إضافة تصنيف', 'نظّم الإعلانات لتسهيل الوصول إليها']] as [$route, $icon, $label, $hint])
                <a href="{{ route($route) }}"><i class="fa-solid {{ $icon }}" aria-hidden="true"></i><span><strong>{{ $label }}</strong><small>{{ $hint }}</small></span><i class="fa-solid fa-chevron-left" aria-hidden="true"></i></a>
            @endforeach
        </div>
    </section>
</div>
<script type="application/json" data-admin-charts>{"months":@json($monthlyItems->pluck('month')),"monthlyTotals":@json($monthlyItems->pluck('total')),"categories":@json($categoryStats->pluck('name_ar')),"categoryTotals":@json($categoryStats->pluck('items_count'))}</script>
@endsection
