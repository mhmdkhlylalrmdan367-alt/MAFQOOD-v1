@extends('layouts.app')

@section('title', 'محادثة')

@section('content')

<div class="max-w-4xl mx-auto px-4 py-8">
<div class="chat-shell">

    {{-- Header --}}
    <div class="bg-white rounded-t-xl shadow-sm p-4 flex items-center gap-3 border-b border-gray-100">
        <a href="{{ route('conversations.index') }}" class="text-gray-500 hover:text-primary-600">
            <i class="fa-solid fa-arrow-right"></i>
        </a>
        @php $other = $conversation->otherUser(auth()->id()); @endphp
        <img src="{{ $other->avatarUrl() }}" class="w-10 h-10 rounded-full" alt="">
        <div class="flex-1 min-w-0">
            <div class="font-semibold text-gray-900">{{ $other->name }}</div>
            <a href="{{ route('items.show', $conversation->item) }}" class="text-xs text-primary-600 hover:underline line-clamp-1">
                <i class="fa-solid fa-box ml-1"></i> {{ $conversation->item->title }}
            </a>
        </div>
    </div>

    {{-- Messages --}}
    <div class="relative">
    <div id="messages" data-chat-url="{{ route('conversations.show', $conversation) }}" class="chat-scroll">
        @include('conversations.messages')
    </div>

    <button type="button" data-chat-latest class="chat-latest" hidden>آخر الرسائل ↓</button>
    </div>
    {{-- Input --}}
    <form method="POST" action="{{ route('messages.store', $conversation) }}"
          class="bg-white rounded-b-xl shadow-sm p-3 border-t border-gray-100 flex gap-2">
        @csrf
        <input type="text" name="body" required maxlength="2000" placeholder="اكتب رسالتك..."
               class="min-w-0 flex-1 border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none">
        <button type="submit" aria-label="إرسال الرسالة" class="bg-primary-600 hover:bg-primary-700 text-white px-5 rounded-lg font-semibold transition">
            <i class="fa-solid fa-paper-plane"></i>
        </button>
    </form>
    </div>
</div>

@push('scripts')
<script>
    const messagesDiv = document.getElementById('messages');
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
</script>
@endpush

@endsection