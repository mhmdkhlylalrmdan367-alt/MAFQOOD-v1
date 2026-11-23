@extends('layouts.admin')

@section('title', 'تعديل مستخدم')

@section('description', 'حدّث بيانات الحساب والدور الممنوح له، ثم احفظ التغييرات.')

@section('content')

<div class="max-w-2xl">
    <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:text-primary-600 mb-4 inline-block">
        <i class="fa-solid fa-arrow-right ml-1" aria-hidden="true"></i> العودة للمستخدمين
    </a>

    @if($errors->any())
        <div role="alert" tabindex="-1" data-admin-errors class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="bg-white rounded-xl shadow-sm p-6 space-y-4">
        @csrf @method('PUT')
        <div class="admin-form-title"><h2>بيانات المستخدم وصلاحياته</h2><p>حدّث بيانات الحساب والدور الممنوح له، ثم احفظ التغييرات.</p></div>

        <div class="flex items-center gap-4 pb-4 border-b border-gray-100">
            <img src="{{ $user->avatarUrl() }}" class="w-16 h-16 rounded-full" alt="">
            <div>
                <div class="font-semibold text-gray-900">{{ $user->name }}</div>
                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                <div class="text-xs text-gray-400 mt-1">عضو منذ {{ $user->created_at->format('Y-m-d') }}</div>
            </div>
        </div>

        <div>
            <label for="admin-name" class="block text-sm font-medium text-gray-700 mb-1">الاسم *</label>
            <input id="admin-name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none" @if($errors->has('name')) aria-invalid="true" aria-describedby="admin-name-error" @endif>
            @error('name')<p id="admin-name-error" class="admin-field-error">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="admin-email" class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني *</label>
            <input id="admin-email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none" @if($errors->has('email')) aria-invalid="true" aria-describedby="admin-email-error" @endif dir="ltr">
            @error('email')<p id="admin-email-error" class="admin-field-error">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="admin-phone" class="block text-sm font-medium text-gray-700 mb-1">رقم الهاتف</label>
            <input id="admin-phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none" @if($errors->has('phone')) aria-invalid="true" aria-describedby="admin-phone-error" @endif dir="ltr">
            @error('phone')<p id="admin-phone-error" class="admin-field-error">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="admin-role_id" class="block text-sm font-medium text-gray-700 mb-1">الدور *</label>
            <select id="admin-role_id" name="role_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5" @if($errors->has('role_id')) aria-invalid="true" aria-describedby="admin-role_id-error" @endif>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                        {{ $role->display_name_ar }}
                    </option>
                @endforeach
            </select>
            @error('role_id')<p id="admin-role_id-error" class="admin-field-error">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                <span class="text-sm">الحساب نشط</span>
            </label>
        </div>

        <div class="flex gap-3 pt-4 border-t border-gray-100">
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-6 py-2.5 rounded-lg transition">
                <i class="fa-solid fa-check ml-2" aria-hidden="true"></i> حفظ
            </button>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-lg transition">
                إلغاء
            </a>
        </div>
    </form>
</div>

@endsection