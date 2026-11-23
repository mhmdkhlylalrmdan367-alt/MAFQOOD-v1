@extends('layouts.app')
@section('title', 'بلاغاتي')
@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-8">
    <header class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div><p class="text-sm text-brand-muted">مرحبًا {{ auth()->user()->name }}</p><h1 class="mt-1 text-3xl font-extrabold text-brand sm:text-4xl">كل بلاغاتك، بمكان واحد.</h1><p class="mt-2 text-sm text-brand-muted">تابع الردود، حدّث التفاصيل، وعلّم الغرض لما يرجع لصاحبه.</p></div>
        <a href="{{ route('items.create') }}" class="rounded-full bg-brand px-5 py-3 text-sm font-bold text-white">+ انشر بلاغ</a>
    </header>
    <div class="mb-7 grid grid-cols-2 gap-3 lg:grid-cols-4">
        @foreach([['كل بلاغاتي', $stats['total'], route('dashboard')], ['بلاغات نشطة', $stats['active'], route('dashboard', ['status' => 'active'])], ['تم استرجاعها', $stats['resolved'], route('dashboard', ['status' => 'resolved'])], ['رسائل غير مقروءة', $stats['unread_messages'], route('conversations.index', ['unread' => 1])]] as [$label, $count, $url])
            <a href="{{ $url }}" class="rounded-2xl border border-[#d5dfd1] bg-[#fffefa] p-5 transition-colors hover:bg-[#eaf2e5]"><span class="block text-3xl font-extrabold text-brand">{{ $count }}</span><span class="mt-2 block text-xs font-bold text-brand-muted">{{ $label }}</span></a>
        @endforeach
    </div>
    <div class="grid items-start gap-6 lg:grid-cols-[minmax(0,1fr)_19rem]">
        <section aria-labelledby="my-reports-title">
            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                <h2 id="my-reports-title" class="text-xl font-extrabold text-brand">بلاغاتي</h2>
                <form method="GET" action="{{ route('dashboard') }}" class="flex gap-2">
                    <select name="status" aria-label="حالة البلاغ" class="rounded-xl border border-[#cbd9cc] bg-white px-3 py-2 text-sm">
                        @foreach(['' => 'كل الحالات', 'active' => 'نشط', 'resolved' => 'تم الاسترجاع', 'closed' => 'مغلق', 'hidden' => 'مخفي'] as $value => $label)<option value="{{ $value }}" @selected(request('status', '') === $value)>{{ $label }}</option>@endforeach
                    </select>
                    <button class="rounded-xl bg-[#e3eddd] px-3 text-sm font-bold text-brand">عرض</button>
                </form>
            </div>
            <div class="grid gap-3">
                @forelse($items as $item)
                    <article class="rounded-2xl border border-[#d5dfd1] bg-[#fffefa] p-4 sm:p-5">
                        <div class="flex items-start gap-4">
                            <a href="{{ route('items.show', $item) }}" aria-label="{{ $item->title }}" class="grid size-20 shrink-0 place-items-center overflow-hidden rounded-xl bg-[#e8efe2] text-[#50836b]">
                                @if($image = $item->images->first())<img src="{{ asset('storage/'.$image->path) }}" class="size-full object-cover" alt="" loading="lazy">@else<i class="fa-solid fa-box-open" aria-hidden="true"></i>@endif
                            </a>
                            <div class="min-w-0 flex-1">
                                <div class="mb-2 flex flex-wrap gap-2 text-xs font-bold">
                                    <span class="rounded-full bg-[#e7eee2] px-2 py-1 text-brand">{{ $item->type_label }}</span>
                                    <span class="rounded-full border border-[#dedfd3] px-2 py-1 text-brand-muted">{{ $item->status_label }}</span>
                                </div>
                                <h3 class="font-extrabold text-brand-ink"><a href="{{ route('items.show', $item) }}">{{ $item->title }}</a></h3>
                                <p class="mt-1 text-xs leading-6 text-brand-muted">{{ $item->region?->name }} · نُشر {{ $item->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @if($item->images->isEmpty())<p class="mt-3 rounded-lg bg-[#f7efd9] px-3 py-2 text-xs text-[#756035]">أضف صورة واضحة حتى يسهل التعرّف على الغرض.</p>@endif
                        <div class="mt-4 flex flex-wrap items-center gap-3 border-t border-[#e6e9de] pt-3 text-sm font-bold text-brand">
                            <a href="{{ route('items.edit', $item) }}" class="rounded-lg border border-[#cbd9cc] px-3 py-2">تعديل التفاصيل</a>
                            @if($item->status === 'active')
                                <form method="POST" action="{{ route('items.status', $item) }}">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="resolved">
                                    <button class="rounded-lg bg-[#e3eddd] px-3 py-2">تم استرجاع الغرض</button>
                                </form>
                            @endif
                            <a href="{{ route('items.show', $item) }}" class="underline">عرض البلاغ</a>
                            <form method="POST" action="{{ route('items.destroy', $item) }}" onsubmit="return confirm('متأكد من حذف البلاغ؟')">
                                @csrf @method('DELETE')
                                <button class="px-2 py-2 text-xs text-[#a94736]">حذف</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <div class="rounded-2xl border border-dashed border-[#b5cbb9] bg-white p-8 text-center"><p class="font-bold text-brand-ink">ما في بلاغات بهالقسم.</p><a href="{{ route('items.create') }}" class="mt-3 inline-block text-sm text-brand underline">انشر بلاغ جديد</a></div>
                @endforelse
            </div>
            <div class="mt-5">{{ $items->links() }}</div>
        </section>
        <aside class="grid gap-4">
            <section class="rounded-2xl border border-[#d5dfd1] bg-[#fffefa] p-5">
                <div class="mb-4 flex items-center justify-between"><h2 class="font-extrabold text-brand-ink">آخر المحادثات</h2><a href="{{ route('conversations.index') }}" class="text-xs text-brand underline">الكل</a></div>
                @forelse($conversations as $conversation)
                    <a href="{{ route('conversations.show', $conversation) }}" class="block border-t border-[#e6e9de] py-3"><strong class="text-sm text-brand-ink">{{ $conversation->otherUser(auth()->id())->name }}</strong><p class="mt-1 truncate text-xs text-brand-muted">{{ $conversation->latestMessage?->body ?? 'افتح المحادثة' }}</p></a>
                @empty
                    <p class="text-sm leading-7 text-brand-muted">لما تتواصل مع صاحب بلاغ، بتظهر محادثتكم هون.</p>
                @endforelse
            </section>
            <section class="rounded-2xl bg-brand p-5 text-white">
                <h2 class="font-extrabold text-[#efd8a8]">خلّي بلاغك أوضح</h2>
                <ul class="mt-3 space-y-3 text-sm leading-7 text-[#e1eee6]"><li>صورة واضحة للغرض وعلاماته المميّزة.</li><li>المنطقة وتاريخ الفقدان أو العثور.</li><li>حدّث حالة البلاغ بعد الاسترجاع.</li></ul>
                <a href="{{ route('profile.edit') }}" class="mt-4 inline-block text-sm font-bold underline">إعدادات حسابي</a>
            </section>
        </aside>
    </div>
</div>
@endsection