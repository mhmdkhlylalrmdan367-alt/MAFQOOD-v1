@extends('layouts.app')

@section('title', 'محادثة')

@section('content')

<div class="max-w-4xl mx-auto px-4 py-8">

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
    <div id="messages" class="bg-gray-50 shadow-sm p-4 h-[500px] overflow-y-auto space-y-3">
        @forelse($messages as $msg)
            @php $isMine = $msg->sender_id === auth()->id(); @endphp
            <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[75%]">
                    <div class="px-4 py-2.5 rounded-2xl {{ $isMine ? 'bg-primary-600 text-white rounded-br-sm' : 'bg-white text-gray-800 rounded-bl-sm shadow-sm' }}">
                        {{ $msg->body }}
                    </div>
                    <div class="text-xs text-gray-400 mt-1 {{ $isMine ? 'text-left' : 'text-right' }}">
                        {{ $msg->created_at->format('H:i') }}
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-400 py-10">
                <i class="fa-solid fa-comments text-4xl mb-3"></i>
                <p>لا توجد رسائل بعد — ابدأ المحادثة</p>
            </div>
        @endforelse
    </div>

    {{-- Input --}}
    <form method="POST" action="{{ route('messages.store', $conversation) }}"
          class="bg-white rounded-b-xl shadow-sm p-3 border-t border-gray-100 flex gap-2">
        @csrf
        <input type="text" name="body" required autofocus placeholder="اكتب رسالتك..."
               class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none">
        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-5 rounded-lg font-semibold transition">
            <i class="fa-solid fa-paper-plane"></i>
        </button>
    </form>
</div>

@push('scripts')
<script>
    const messagesDiv = document.getElementById('messages');
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
</script>
@endpush

@endsection