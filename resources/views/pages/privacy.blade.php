@extends('layouts.app')

@section('title', 'سياسة الخصوصية')

@section('content')
<div class="bg-primary-600 text-white py-16">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-3">سياسة الخصوصية</h1>
        <p class="text-white/80">آخر تحديث: {{ date('Y-m-d') }}</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="bg-white rounded-xl shadow-sm p-8 space-y-6 text-gray-700 leading-relaxed">
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3">1. المعلومات التي نجمعها</h2>
            <p>عند تسجيلك، نجمع: الاسم، البريد الإلكتروني، رقم الهاتف (اختياري)، المنطقة (اختياري)، الصورة الشخصية (اختياري).</p>
        </section>
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3">2. كيف نستخدم معلوماتك</h2>
            <p>نستخدم معلوماتك لإدارة حسابك، تمكينك من نشر الإعلانات والتواصل، وإرسال إشعارات متعلقة بحسابك.</p>
        </section>
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3">3. حماية بياناتك</h2>
            <p>نلتزم بتشفير كلمات المرور، اتصالات HTTPS آمنة، وعدم مشاركة بياناتك مع أطراف ثالثة.</p>
        </section>
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3">4. حقوقك</h2>
            <p>لديك الحق في الوصول إلى بياناتك وتعديلها، حذف حسابك، وطلب نسخة من بياناتك.</p>
        </section>
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3">5. التواصل معنا</h2>
            <p>لأي استفسار: privacy@mafqood.com</p>
        </section>
    </div>
</div>
@endsection