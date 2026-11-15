@extends('layouts.app')

@section('title', 'كيف يعمل الموقع؟')

@section('content')
<div class="bg-primary-600 text-white py-16">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-3">كيف يعمل MAFQOOD؟</h1>
        <p class="text-white/80">ثلاث خطوات بسيطة لاستعادة ممتلكاتك</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 py-12 space-y-6">
    <div class="bg-white rounded-xl shadow-sm p-6 flex gap-4 items-start">
        <div class="w-12 h-12 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center flex-shrink-0 text-xl font-bold">1</div>
        <div>
            <h3 class="text-lg font-bold mb-2">أنشئ حسابًا مجانيًا</h3>
            <p class="text-gray-600">سجّل بالبريد الإلكتروني وكلمة مرور، وستتمكن من نشر الإعلانات والتواصل مع الآخرين.</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 flex gap-4 items-start">
        <div class="w-12 h-12 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center flex-shrink-0 text-xl font-bold">2</div>
        <div>
            <h3 class="text-lg font-bold mb-2">انشر إعلانك</h3>
            <p class="text-gray-600">حدد نوع الإعلان (مفقود أو موجود)، أضف صورًا واضحة ووصفًا دقيقًا، واختر التصنيف والمنطقة المناسبة.</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 flex gap-4 items-start">
        <div class="w-12 h-12 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center flex-shrink-0 text-xl font-bold">3</div>
        <div>
            <h3 class="text-lg font-bold mb-2">تواصل بأمان</h3>
            <p class="text-gray-600">عندما يجد شخص ما شيئًا مشابهًا، يمكنه مراسلتك مباشرة عبر المنصة دون كشف بياناتك الشخصية.</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 flex gap-4 items-start">
        <div class="w-12 h-12 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center flex-shrink-0 text-xl font-bold">4</div>
        <div>
            <h3 class="text-lg font-bold mb-2">استرجع ممتلكاتك</h3>
            <p class="text-gray-600">بعد التأكد من أن الشيء لك، اتفق مع الطرف الآخر على طريقة الاستلام، ثم علّم الإعلان كمسترد.</p>
        </div>
    </div>

    <div class="text-center pt-6">
        <a href="{{ route('register') }}" class="inline-block bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-lg font-semibold transition">
            ابدأ الآن مجانًا
        </a>
    </div>
</div>
@endsection