@extends('layouts.app')

@section('title', 'لوحة التحكم')

@section('content')

<div class="bg-primary-600 text-white py-10">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold">مرحبًا، {{ auth()->user()->name }}</h1>
            <p class="text-white/80 mt-1">أهلاً بك في لوحة التحكم</p>
        </div>
        <a href="{{ route('items.create') }}" class="bg-white text-primary-700 hover:bg-gray-100 px-5 py-2.5 rounded-lg font-semibold transition">
            <i class="fa-solid fa-plus ml-2"></i> نشر إعلان
        </a>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- إحصائيات المستخدم --}}
    <h2 class="text-lg font-bold text-gray-900 mb-3">إحصائياتك الشخصية</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-5 text-center">
            <div class="text-3xl font-bold text-primary-600">{{ $stats['total'] }}</div>
            <div class="text-xs text-gray-500 mt-1">إجمالي الإعلانات</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 text-center">
            <div class="text-3xl font-bold text-red-500">{{ $stats['lost'] }}</div>
            <div class="text-xs text-gray-500 mt-1">مفقودات</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 text-center">
            <div class="text-3xl font-bold text-green-500">{{ $stats['found'] }}</div>
            <div class="text-xs text-gray-500 mt-1">موجودات</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 text-center">
            <div class="text-3xl font-bold text-blue-500">{{ $stats['active'] }}</div>
            <div class="text-xs text-gray-500 mt-1">نشطة</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 text-center">
            <div class="text-3xl font-bold text-emerald-500">{{ $stats['resolved'] }}</div>
            <div class="text-xs text-gray-500 mt-1">مسترجعة</div>
        </div>
        <a href="{{ route('conversations.index') }}" class="bg-white rounded-xl shadow-sm p-5 text-center hover:shadow-md transition">
            <div class="text-3xl font-bold text-accent-600">{{ $stats['unread_messages'] }}</div>
            <div class="text-xs text-gray-500 mt-1">رسائل غير مقروءة</div>
        </a>
    </div>

    {{-- إحصائيات المنصة --}}
    <h2 class="text-lg font-bold text-gray-900 mb-3">إحصائيات المنصة</h2>
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-primary-600">{{ number_format($platformStats['total_users']) }}</div>
                <div class="text-xs text-gray-500 mt-1">مستخدم</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-gray-900">{{ number_format($platformStats['total_items']) }}</div>
                <div class="text-xs text-gray-500 mt-1">إعلان نشط</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-red-500">{{ number_format($platformStats['total_lost']) }}</div>
                <div class="text-xs text-gray-500 mt-1">مفقود</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-500">{{ number_format($platformStats['total_found']) }}</div>
                <div class="text-xs text-gray-500 mt-1">موجود</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-500">{{ number_format($platformStats['total_resolved']) }}</div>
                <div class="text-xs text-gray-500 mt-1">تم استرجاعه</div>
            </div>
        </div>
    </div>

    {{-- Quick actions --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <a href="{{ route('items.create') }}" class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition text-center group">
            <div class="w-12 h-12 bg-primary-50 text-primary-600 rounded-full flex items-center justify-center mx-auto mb-2 group-hover:bg-primary-600 group-hover:text-white transition">
                <i class="fa-solid fa-plus"></i>
            </div>
            <div class="text-sm font-medium">إعلان جديد</div>
        </a>
        <a href="{{ route('conversations.index') }}" class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition text-center group">
            <div class="w-12 h-12 bg-accent-50 text-accent-600 rounded-full flex items-center justify-center mx-auto mb-2 group-hover:bg-accent-500 group-hover:text-white transition">
                <i class="fa-solid fa-envelope"></i>
            </div>
            <div class="text-sm font-medium">الرسائل</div>
        </a>
        <a href="{{ route('notifications.index') }}" class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition text-center group">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-2 group-hover:bg-blue-600 group-hover:text-white transition">
                <i class="fa-solid fa-bell"></i>
            </div>
            <div class="text-sm font-medium">الإشعارات</div>
        </a>
        <a href="{{ route('profile.edit') }}" class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition text-center group">
            <div class="w-12 h-12 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center mx-auto mb-2 group-hover:bg-gray-700 group-hover:text-white transition">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="text-sm font-medium">الملف الشخصي</div>
        </a>
    </div>

    {{-- Recent items --}}
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold">آخر إعلاناتك</h2>
            <a href="{{ route('items.index') }}" class="text-sm text-primary-600 hover:underline">عرض الكل</a>
        </div>

        @if($items->isEmpty())
            <div class="text-center py-10 text-gray-400">
                <i class="fa-solid fa-inbox text-5xl mb-3"></i>
                <p>لم تنشر أي إعلان بعد</p>
                <a href="{{ route('items.create') }}" class="inline-block mt-4 bg-primary-600 hover:bg-primary-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">
                    نشر أول إعلان
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="border-b border-gray-200 text-gray-500">
                        <tr>
                            <th class="text-right py-3 px-2">الإعلان</th>
                            <th class="text-right py-3 px-2">النوع</th>
                            <th class="text-right py-3 px-2">الحالة</th>
                            <th class="text-right py-3 px-2">التاريخ</th>
                            <th class="text-right py-3 px-2">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-3 px-2">
                                    <a href="{{ route('items.show', $item) }}" class="font-medium text-gray-900 hover:text-primary-600 line-clamp-1">
                                        {{ $item->title }}
                                    </a>
                                </td>
                                <td class="py-3 px-2">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold text-white {{ $item->type === 'lost' ? 'bg-red-500' : 'bg-green-500' }}">
                                        {{ $item->type === 'lost' ? 'مفقود' : 'موجود' }}
                                    </span>
                                </td>
                                <td class="py-3 px-2">
                                    <span class="text-xs">{{ $item->status_label }}</span>
                                </td>
                                <td class="py-3 px-2 text-gray-500 text-xs">{{ $item->created_at->format('Y-m-d') }}</td>
                                <td class="py-3 px-2">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('items.edit', $item) }}" class="text-blue-600 hover:text-blue-700">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <form method="POST" action="{{ route('items.destroy', $item) }}" onsubmit="return confirm('حذف الإعلان؟')" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection