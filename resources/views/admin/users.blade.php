@extends('layouts.admin')

@section('title', 'إدارة المستخدمين')

@section('content')

<div class="bg-white rounded-xl shadow-sm p-4 mb-4">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="بحث بالاسم أو البريد..."
               class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm">

        <select name="role" class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            <option value="">كل الأدوار</option>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>{{ $role->display_name_ar }}</option>
            @endforeach
        </select>

        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-semibold text-sm transition">
            <i class="fa-solid fa-search ml-1"></i> بحث
        </button>
        <a href="{{ route('admin.users.index') }}" class="text-center border border-gray-300 rounded-lg px-3 py-2.5 text-sm hover:bg-gray-50">
            مسح
        </a>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 border-b border-gray-200">
            <tr>
                <th class="text-right py-3 px-4">المستخدم</th>
                <th class="text-right py-3 px-4">الدور</th>
                <th class="text-right py-3 px-4">الحالة</th>
                <th class="text-right py-3 px-4">التاريخ</th>
                <th class="text-right py-3 px-4">إجراءات</th>
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
                    <td class="py-3 px-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            {{ $user->role?->name === 'admin' ? 'bg-purple-100 text-purple-700' : '' }}
                            {{ $user->role?->name === 'moderator' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $user->role?->name === 'user' ? 'bg-gray-100 text-gray-700' : '' }}">
                            {{ $user->role?->display_name_ar ?? '—' }}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        @if($user->is_active)
                            <span class="text-green-600 text-xs"><i class="fa-solid fa-circle-check"></i> نشط</span>
                        @else
                            <span class="text-red-600 text-xs"><i class="fa-solid fa-circle-xmark"></i> معطّل</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 text-xs text-gray-500">{{ $user->created_at->format('Y-m-d') }}</td>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-700" title="تعديل">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.users.toggle', $user) }}" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="{{ $user->is_active ? 'text-yellow-600' : 'text-green-600' }} hover:opacity-70" title="{{ $user->is_active ? 'تعطيل' : 'تفعيل' }}">
                                    <i class="fa-solid {{ $user->is_active ? 'fa-ban' : 'fa-check' }}"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('حذف المستخدم؟')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700" title="حذف">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center py-10 text-gray-400">لا يوجد مستخدمون</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="flex justify-center mt-4">
    {{ $users->links() }}
</div>

@endsection