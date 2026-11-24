@extends('layouts.admin')

@section('title', 'إدارة الموظفين')

@section('description', 'أدر حسابات الموظفين وراجع بياناتهم وإجراءاتهم.')

@section('content')

    <x-flash-message />
    <div class="admin-resource-intro">
        <i class="fa-solid fa-users" aria-hidden="true"></i>
        <div>
            <strong>إدارة فريق العمل</strong>
            <p>أدر حسابات الموظفين وراجع بياناتهم وتاريخ تسجيلهم.</p>
        </div>
    </div>

    <div class="flex justify-end mb-4">
        @canAbility('admins.create')
        <a href="{{ route('admin.admins.create') }}"
            class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-lg font-semibold transition inline-flex items-center">
            <i class="fa-solid fa-plus ml-1" aria-hidden="true"></i>
            إضافة موظف جديد
        </a>
        @endcanAbility
    </div>

    <div class="admin-table-scroll bg-white rounded-xl shadow-sm overflow-hidden" role="region" aria-label="جدول الموظفين"
        tabindex="0">

        <table class="w-full text-sm">

            <caption class="admin-table-caption">
                الموظفون
                <small>{{ number_format($admins->total()) }} نتيجة</small>
            </caption>

            <thead class="bg-gray-50 text-gray-600 border-b border-gray-200">
                <tr>
                    <th scope="col" class="text-right py-3 px-4">#</th>
                    <th scope="col" class="text-right py-3 px-4">اسم الموظف</th>
                    <th scope="col" class="text-right py-3 px-4">البريد الإلكتروني</th>
                    <th scope="col" class="text-right py-3 px-4">تاريخ التسجيل</th>
                    <th scope="col" class="text-right py-3 px-4">الإجراءات</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($admins as $item)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">

                        <td class="py-3 px-4 text-gray-500">
                            {{ $item->id }}
                        </td>

                        <td class="py-3 px-4">
                            <div class="font-medium text-gray-800">
                                {{ $item->name }}
                            </div>
                        </td>

                        <td class="py-3 px-4 text-gray-600">
                            {{ $item->email }}
                        </td>

                        <td class="py-3 px-4 text-gray-500 text-xs">
                            {{ $item->created_at?->format('Y-m-d') ?? '—' }}
                        </td>

                        <td class="py-3 px-4">
                            <div class="flex items-center gap-3">
                                @canAbility('admins.view')
                                <a href="{{ route('admin.admins.show', $item->id) }}"
                                    class="text-primary-600 hover:text-primary-700 transition" title="عرض"
                                    aria-label="عرض الموظف">
                                    <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                </a>
                                @endcanAbility

                                @canAbility('admins.update')
                                <a href="{{ route('admin.admins.edit', $item->id) }}"
                                    class="text-blue-600 hover:text-blue-700 transition" title="تعديل"
                                    aria-label="تعديل الموظف">
                                    <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                </a>
                                @endcanAbility

                                @canAbility('admins.delete')
                                <form action="{{ route('admin.admins.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('هل أنت متأكد من حذف هذا الموظف؟')" class="inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-600 hover:text-red-700 transition" title="حذف"
                                        aria-label="حذف الموظف">
                                        <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                    </button>

                                </form>
                                @endcanAbility
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-10 text-gray-400">
                            <i class="fa-solid fa-users-slash text-2xl mb-2 block" aria-hidden="true"></i>
                            لا توجد بيانات موظفين بعد.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <div class="flex justify-center mt-4">
        {{ $admins->links() }}
    </div>

@endsection
