@extends('layouts.guest')

@section('title', 'نسيت كلمة المرور')

@section('content')
    <h2 class="text-2xl font-bold text-gray-900 mb-2">نسيت كلمة المرور؟</h2>
    <p class="text-gray-500 text-sm mb-6">أدخل بريدك الإلكتروني وسنرسل لك رابط إعادة التعيين</p>

    @if(session('status'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm">
            {{ session('status') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition"
                   placeholder="you@example.com">
        </div>

        <button type="submit"
                class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 rounded-lg transition">
            إرسال رابط الاستعادة
        </button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-6">
        <a href="{{ route('login') }}" class="text-primary-600 font-medium hover:underline">العودة لتسجيل الدخول</a>
    </p>
@endsection