@extends('layouts.guest')

@section('title', 'إعادة تعيين كلمة المرور')

@section('content')
    <h2 class="text-2xl font-bold text-gray-900 mb-2">إعادة تعيين كلمة المرور</h2>
    <p class="text-gray-500 text-sm mb-6">أدخل كلمة المرور الجديدة</p>

    @if($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني</label>
            <input type="email" name="email" value="{{ old('email', $request->email) }}" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">كلمة المرور الجديدة</label>
            <input type="password" name="password" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">تأكيد كلمة المرور</label>
            <input type="password" name="password_confirmation" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition">
        </div>

        <button type="submit"
                class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 rounded-lg transition">
            إعادة تعيين كلمة المرور
        </button>
    </form>
@endsection