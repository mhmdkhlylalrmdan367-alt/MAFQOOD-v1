@extends('layouts.admin')

@section('title', 'إدارة التصنيفات')

@section('description', 'أدر تصنيفات الإعلانات وترتيبها لتسهيل العثور على المفقودات.')

@section('content')
<x-flash-message/>
<div class="admin-resource-intro"><i class="fa-solid fa-layer-group" aria-hidden="true"></i><div><strong>تنظيم يجعل الوصول أسهل</strong><p>أدر تصنيفات الإعلانات وترتيبها لتسهيل العثور على المفقودات.</p></div></div>

<div class="flex justify-end mb-4">
    @canAbility('categories.create')
        <a href="{{ route('admin.categories.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-lg font-semibold transition">
            <i class="fa-solid fa-plus ml-1" aria-hidden="true"></i> تصنيف جديد
        </a>
    @endcanAbility
</div>


<div class="admin-table-scroll bg-white rounded-xl shadow-sm overflow-hidden" role="region" aria-label="جدول التصنيفات" tabindex="0">
    <table class="w-full text-sm">
        <caption class="admin-table-caption">التصنيفات<small>{{ number_format($categories->total()) }} نتيجة</small></caption>
        <thead class="bg-gray-50 text-gray-600 border-b border-gray-200">
            <tr>
                <th scope="col" class="text-right py-3 px-4">الأيقونة</th>
                <th scope="col" class="text-right py-3 px-4">الاسم</th>
                <th scope="col" class="text-right py-3 px-4">Slug</th>
                <th scope="col" class="text-right py-3 px-4">عدد الإعلانات</th>
                <th scope="col" class="text-right py-3 px-4">الحالة</th>
                <th scope="col" class="text-right py-3 px-4">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $cat)
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="py-3 px-4">
                        <div class="w-10 h-10 bg-primary-50 text-primary-600 rounded-full flex items-center justify-center">
                            <i class="fa-solid {{ $cat->icon ?? 'fa-box' }}" aria-hidden="true"></i>
                        </div>
                    </td>
                    <td class="py-3 px-4">
                        <div class="font-medium">{{ $cat->name_ar }}</div>
                        <div class="text-xs text-gray-500">{{ $cat->name_en }}</div>
                    </td>
                    <td class="py-3 px-4 text-xs text-gray-500 font-mono">{{ $cat->slug }}</td>
                    <td class="py-3 px-4 text-xs">{{ $cat->items_count }}</td>
                    <td class="py-3 px-4">
                        @if($cat->is_active)
                            <span class="text-green-600 text-xs"><i class="fa-solid fa-circle-check" aria-hidden="true"></i> نشط</span>
                        @else
                            <span class="text-red-600 text-xs"><i class="fa-solid fa-circle-xmark" aria-hidden="true"></i> معطّل</span>
                        @endif
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-2">
                            @canAbility('categories.update')
                                <a href="{{ route('admin.categories.edit', $cat) }}" class="text-blue-600 hover:text-blue-700" aria-label="تعديل">
                                    <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                </a>
                            @endcanAbility
                            @canAbility('categories.delete')
                                <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" onsubmit="return confirm('حذف التصنيف؟')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700" aria-label="حذف">
                                        <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                    </button>
                                </form>
                            @endcanAbility
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center py-10 text-gray-400">لا توجد تصنيفات بعد. أضف أول تصنيف من زر «تصنيف جديد».</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="flex justify-center mt-4">
    {{ $categories->links() }}
</div>

@endsection
