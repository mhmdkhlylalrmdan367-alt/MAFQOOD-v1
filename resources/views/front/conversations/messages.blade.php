@forelse($messages as $msg)
    @php $isMine = (int) $msg->sender_id === (int) auth()->id(); @endphp
    <div class="chat-row {{ $isMine ? 'chat-row--mine' : '' }}" data-message-id="{{ $msg->id }}">
        <div class="chat-message">
            <span class="chat-author">{{ $isMine ? 'أنت' : $other->name }}</span>
            <div class="chat-bubble" dir="auto">{{ $msg->body }}</div>
            <div class="chat-meta">
                <time datetime="{{ $msg->created_at->toIso8601String() }}">{{ $msg->created_at->format('H:i') }}</time>
                @if($isMine)
                    <span class="{{ $msg->read_at ? 'chat-read' : '' }}"><i class="fa-solid {{ $msg->read_at ? 'fa-check-double' : 'fa-check' }}" aria-hidden="true"></i> {{ $msg->read_at ? 'تمت القراءة' : 'تم الإرسال' }}</span>
                @endif
            </div>
        </div>
    </div>
@empty
    <p class="py-10 text-center text-sm text-gray-500">ابدأ المحادثة برسالة.</p>
@endforelse
