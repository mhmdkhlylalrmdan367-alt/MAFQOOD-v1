<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Item;
use App\Models\Report;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class SiteReport
{
    public function __construct(
        public readonly CarbonImmutable $from,
        public readonly CarbonImmutable $to,
    ) {}

    private function duringPeriod(Builder $query): Builder
    {
        return $query->where('created_at', '>=', $this->from->startOfDay())
            ->where('created_at', '<', $this->to->addDay()->startOfDay());
    }

    public function items(): Builder
    {
        return $this->duringPeriod(Item::query());
    }

    public function summary(): array
    {
        $items = $this->items()->selectRaw("COUNT(*) AS total,
            SUM(CASE WHEN type = 'lost' THEN 1 ELSE 0 END) AS lost,
            SUM(CASE WHEN type = 'found' THEN 1 ELSE 0 END) AS found,
            SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) AS resolved,
            SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) AS active,
            SUM(CASE WHEN status = 'hidden' THEN 1 ELSE 0 END) AS hidden,
            SUM(CASE WHEN status = 'closed' THEN 1 ELSE 0 END) AS closed,
            COALESCE(SUM(views_count), 0) AS views")->first();

        $reports = $this->duringPeriod(Report::query())->selectRaw("COUNT(*) AS total,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS pending,
            SUM(CASE WHEN status = 'reviewed' THEN 1 ELSE 0 END) AS reviewed,
            SUM(CASE WHEN status = 'accepted' THEN 1 ELSE 0 END) AS accepted,
            SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) AS rejected")->first();

        return [
            'users' => $this->duringPeriod(User::query())->count(),
            'items' => (int) $items->total,
            'lost' => (int) $items->lost,
            'found' => (int) $items->found,
            'resolved' => (int) $items->resolved,
            'active' => (int) $items->active,
            'hidden' => (int) $items->hidden,
            'closed' => (int) $items->closed,
            'views' => (int) $items->views,
            'reports' => (int) $reports->total,
            'pending_reports' => (int) $reports->pending,
            'reviewed_reports' => (int) $reports->reviewed,
            'accepted_reports' => (int) $reports->accepted,
            'rejected_reports' => (int) $reports->rejected,
        ];
    }

    public function categories(): Collection
    {
        return Category::query()->withCount([
            'items' => fn (Builder $query) => $this->duringPeriod($query),
            'items as resolved_count' => fn (Builder $query) => $this->duringPeriod($query)->where('status', 'resolved'),
        ])->orderByDesc('items_count')->get();
    }

    public function sheets(array $summary, Collection $categories): iterable
    {
        yield 'الملخص العام' => $this->summaryRows($summary);
        yield 'التصنيفات' => (function () use ($categories) {
            yield ['التصنيف', 'الإعلانات المنشورة في الفترة', 'المسترجعة حالياً'];
            foreach ($categories as $category) {
                yield [$category->name_ar, $category->items_count, $category->resolved_count];
            }
        })();
        yield 'الإعلانات' => (function () {
            yield ['رقم الإعلان', 'العنوان', 'التصنيف', 'المنطقة', 'النوع', 'الحالة الحالية', 'إجمالي المشاهدات', 'تاريخ النشر'];
            foreach ($this->items()->with(['category', 'region'])->lazyById(500) as $item) {
                yield [
                    $item->id, $item->title, $item->category?->name_ar ?? 'بدون تصنيف',
                    $item->region?->name_ar ?? 'غير محددة', $item->type === 'lost' ? 'مفقود' : 'موجود',
                    ['active' => 'نشط', 'resolved' => 'تم الاسترجاع', 'hidden' => 'مخفي', 'closed' => 'مغلق'][$item->status] ?? $item->status,
                    $item->views_count, $item->created_at->format('Y-m-d H:i'),
                ];
            }
        })();
    }

    private function summaryRows(array $summary): iterable
    {
        yield ['المؤشر', 'القيمة'];
        yield ['بداية الفترة', $this->from->toDateString()];
        yield ['نهاية الفترة (شاملة)', $this->to->toDateString()];
        yield ['وقت إنشاء التقرير', now()->format('Y-m-d H:i')];
        foreach ([
            'users' => 'المستخدمون المسجلون في الفترة', 'items' => 'الإعلانات المنشورة في الفترة',
            'lost' => 'المفقودات', 'found' => 'الموجودات', 'resolved' => 'المسترجعة حالياً',
            'active' => 'الإعلانات النشطة حالياً', 'hidden' => 'الإعلانات المخفية حالياً', 'closed' => 'الإعلانات المغلقة حالياً',
            'views' => 'إجمالي مشاهدات إعلانات الفترة', 'reports' => 'البلاغات الواردة في الفترة',
            'pending_reports' => 'البلاغات المعلقة حالياً', 'reviewed_reports' => 'البلاغات المراجعة حالياً',
            'accepted_reports' => 'البلاغات المقبولة حالياً', 'rejected_reports' => 'البلاغات المرفوضة حالياً',
        ] as $key => $label) {
            yield [$label, $summary[$key]];
        }
        yield ['نطاق التقرير', 'الفترة بحسب تاريخ الإنشاء. الحالات والمشاهدات بقيمها الحالية. لا يشمل الإعلانات المحذوفة.'];
    }
}
