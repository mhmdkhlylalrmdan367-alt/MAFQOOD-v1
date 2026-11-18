@extends('layouts.app')

@section('title', 'تصفّح البلاغات')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-8 sm:py-12">
    <header class="mb-6 rounded-3xl bg-brand px-6 py-7 text-white sm:px-9">
        <h1 class="text-3xl font-extrabold sm:text-4xl">تصفّح البلاغات</h1>
        <p class="mt-2 text-sm text-[#e1eee6]">ابحث باسم الغرض أو وصفه، وحدّد المنطقة والتاريخ لتضيّق النتائج.</p>
    </header>

    @php
        $fields = [
            'type' => ['نوع البلاغ', ['' => 'الكل', 'lost' => 'مفقود', 'found' => 'موجود']],
            'region' => ['المنطقة', ['' => 'كل المناطق'] + $regions->pluck('name', 'id')->all()],
            'category' => ['الفئة', ['' => 'كل الفئات'] + $categories->pluck('name', 'id')->all()],
            'status' => ['حالة البلاغ', ['active' => 'نشط', 'resolved' => 'تم الاسترجاع', 'closed' => 'مغلق', 'all' => 'كل الحالات']],
            'sort' => ['الترتيب', ['latest' => 'أحدث نشرًا', 'event_latest' => 'أحدث فقدان أو عثور', 'oldest' => 'أقدم نشرًا']],
        ];
        $inputClass = 'min-h-11 w-full rounded-xl border border-[#ccd8ce] bg-[#fffefa] px-3 py-2 text-sm text-brand-ink focus:border-brand-focus focus:outline-2 focus:outline-brand-focus';
    @endphp

    <form method="GET" action="{{ route('items.index') }}" class="mb-7 rounded-2xl border border-[#dedfd3] bg-white p-4 sm:p-6">
        @if($filterErrors->any())
            <ul role="alert" class="mb-4 rounded-xl bg-red-50 p-3 text-sm text-red-800">
                @foreach($filterErrors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        @endif

        <label class="mb-4 block text-sm font-bold text-brand">
            <span class="mb-1.5 block">كلمة البحث</span>
            <input type="search" name="q" maxlength="120" value="{{ $q }}" placeholder="مثلاً: حقيبة سوداء أو مفاتيح سيارة" class="{{ $inputClass }}">
        </label>

        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($fields as $key => [$label, $options])
                <label class="text-sm font-bold text-brand">
                    <span class="mb-1.5 block">{{ $label }}</span>
                    <select name="{{ $key }}" class="{{ $inputClass }}">
                        @foreach($options as $value => $option)
                            <option value="{{ $value }}" @selected((string) ($filters[$key] ?? array_key_first($options)) === (string) $value)>{{ $option }}</option>
                        @endforeach
                    </select>
                </label>
            @endforeach
            @foreach(['date_from' => 'تاريخ الفقدان أو العثور من', 'date_to' => 'تاريخ الفقدان أو العثور إلى'] as $key => $label)
                <label class="text-sm font-bold text-brand">
                    <span class="mb-1.5 block">{{ $label }}</span>
                    <input type="date" name="{{ $key }}" value="{{ $filters[$key] ?? '' }}" class="{{ $inputClass }}">
                </label>
            @endforeach
        </div>

        <div class="mt-5 flex flex-wrap items-center gap-4">
            <button type="submit" class="min-h-11 rounded-full bg-brand px-6 text-sm font-bold text-white hover:bg-brand-hover">عرض النتائج</button>
            <a href="{{ route('items.index') }}" class="text-sm font-bold text-brand underline">مسح الفلاتر</a>
        </div>
    </form>

    @unless($filterErrors->any())
        <h2 class="mb-4 text-xl font-extrabold text-brand">{{ $items->total() }} نتيجة @if($q !== '') عن «{{ $q }}» @endif</h2>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 lg:gap-6">
            @forelse($items as $item)
                <x-item-card :item="$item" :show-event-date="true" />
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-[#adc4b8] bg-[#fffefa] p-8 text-center">
                    <p class="font-bold text-brand">ما لقينا بلاغات بهالاختيارات.</p>
                    <p class="mt-2 text-sm text-brand-muted">جرّب كلمة أقصر أو وسّع المنطقة والفترة.</p>
                    <a href="{{ route('items.index') }}" class="mt-3 inline-block text-sm font-bold text-brand underline">عرض كل البلاغات النشطة</a>
                </div>
            @endforelse
        </div>
        <div class="mt-7">{{ $items->links() }}</div>
    @endunless
</div>
@endsection

