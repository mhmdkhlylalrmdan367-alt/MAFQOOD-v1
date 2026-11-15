@extends('layouts.app')

@section('title', 'الرسائل')

@section('content')

<div class="bg-primary-600 text-white py-10">
    <div class="max-w-5xl mx-auto px-4">
        <h1 class="text-3xl font-bold">الرسائل</h1>
        <p class="text-white/80 mt-1">محادثاتك مع أصحاب الإعلانات</p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 py-8">
    @if($conversations->isEmpty())
        <div class="bg-white rounded-xl shadow-sm p-12 text-center">
            <i class="fa-solid fa-envelope-open text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">لا توجد محادثات</h3>
            <p class="text-gray-500 mb-6">عندما تراسل صاحب إعلان، ستظهر المحادثة هنا</p>
            <a href="{{ route('items.index') }}" class="inline-block bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                تصفح الإعلانات
            </a>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm overflow-hidden divide-y divide-gray-100">
            @foreach($conversations as $conv)
                @php $other = $conv->otherUser(auth()->id()); @endphp
                <a href="{{ route('conversations.show', $conv) }}" class="flex items-center gap-4 p-4 hover:bg-gray-50 transition">
                    <img src="{{ $other->avatarUrl() }}" class="w-12 h-12 rounded-full flex-shrink-0" alt="">

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-semibold text-gray-900">{{ $other->name }}</span>
                            @if($conv->last_message_at)
                                <span class="text-xs text-gray-400">{{ $conv->last_message_at->diffForHumans() }}</span>
                            @endif
                        </div>
                        <div class="text-sm text-gray-500 line-clamp-1">
                            <i class="fa-solid fa-box text-xs ml-1"></i>
                            {{ $conv->item->title }}
                        </div>
                    </div>

                    <i class="fa-solid fa-chevron-left text-gray-300"></i>
                </a>
            @endforeach
        </div>

        <div class="flex justify-center mt-6">
            {{ $conversations->links() }}
        </div>
    @endif
</div>

@endsection