@extends('layouts.guest')

@section('title', 'تأكيد البريد الإلكتروني')

@section('content')
    <div class="text-center">
        <div class="w-16 h-16 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-envelope text-2xl"></i>
        </div>

        <h2 class="text-2xl font-bold text-gray-900 mb-2">تأكيد البريد الإلكتروني</h2>
        <p class="text-gray-500 text-sm mb-6">
            أرسلنا رابط تأكيد إلى بريدك الإلكتروني. يرجى التحقق من صندوق الوارد والنقر على الرابط.
        </p>

        @if(session('status') === 'verification-link-sent')
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm">
                تم إرسال رابط تأكيد جديد إلى بريدك الإلكتروني.
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}" class="space-y-3">
            @csrf
            <button type="submit"
                    class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 rounded-lg transition">
                إعادة إرسال رابط التأكيد
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
                تسجيل الخروج
            </button>
        </form>
    </div>
@endsection