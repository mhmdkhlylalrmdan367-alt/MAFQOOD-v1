@extends('layouts.guest')

@section('title', 'تسجيل الدخول')

@section('content')
    <h2 class="text-2xl font-bold text-gray-900 mb-2">تسجيل الدخول</h2>
    <p class="text-gray-500 text-sm mb-6">أدخل بياناتك للوصول إلى حسابك</p>

    @if($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition"
                   placeholder="you@example.com">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">كلمة المرور</label>
            <input type="password" name="password" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition"
                   placeholder="••••••••">
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center gap-2">
                <input type="checkbox" name="remember" class="rounded border-gray-300">
                <span>تذكرني</span>
            </label>
            <a href="{{ route('password.request') }}" class="text-primary-600 hover:underline">نسيت كلمة المرور؟</a>
        </div>

        <button type="submit"
                class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 rounded-lg transition">
            تسجيل الدخول
        </button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-6">
        ليس لديك حساب؟
        <a href="{{ route('register') }}" class="text-primary-600 font-medium hover:underline">أنشئ حسابًا</a>
    </p>
@endsection