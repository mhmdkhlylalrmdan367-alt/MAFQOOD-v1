@extends('layouts.app')
@section('title', 'الملف الشخصي')

@section('content')
<div class="bg-primary-600 text-white py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <h1 class="text-3xl font-bold">الملف الشخصي</h1>
        <p class="text-white/80 mt-1">بياناتك الشخصية وأمان حسابك، في مكان واحد.</p>
    </div>
</div>

<div class="profile-page max-w-6xl mx-auto px-4 sm:px-6 py-8">
    @if($errors->any())
        <div role="alert" tabindex="-1" data-site-errors class="profile-error-summary">
            <strong>تعذّر حفظ التغييرات. راجع الحقول التالية:</strong>
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="profile-sections">
        <section class="profile-card site-surface" aria-labelledby="profile-details-title">
            <header class="profile-section-header">
                <span class="profile-section-icon" aria-hidden="true"><i class="fa-regular fa-user"></i></span>
                <div><h2 id="profile-details-title">البيانات الشخصية</h2><p>حدّث اسمك وصورتك ومعلومات التواصل.</p></div>
            </header>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="profile-form">
                @csrf @method('PUT')
                <div class="profile-avatar-editor">
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatarUrl() }}" width="76" height="76" class="profile-avatar" alt="صورتك الشخصية">
                    @else
                        <span class="profile-avatar profile-avatar-initial" aria-hidden="true">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
                    @endif
                    <x-form.field name="avatar" label="الصورة الشخصية" type="file" accept="image/*" hint="صورة بحد أقصى 2 ميغابايت. اختيارية." data-site-upload />
                </div>

                <x-form.field name="name" label="الاسم الكامل" :value="auth()->user()->name" autocomplete="name" maxlength="255" required />
                <x-form.field name="email" label="البريد الإلكتروني" type="email" :value="auth()->user()->email" dir="ltr" hint="البريد المرتبط بالحساب. لا يمكن تغييره حالياً." disabled />
                <x-form.field name="phone" label="رقم الهاتف" type="tel" :value="auth()->user()->phone" autocomplete="tel" maxlength="20" dir="ltr" placeholder="+963 …" />
                <x-form.field name="region_id" label="المنطقة" type="select">
                    <option value="">اختر المنطقة</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}" @selected(old('region_id', auth()->user()->region_id) == $region->id)>{{ $region->name }}</option>
                    @endforeach
                </x-form.field>

                <footer class="profile-form-footer">
                    <span>احفظ التغييرات بعد الانتهاء.</span>
                    <button type="submit" class="profile-save-button"><i class="fa-solid fa-check" aria-hidden="true"></i> حفظ البيانات</button>
                </footer>
            </form>
        </section>

        <section class="profile-card site-surface" aria-labelledby="profile-security-title">
            <header class="profile-section-header">
                <span class="profile-section-icon profile-section-icon-gold" aria-hidden="true"><i class="fa-solid fa-shield-halved"></i></span>
                <div><h2 id="profile-security-title">أمان الحساب</h2><p>غيّر كلمة المرور للحفاظ على أمان حسابك.</p></div>
            </header>

            <form method="POST" action="{{ route('profile.password') }}" class="profile-form">
                @csrf @method('PUT')
                <x-form.field name="current_password" label="كلمة المرور الحالية" type="password" autocomplete="current-password" required />
                <x-form.field name="password" label="كلمة المرور الجديدة" type="password" autocomplete="new-password" minlength="8" hint="استخدم 8 أحرف على الأقل، واختر كلمة مختلفة عن الحالية." required />
                <x-form.field name="password_confirmation" label="تأكيد كلمة المرور الجديدة" type="password" autocomplete="new-password" minlength="8" required />
                <div class="profile-security-note"><i class="fa-solid fa-lock" aria-hidden="true"></i><p>لا تشارك كلمة مرورك مع أي شخص، ولا تستخدم كلمة المرور نفسها في أكثر من موقع.</p></div>
                <footer class="profile-form-footer">
                    <button type="submit" class="profile-save-button profile-save-button-gold"><i class="fa-solid fa-key" aria-hidden="true"></i> تحديث كلمة المرور</button>
                </footer>
            </form>
        </section>
    </div>
</div>
@endsection
