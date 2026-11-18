@extends('layouts.app')
@section('title', 'الرسائل')
@section('content')
<div class="inbox">
    <header class="inbox-header">
        <div>
            <span class="inbox-icon" aria-hidden="true"><i class="fa-regular fa-comments"></i></span>
            <h1>رسائلك</h1>
            <p>تابع التفاصيل مع أصحاب البلاغات، وكمّلوا حديثكم من هون.</p>
        </div>
        <a href="{{ route('items.index') }}" class="inbox-browse">تصفّح البلاغات <i class="fa-solid fa-arrow-left" aria-hidden="true"></i></a>
    </header>
    <section class="inbox-panel" aria-label="صندوق الوارد">
        <form method="GET" action="{{ route('conversations.index') }}" class="inbox-toolbar">
            <label class="inbox-search">
                <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                <input type="search" name="q" maxlength="120" value="{{ $q }}" aria-label="بحث باسم الشخص أو الغرض" placeholder="اسم الشخص أو الغرض…">
            </label>
            <label class="inbox-unread"><input type="checkbox" name="unread" value="1" @checked(request('unread'))> غير المقروءة</label>
            <button type="submit">بحث</button>
            @if($q !== '' || request('unread'))<a href="{{ route('conversations.index') }}">مسح</a>@endif
        </form>
        <div class="inbox-list-heading"><h2>المحادثات</h2><span>{{ $conversations->total() }} محادثة</span></div>
        @forelse($conversations as $conv)
            @php
                $other = $conv->otherUser(auth()->id());
                $latest = $conv->latestMessage;
                $item = $conv->item;
            @endphp
            <a href="{{ route('conversations.show', $conv) }}" class="inbox-conversation {{ $conv->unread_count ? 'has-unread' : '' }}">
                <span class="inbox-avatar" aria-hidden="true">
                    @if($other->avatar)<img src="{{ $other->avatarUrl() }}" alt="">@else{{ \Illuminate\Support\Str::substr($other->name, 0, 1) }}@endif
                </span>
                <div class="inbox-copy">
                    <div class="inbox-row"><strong>{{ $other->name }}</strong><time>{{ $conv->last_message_at?->diffForHumans() }}</time></div>
                    <span class="inbox-item">{{ $item?->title ?? 'بلاغ محذوف' }}</span>
                    <p>@if($latest && (int) $latest->sender_id === (int) auth()->id())<span>أنت · </span>@endif{{ $latest?->body ?? 'افتح المحادثة لتبدأ الحديث.' }}</p>
                </div>
                <div class="inbox-trailing">
                    @if($conv->unread_count)<span class="inbox-count" aria-label="{{ $conv->unread_count }} رسالة غير مقروءة">{{ $conv->unread_count }}</span>@endif
                    @if($image = $item?->images->first())<img src="{{ asset('storage/' . $image->path) }}" alt="" loading="lazy">@else<i class="fa-solid fa-chevron-left" aria-hidden="true"></i>@endif
                </div>
            </a>
        @empty
            <div class="inbox-empty">
                <i class="fa-regular fa-envelope-open" aria-hidden="true"></i>
                <h2>{{ $q || request('unread') ? 'ما في محادثات بهالاختيارات' : 'هون بتبدأ المحادثة' }}</h2>
                <p>افتح بلاغ وراسل صاحبه، وبتلاقي حديثكم هون.</p>
                <a href="{{ route('items.index') }}">شوف البلاغات</a>
            </div>
        @endforelse
        <div class="p-4">{{ $conversations->links() }}</div>
    </section>
</div>
@endsection