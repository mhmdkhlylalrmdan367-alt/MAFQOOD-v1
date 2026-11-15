@extends('layouts.guest')

@section('title', 'إنشاء حساب')

@section('content')
    <h2 class="text-2xl font-bold text-gray-900 mb-2">إنشاء حساب جديد</h2>
    <p class="text-gray-500 text-sm mb-6">انضم إلينا وساعد الآخرين في استعادة ممتلكاتهم</p>

    @if($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">الاسم الكامل</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition"
                   placeholder="محمد أحمد">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition"
                   placeholder="you@example.com">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">رقم الهاتف (اختياري)</label>
            <input type="text" name="phone" value="{{ old('phone') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition"
                   placeholder="+963 999 999 999">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">كلمة المرور</label>
            <input type="password" name="password" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition"
                   placeholder="••••••••">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">تأكيد كلمة المرور</label>
            <input type="password" name="password_confirmation" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition"
                   placeholder="••••••••">
        </div>

        <button type="submit"
                class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 rounded-lg transition">
            إنشاء الحساب
        </button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-6">
        لديك حساب بالفعل؟
        <a href="{{ route('login') }}" class="text-primary-600 font-medium hover:underline">تسجيل الدخول</a>
    </p>
@endsection