@extends('layouts.admin')

@section('title', 'إدارة المستخدمين')

@section('description', 'تابع الحسابات، وحدّد الأدوار والصلاحيات، وأدر حالة كل مستخدم.')

@section('content')
<x-flash-message/>
<div class="admin-resource-intro"><i class="fa-solid fa-users" aria-hidden="true"></i><div><strong>مجتمع لقيا</strong><p>تابع الحسابات، وحدّد الأدوار والصلاحيات، وأدر حالة كل مستخدم.</p></div></div>

<div class="admin-filter-panel bg-white rounded-xl shadow-sm p-4 mb-4">
    <div class="admin-section-heading"><div><h2>البحث والتصفية</h2><p>ابحث بالاسم أو البريد، أو حدّد دور المستخدم.</p></div></div>
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3">
        <div class="admin-filter-field">
            <label for="filter-q">البحث بالاسم أو البريد</label>
            <input id="filter-q" type="text" name="q" value="{{ request('q') }}" placeholder="بحث بالاسم أو البريد..."
               class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm"></div>

        <div class="admin-filter-field">
            {{-- <label for="filter-role">دور المستخدم</label>
            <select id="filter-role" name="role" class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            <option value="">كل الأدوار</option>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>{{ $role->display_name_ar }}</option>
            @endforeach
        </select> --}}
        </div>

        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-semibold text-sm transition">
            <i class="fa-solid fa-search ml-1" aria-hidden="true"></i> بحث
        </button>
        <a href="{{ route('admin.users.index') }}" class="text-center border border-gray-300 rounded-lg px-3 py-2.5 text-sm hover:bg-gray-50">
            مسح
        </a>
    </form>
</div>

<div class="admin-table-scroll bg-white rounded-xl shadow-sm overflow-hidden" role="region" aria-label="جدول المستخدمون" tabindex="0">
    <table class="w-full text-sm">
        <caption class="admin-table-caption">المستخدمون<small>{{ number_format($users->total()) }} نتيجة</small></caption>
        <thead class="bg-gray-50 text-gray-600 border-b border-gray-200">
            <tr>
                <th scope="col" class="text-right py-3 px-4">المستخدم</th>
                {{-- <th scope="col" class="text-right py-3 px-4">الدور</th> --}}
                <th scope="col" class="text-right py-3 px-4">الحالة</th>
                <th scope="col" class="text-right py-3 px-4">التاريخ</th>
                <th scope="col" class="text-right py-3 px-4">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-2">
                            <img src="{{ $user->avatarUrl() }}" class="w-8 h-8 rounded-full" alt="">
                            <div>
                                <div class="font-medium">{{ $user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    {{-- <td class="py-3 px-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            {{ $user->role?->name === 'admin' ? 'bg-purple-100 text-purple-700' : '' }}
                            {{ $user->role?->name === 'moderator' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $user->role?->name === 'user' ? 'bg-gray-100 text-gray-700' : '' }}">
                            {{ $user->role?->display_name_ar ?? '—' }}
                        </span>
                    </td> --}}
                    <td class="py-3 px-4">
                        @if($user->is_active)
                            <span class="text-green-600 text-xs"><i class="fa-solid fa-circle-check" aria-hidden="true"></i> نشط</span>
                        @else
                            <span class="text-red-600 text-xs"><i class="fa-solid fa-circle-xmark" aria-hidden="true"></i> معطّل</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 text-xs text-gray-500">{{ $user->created_at->format('Y-m-d') }}</td>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-2">
                            @canAbility('users.edit')
                            <a aria-label="تعديل" href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-700" title="تعديل">
                                <i class="fa-solid fa-pen" aria-hidden="true"></i>
                            </a>
                            @endcanAbility
                            <form method="POST" action="{{ route('admin.users.toggle', $user) }}" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="{{ $user->is_active ? 'text-yellow-600' : 'text-green-600' }} hover:opacity-70" title="{{ $user->is_active ? 'تعطيل' : 'تفعيل' }}">
                                    <i class="fa-solid {{ $user->is_active ? 'fa-ban' : 'fa-check' }}" aria-hidden="true"></i>
                                </button>
                            </form>
                            @canAbility('users.delete')
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('حذف المستخدم؟')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700" title="حذف">
                                    <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                </button>
                            </form>
                            @endcanAbility
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center py-10 text-gray-400">لا يوجد مستخدمون مطابقون. جرّب تغيير البحث أو مسح التصفية.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="flex justify-center mt-4">
    {{ $users->links() }}
</div>

@endsection
