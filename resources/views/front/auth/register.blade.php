@extends('layouts.guest')
@section('title', 'إنشاء حساب')
@section('content')
<div class="signup-intro">
    <span class="signup-symbol" aria-hidden="true"><i class="fa-solid fa-hand-holding-heart"></i></span>
    <h1>خلّينا نرجّع الضايع لأصحابه.</h1>
    <p>أنشئ حسابك لتنشر بلاغاتك وتتواصل مع أصحاب الأغراض.</p>
</div>
@if($errors->any())
    <div role="alert" class="signup-error-summary">راجع الحقول المعلّمة تحت، وعدّلها لتكمل إنشاء الحساب.</div>
@endif
<form method="POST" action="{{ route('register') }}" class="signup-form">
    @csrf
    @foreach([
        ['name', 'الاسم الكامل', 'text', 'مثلًا محمد أحمد', 'name', 'fa-user'],
        ['email', 'البريد الإلكتروني', 'email', 'name@example.com', 'email', 'fa-envelope'],
        ['phone', 'رقم الهاتف', 'tel', '+963 9XX XXX XXX', 'tel', 'fa-phone'],
        ['password', 'كلمة المرور', 'password', 'اختار كلمة مرور من 8 أحرف أو أكثر', 'new-password', 'fa-lock'],
        ['password_confirmation', 'تأكيد كلمة المرور', 'password', 'اكتب كلمة المرور مرة تانية', 'new-password', 'fa-shield-halved'],
    ] as [$name, $label, $type, $placeholder, $autocomplete, $icon])
        <div>
            <label for="signup-{{ $name }}">{{ $label }} @if($name === 'phone')<small>اختياري</small>@endif</label>
            <div class="signup-field">
                <i class="fa-solid {{ $icon }}" aria-hidden="true"></i>
                <input id="signup-{{ $name }}" name="{{ $name }}" type="{{ $type }}"
                    placeholder="{{ $placeholder }}" autocomplete="{{ $autocomplete }}"
                    @if($type !== 'password') value="{{ old($name) }}" @endif
                    @if(in_array($name, ['email', 'phone'])) dir="ltr" @endif
                    @if($name !== 'phone') required @endif
                    @if($type === 'password') minlength="8" @endif
                    @if($name === 'name') maxlength="255" @endif
                    @if($name === 'email') maxlength="255" @endif
                    @if($name === 'phone') maxlength="20" @endif
                    @error($name) aria-invalid="true" aria-describedby="signup-{{ $name }}-error" @enderror>
                @if($type === 'password')
                    <button type="button" data-password-toggle="signup-{{ $name }}" aria-label="إظهار {{ $label }}" aria-pressed="false">
                        <i class="fa-regular fa-eye" aria-hidden="true"></i>
                    </button>
                @endif
            </div>
            @error($name)<p id="signup-{{ $name }}-error" class="signup-error">{{ $message }}</p>@enderror
        </div>
    @endforeach
    <p class="signup-privacy">تعرّف على طريقة استخدام بياناتك في <a href="{{ route('privacy') }}">سياسة الخصوصية</a>.</p>
    <button type="submit" class="signup-submit">إنشاء الحساب <i class="fa-solid fa-arrow-left" aria-hidden="true"></i></button>
    <p class="signup-login">عندك حساب؟ <a href="{{ route('login') }}">تسجيل الدخول</a></p>
</form>
@endsection
