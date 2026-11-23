@extends('layouts.app')

@section('title', 'الرئيسية')

@section('content')

{{-- Hero --}}
<section class="home-hero text-white">
    <div class="home-hero-layout max-w-7xl mx-auto px-6">
        <div class="home-hero-copy">
            <p class="home-hero-eyebrow"><span></span> كل ضايع إله لُقيا</p>
            <h1>مفقودك يمكن يكون <em>قريبًا منك</em></h1>
            <p class="home-hero-description">
                ابحث بين البلاغات القريبة منك، أو ساعد شخصًا يرجع له شيء فقده. ابدأ بالبحث أو أضف بلاغك خلال دقائق.
            </p>

            <form action="{{ route('search') }}" method="GET" class="home-search-form">
                <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                <input type="text" name="q" aria-label="ابحث عن مفقود أو موجود" data-hero-search placeholder="ماذا تبحث عنه؟ حقيبة">
                <button type="submit">ابحث الآن</button>
            </form>

            <div class="home-hero-actions">
                <a href="{{ route('items.create', ['type' => 'lost']) }}" class="home-hero-button home-hero-button--light">
                    <i class="fa-solid fa-magnifying-glass-location" aria-hidden="true"></i>
                    بلّغ عن مفقود
                </a>
                <a href="{{ route('items.create', ['type' => 'found']) }}" class="home-hero-button home-hero-button--outline">
                    <i class="fa-solid fa-hand-holding-heart" aria-hidden="true"></i>
                    وجدت شيئًا
                </a>
            </div>
        </div>

        <div class="home-hero-art" aria-hidden="true">
            <div class="home-map-lines">
                <svg viewBox="0 0 600 520" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M29 144C111 92 168 102 226 140C284 178 314 213 383 198C451 183 497 128 578 144" />
                    <path d="M10 203C88 161 157 164 206 199C265 241 307 273 378 256C455 237 513 192 592 207" />
                    <path d="M18 271C91 230 151 226 207 260C273 301 322 342 395 323C468 305 525 258 590 278" />
                    <path d="M48 339C112 307 162 299 218 329C280 362 330 404 402 389C465 376 518 337 565 353" />
                    <path d="M120 34C126 107 131 161 173 215C220 276 231 330 211 482" />
                    <path d="M221 18C225 95 241 153 284 207C328 262 337 316 319 495" />
                    <path d="M390 23C376 99 373 158 411 214C450 271 460 331 431 490" />
                    <path d="M485 53C463 126 467 186 500 233C535 282 546 331 520 449" />
                </svg>
            </div>
            <div class="home-radar-ring"></div>
            <div class="home-map-pin home-map-pin--one"><i class="fa-solid fa-location-dot"></i></div>
            <div class="home-map-pin home-map-pin--two"><i class="fa-solid fa-location-dot"></i></div>
            <div class="home-found-object-stack">
                <div class="home-found-object-card home-found-object-card--one">
                    <div class="home-key-art"><i class="fa-solid fa-key"></i></div>
                    <div class="home-found-object-copy">
                        <span>بلاغ جديد بالقرب منك</span>
                        <strong>مفاتيح منزل</strong>
                        <small><i class="fa-solid fa-location-dot"></i> على بُعد دقائق</small>
                    </div>
                    <span class="home-found-card-badge">موجود</span>
                </div>
                <div class="home-found-object-card home-found-object-card--two">
                    <div class="home-key-art"><i class="fa-solid fa-wallet"></i></div>
                    <div class="home-found-object-copy">
                        <span>بلاغ قريب منك</span>
                        <strong>محفظة جلدية</strong>
                        <small><i class="fa-solid fa-location-dot"></i> قرب الحي</small>
                    </div>
                    <span class="home-found-card-badge home-found-card-badge--lost">مفقود</span>
                </div>
                <div class="home-found-object-card home-found-object-card--three">
                    <div class="home-key-art"><i class="fa-solid fa-bag-shopping"></i></div>
                    <div class="home-found-object-copy">
                        <span>تم العثور على غرض</span>
                        <strong>حقيبة صغيرة</strong>
                        <small><i class="fa-solid fa-location-dot"></i> أُضيفت اليوم</small>
                    </div>
                    <span class="home-found-card-badge">موجود</span>
                </div>
            </div>
            <div class="home-search-sweep"><i class="fa-solid fa-magnifying-glass-location"></i></div>
        </div>
    </div>
</section>

{{-- Latest reports --}}
@php
    $recentReports = $latestLost->concat($latestFound)
        ->sortBy([['created_at', 'desc'], ['id', 'desc']])
        ->take(8);
@endphp

<section class="report-strip" aria-labelledby="report-strip-title" data-report-strip>
    <header class="report-strip-header">
        <h2 id="report-strip-title">آخر البلاغات</h2>
        <a href="{{ route('items.index') }}" class="report-strip-all">
            عرض كل البلاغات <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
        </a>
    </header>

    @if($recentReports->isNotEmpty())
        <ul class="report-strip-track" id="recent-reports" data-report-track data-count="{{ $recentReports->count() }}">
            @foreach($recentReports as $item)
                <li>
                    <a href="{{ route('items.show', $item) }}" class="report-strip-card">
                        <span class="report-strip-photo" aria-hidden="true">
                            @if($image = $item->images->first())
                                <img src="{{ asset('storage/' . $image->path) }}" alt="" loading="lazy">
                            @else
                                <i class="fa-solid fa-box-open"></i>
                            @endif
                        </span>
                        <span class="report-strip-copy">
                            <span @class(['report-strip-badge', 'is-lost' => $item->type === 'lost'])>{{ $item->type_label }}</span>
                            <strong>{{ $item->title }}</strong>
                            @if($item->region)
                                <span class="report-strip-region">
                                    <i class="fa-solid fa-location-dot" aria-hidden="true"></i> {{ $item->region->name }}
                                </span>
                            @endif
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <div class="report-strip-empty">
            <p>لسّا ما في بلاغات منشورة.</p>
            <a href="{{ route('items.create') }}">انشر أول بلاغ</a>
        </div>
    @endif
</section>

{{-- Categories --}}
<section aria-labelledby="home-category-title" class="home-section--soft py-10 sm:py-14">
    <div class="mx-auto max-w-7xl px-4 sm:px-8">
        <div class="mb-5 flex flex-wrap items-end justify-between gap-3">
            <div>
                <h2 id="home-category-title" class="text-2xl font-extrabold text-brand sm:text-3xl">شو عم تدوّر عليه؟</h2>
                <p class="mt-1 text-sm text-brand-muted">اختار فئة لتشوف البلاغات المرتبطة فيها.</p>
            </div>
            <a href="{{ route('items.index') }}" class="rounded-full border border-[#b9cec3] bg-white px-4 py-2 text-sm font-bold text-brand hover:bg-[#e4efe8] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-focus">
                كل البلاغات
            </a>
        </div>

        <ul class="grid grid-cols-2 gap-2.5 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
            @forelse($categories as $category)
                <li>
                    <a href="{{ route('items.index', ['category' => $category->id]) }}"
                       class="group flex h-full min-h-14 items-center gap-2 rounded-xl border border-[#dddcd1] bg-[#fffefa] px-2.5 py-2 text-sm font-bold text-brand-ink transition-colors hover:border-[#80a999] hover:bg-[#f5faf6] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-focus">
                        <span class="grid size-8 shrink-0 place-items-center rounded-lg bg-[#e4efe8] text-[#276454] transition-colors group-hover:bg-brand group-hover:text-white" aria-hidden="true">
                            <i class="fa-solid {{ $category->icon ?? 'fa-box' }}"></i>
                        </span>
                        <span class="min-w-0 flex-1">{{ $category->name }}</span>
                        <span class="shrink-0 rounded-full bg-[#f0f1eb] px-1.5 py-0.5 text-xs tabular-nums text-brand-muted" aria-label="{{ $category->items_count }} بلاغ">{{ $category->items_count }}</span>
                    </a>
                </li>
            @empty
                <li class="col-span-full rounded-xl border border-dashed border-[#b9cec3] p-4 text-sm text-brand-muted">ما في فئات متاحة حاليًا.</li>
            @endforelse
        </ul>
    </div>
</section>

{{-- Browse reports --}}
@php
    $reportTabs = ['all' => 'الكل', 'lost' => 'المفقودات', 'found' => 'الموجودات'];
    $requestedType = request()->query('reports');
    $selectedType = is_string($requestedType) && isset($reportTabs[$requestedType]) ? $requestedType : 'all';
    $displayReports = match ($selectedType) {
        'lost' => $latestLost,
        'found' => $latestFound,
        default => $recentReports->take(6),
    };
    $browseUrl = route('items.index', $selectedType === 'all' ? [] : ['type' => $selectedType]);
@endphp

<section id="browse-reports" aria-labelledby="browse-reports-title" class="scroll-mt-24 py-12 sm:py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-8">
        <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
            <div>
                <h2 id="browse-reports-title" class="text-3xl font-extrabold text-brand sm:text-4xl">تصفّح البلاغات</h2>
                <p class="mt-2 text-sm text-brand-muted">شوف الأغراض المفقودة والموجودة، وافتح أي بلاغ لتعرف تفاصيله.</p>
            </div>
            <nav aria-label="تصفية البلاغات حسب النوع" class="flex flex-wrap gap-1 rounded-2xl border border-[#dfdfd3] bg-[#eeefe6] p-1">
                @foreach($reportTabs as $type => $label)
                    <a href="{{ route('home', $type === 'all' ? [] : ['reports' => $type]) }}#browse-reports"
                       @if($selectedType === $type) aria-current="true" @endif
                       @class(['rounded-xl px-3 py-2.5 text-sm font-bold transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-focus',
                           'bg-brand text-white shadow-sm' => $selectedType === $type,
                           'text-[#275347] hover:bg-white' => $selectedType !== $type])>{{ $label }}</a>
                @endforeach
            </nav>
        </div>

        @if($displayReports->isNotEmpty())
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 lg:gap-6">
                @foreach($displayReports as $item)
                    <x-item-card :item="$item" :show-event-date="true" />
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-[#adc4b8] bg-[#fffefa] p-8 text-center">
                <i class="fa-solid fa-box-open text-xl text-[#276454]" aria-hidden="true"></i>
                <p class="mt-3 font-bold text-brand">لسّا ما في بلاغات بهالقسم.</p>
                <a href="{{ route('items.create', $selectedType === 'all' ? [] : ['type' => $selectedType]) }}" class="mt-3 inline-block text-sm font-bold text-brand underline">انشر بلاغ</a>
            </div>
        @endif

        <div class="mt-7 flex justify-center">
            <a href="{{ $browseUrl }}" class="inline-flex min-h-11 items-center gap-2 rounded-full border border-[#b9cec3] bg-[#fffefa] px-5 text-sm font-bold text-brand hover:bg-[#e4efe8] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-focus">
                {{ match ($selectedType) { 'lost' => 'عرض كل المفقودات', 'found' => 'عرض كل الموجودات', default => 'عرض كل البلاغات' } }}
                <i class="fa-solid fa-arrow-left rtl:rotate-0 ltr:rotate-180" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</section>

{{-- How it works --}}
<section aria-labelledby="home-guide-title" class="pb-12 sm:pb-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-8">
        <div class="rounded-3xl border border-[#315849] bg-brand p-5 text-white sm:p-9">
            <h2 id="home-guide-title" class="text-2xl font-extrabold sm:text-3xl">كيف بتشتغل لُقيا الشام؟</h2>
            <ol class="mt-5 grid gap-3 md:grid-cols-3">
                @foreach([
                    ['fa-magnifying-glass', 'ابحث أو انشر', 'فتّش بالبلاغات، أو أضف وصف الغرض وصورة إذا عندك.'],
                    ['fa-comments', 'تواصل داخل الموقع', 'راسل صاحب البلاغ واتأكد من تفاصيل الغرض.'],
                    ['fa-handshake', 'اتفقوا على التسليم', 'اختاروا مكان عام ومناسب ليرجع الغرض لصاحبه.'],
                ] as [$icon, $title, $description])
                    <li class="rounded-2xl border border-white/15 bg-white/5 p-4">
                        <span class="grid size-10 place-items-center rounded-xl bg-[#f2e2be] text-brand" aria-hidden="true">
                            <i class="fa-solid {{ $icon }}"></i>
                        </span>
                        <h3 class="mt-3 font-extrabold">{{ $title }}</h3>
                        <p class="mt-1 text-sm leading-7 text-[#e1eee6]">{{ $description }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
</section>

{{-- CTA --}}
<section aria-labelledby="home-cta-title" class="border-t border-[#e3dfd0] bg-[#eeeade]">
    <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 py-9 sm:px-8 sm:py-12 lg:flex-row lg:items-center lg:justify-between">
        <div class="flex items-start gap-4">
            <span class="hidden size-14 shrink-0 place-items-center rounded-2xl border border-[#d9ccac] bg-[#f9f4e7] text-xl text-brand sm:grid" aria-hidden="true">
                <i class="fa-solid fa-hand-holding-heart"></i>
            </span>
            <div>
                <h2 id="home-cta-title" class="text-2xl font-extrabold text-brand sm:text-3xl">ضاع منك غرض أو لقيت شي؟</h2>
                <p class="mt-2 max-w-xl text-sm leading-7 text-brand-muted">أضف بلاغًا بالوصف والمنطقة لتسهّل على الناس التعرّف على الغرض.</p>
            </div>
        </div>
        <div class="flex shrink-0 flex-wrap gap-2.5">
            <a href="{{ route('items.create') }}" class="inline-flex min-h-11 items-center gap-2 rounded-full bg-brand px-5 text-sm font-bold text-white hover:bg-brand-hover focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-focus">
                <i class="fa-solid fa-plus" aria-hidden="true"></i> نشر بلاغ
            </a>
            <a href="{{ route('items.index') }}" class="inline-flex min-h-11 items-center rounded-full border border-[#a9b8aa] bg-[#fffefa] px-5 text-sm font-bold text-brand hover:bg-[#e4efe8] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-focus">
                تصفّح البلاغات
            </a>
        </div>
    </div>
</section>

@endsection