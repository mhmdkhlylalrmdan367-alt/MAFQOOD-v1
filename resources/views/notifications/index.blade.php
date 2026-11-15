@extends('layouts.app')

@section('title', 'الإشعارات')

@section('content')

<div class="bg-primary-600 text-white py-10">
    <div class="max-w-4xl mx-auto px-4 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold">الإشعارات</h1>
            <p class="text-white/80 mt-1">{{ $notifications->total() }} إشعار</p>
        </div>
        @if(auth()->user()->unreadNotifications->count() > 0)
            <form method="POST" action="{{ route('notifications.markAllRead') }}">
                @csrf
                <button type="submit" class="bg-white text-primary-700 hover:bg-gray-100 px-4 py-2 rounded-lg text-sm font-semibold transition">
                    <i class="fa-solid fa-check-double ml-1"></i> تعليم الكل كمقروء
                </button>
            </form>
        @endif
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 py-8">
    @if($notifications->isEmpty())
        <div class="bg-white rounded-xl shadow-sm p-12 text-center">
            <i class="fa-solid fa-bell-slash text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">لا توجد إشعارات</h3>
            <p class="text-gray-500">ستظهر الإشعارات هنا عند وصولها</p>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm divide-y divide-gray-100 overflow-hidden">
            @foreach($notifications as $notif)
                @php $data = $notif->data; @endphp
                <div class="p-4 hover:bg-gray-50 transition {{ $notif->read_at ? '' : 'bg-blue-50/50' }}">

                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0
                            {{ ($data['type'] ?? '') === 'new_message' ? 'bg-accent-100 text-accent-600' : '' }}
                            {{ ($data['type'] ?? '') === 'item_status' ? 'bg-blue-100 text-blue-600' : '' }}
                            {{ ($data['type'] ?? '') === 'report_status' ? 'bg-red-100 text-red-600' : '' }}
                        ">
                            @if(($data['type'] ?? '') === 'new_message')
                                <i class="fa-solid fa-envelope"></i>
                            @elseif(($data['type'] ?? '') === 'item_status')
                                <i class="fa-solid fa-box"></i>
                            @elseif(($data['type'] ?? '') === 'report_status')
                                <i class="fa-solid fa-flag"></i>
                            @else
                                <i class="fa-solid fa-bell"></i>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            @if(($data['type'] ?? '') === 'new_message')
                                <p class="text-sm text-gray-800">
                                    <strong>{{ $data['sender_name'] ?? 'مستخدم' }}</strong> أرسل لك رسالة جديدة
                                </p>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-1">{{ $data['body'] ?? '' }}</p>
                                <a href="{{ route('conversations.show', $data['conversation_id'] ?? 0) }}"
                                   class="inline-block text-xs text-primary-600 hover:underline mt-2">
                                    عرض المحادثة
                                </a>
                            @elseif(($data['type'] ?? '') === 'item_status')
                                <p class="text-sm text-gray-800">
                                    تم تحديث حالة إعلانك "<strong>{{ $data['title'] ?? '' }}</strong>" إلى
                                    <strong>{{ $data['status'] ?? '' }}</strong>
                                </p>
                                <a href="{{ route('items.show', $data['item_id'] ?? 0) }}"
                                   class="inline-block text-xs text-primary-600 hover:underline mt-2">
                                    عرض الإعلان
                                </a>
                            @elseif(($data['type'] ?? '') === 'report_status')
                                <p class="text-sm text-gray-800">
                                    تم تحديث حالة البلاغ رقم <strong>#{{ $data['report_id'] ?? '' }}</strong> إلى
                                    <strong>{{ $data['status'] ?? '' }}</strong>
                                </p>
                            @else
                                <p class="text-sm text-gray-800">إشعار جديد</p>
                            @endif

                            <div class="text-xs text-gray-400 mt-2">{{ $notif->created_at->diffForHumans() }}</div>
                        </div>

                        @if(!$notif->read_at)
                            <form method="POST" action="{{ route('notifications.read', $notif->id) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-primary-600 hover:text-primary-700 text-sm" title="تعليم كمقروء">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-center mt-6">
            {{ $notifications->links() }}
        </div>
    @endif
</div>

@endsection