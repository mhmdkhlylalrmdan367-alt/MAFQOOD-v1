@extends('layouts.guest')
@section('title', 'تسجيل الدخول')
@section('content')
<div class="signup-intro">
    <span class="signup-symbol" aria-hidden="true"><i class="fa-solid fa-door-open"></i></span>
    <h1>نورت لُقيا الشام.</h1>
    <p>سجّل دخولك لتتابع بلاغاتك ورسائلك.</p>
</div>
@if($errors->any())
    <div id="login-error" role="alert" class="signup-error-summary">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('login') }}" class="signup-form">
    @csrf
    <div>
        <label for="login-email">البريد الإلكتروني</label>
        <div class="signup-field">
            <i class="fa-regular fa-envelope" aria-hidden="true"></i>
            <input id="login-email" type="email" name="email" value="{{ old('email') }}" autocomplete="username"
                   dir="ltr" maxlength="255" required placeholder="name@example.com"
                   @if($errors->any()) aria-describedby="login-error" @endif>
        </div>
    </div>

    <div>
        <label for="login-password">كلمة المرور</label>
        <div class="signup-field">
            <i class="fa-solid fa-lock" aria-hidden="true"></i>
            <input id="login-password" type="password" name="password" autocomplete="current-password" required
                   placeholder="اكتب كلمة مرور حسابك" @if($errors->any()) aria-describedby="login-error" @endif>
            <button type="button" data-password-toggle="login-password" aria-label="إظهار كلمة المرور" aria-pressed="false">
                <i class="fa-regular fa-eye" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    <div class="login-options">
        <label for="login-remember"><input id="login-remember" type="checkbox" name="remember" value="1" @checked(old('remember'))> تذكّرني</label>
        <a href="{{ route('password.request') }}">نسيت كلمة المرور؟</a>
    </div>

    <button type="submit" class="signup-submit">
        تسجيل الدخول <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
    </button>

    <div class="login-register">
        <p>أول مرة معنا؟</p>
        <a href="{{ route('register') }}">أنشئ حسابك <i class="fa-solid fa-arrow-left" aria-hidden="true"></i></a>
    </div>
    <a href="{{ route('home') }}" class="login-home">العودة للرئيسية</a>
</form>
@endsection
