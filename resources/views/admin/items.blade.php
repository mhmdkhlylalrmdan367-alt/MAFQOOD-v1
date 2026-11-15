@extends('layouts.admin')

@section('title', 'إدارة الإعلانات')

@section('content')

<div class="bg-white rounded-xl shadow-sm p-4 mb-4">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="بحث بالعنوان..."
               class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm">

        <select name="type" class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            <option value="">كل الأنواع</option>
            <option value="lost" {{ request('type') === 'lost' ? 'selected' : '' }}>مفقود</option>
            <option value="found" {{ request('type') === 'found' ? 'selected' : '' }}>موجود</option>
        </select>

        <select name="status" class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            <option value="">كل الحالات</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>نشط</option>
            <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>مسترد</option>
            <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>مغلق</option>
            <option value="hidden" {{ request('status') === 'hidden' ? 'selected' : '' }}>مخفي</option>
        </select>

        <select name="category" class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            <option value="">كل التصنيفات</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>

        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-semibold text-sm transition">
            <i class="fa-solid fa-search ml-1"></i> بحث
        </button>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 border-b border-gray-200">
            <tr>
                <th class="text-right py-3 px-4">الإعلان</th>
                <th class="text-right py-3 px-4">النوع</th>
                <th class="text-right py-3 px-4">الحالة</th>
                <th class="text-right py-3 px-4">الصاحب</th>
                <th class="text-right py-3 px-4">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="py-3 px-4">
                        <a href="{{ route('admin.items.show', $item) }}" class="font-medium hover:text-primary-600 line-clamp-1">
                            {{ $item->title }}
                        </a>
                        <div class="text-xs text-gray-500">{{ $item->category->name }}</div>
                    </td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold text-white {{ $item->type === 'lost' ? 'bg-red-500' : 'bg-green-500' }}">
                            {{ $item->type === 'lost' ? 'مفقود' : 'موجود' }}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        <span class="text-xs">{{ $item->status_label }}</span>
                    </td>
                    <td class="py-3 px-4 text-xs">{{ $item->user->name }}</td>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.items.edit', $item) }}" class="text-blue-600 hover:text-blue-700">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="{{ route('items.show', $item) }}" target="_blank" class="text-gray-600 hover:text-gray-700">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.items.destroy', $item) }}" onsubmit="return confirm('حذف الإعلان؟')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center py-10 text-gray-400">لا توجد إعلانات</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="flex justify-center mt-4">
    {{ $items->links() }}
</div>

@endsection