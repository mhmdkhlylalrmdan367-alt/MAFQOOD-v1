@extends('layouts.app')

@section('title', 'الملف الشخصي')

@section('content')

<div class="bg-primary-600 text-white py-10">
    <div class="max-w-3xl mx-auto px-4">
        <h1 class="text-3xl font-bold">الملف الشخصي</h1>
        <p class="text-white/80 mt-1">إدارة بياناتك الشخصية</p>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 py-8 space-y-6">

    {{-- Profile info --}}
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-bold mb-4">البيانات الشخصية</h2>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')

            <div class="flex items-center gap-4">
                <img src="{{ auth()->user()->avatarUrl() }}" class="w-20 h-20 rounded-full object-cover" alt="">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">تغيير الصورة</label>
                    <input type="file" name="avatar" accept="image/*"
                           class="text-sm border border-gray-300 rounded-lg px-3 py-1.5">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">الاسم *</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني</label>
                <input type="email" value="{{ auth()->user()->email }}" disabled
                       class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-2.5 text-gray-500">
                <p class="text-xs text-gray-400 mt-1">لا يمكن تغيير البريد الإلكتروني حاليًا</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">رقم الهاتف</label>
                <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">المنطقة</label>
                <select name="region_id" class="w-full border border-gray-300 rounded-lg px-3 py-2.5">
                    <option value="">اختر المنطقة</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}" {{ old('region_id', auth()->user()->region_id) == $region->id ? 'selected' : '' }}>
                            {{ $region->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-6 py-2.5 rounded-lg transition">
                <i class="fa-solid fa-check ml-2"></i> حفظ التغييرات
            </button>
        </form>
    </div>

    {{-- Change password --}}
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-bold mb-4">تغيير كلمة المرور</h2>

        @if(session('password_success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm">
                {{ session('password_success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">كلمة المرور الحالية *</label>
                <input type="password" name="current_password" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">كلمة المرور الجديدة *</label>
                <input type="password" name="password" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">تأكيد كلمة المرور *</label>
                <input type="password" name="password_confirmation" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none">
            </div>

            <button type="submit" class="bg-accent-500 hover:bg-accent-600 text-white font-semibold px-6 py-2.5 rounded-lg transition">
                <i class="fa-solid fa-lock ml-2"></i> تغيير كلمة المرور
            </button>
        </form>
    </div>
</div>

@endsection