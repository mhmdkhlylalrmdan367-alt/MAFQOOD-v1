@extends('layouts.app')

@section('title', 'الأسئلة الشائعة')

@section('content')
<div class="bg-primary-600 text-white py-16">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-3">الأسئلة الشائعة</h1>
        <p class="text-white/80">إجابات على أكثر ما يسأل عنه المستخدمون</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 py-12 space-y-4">
    @php
        $faqs = [
            ['q' => 'هل استخدام المنصة مجاني؟', 'a' => 'نعم، جميع خدمات MAFQOOD مجانية تمامًا.'],
            ['q' => 'كيف أضمن أن الشخص الذي يتواصل معي هو صاحب الشيء الحقيقي؟', 'a' => 'لا تشارك تفاصيل دقيقة عن الشيء في الإعلان. اسأل الطرف الآخر عنها قبل الاتفاق.'],
            ['q' => 'ماذا أفعل إذا وجدت شيئًا في الشارع؟', 'a' => 'انشر إعلانًا من نوع "موجود" مع وصف عام، واترك صاحبه يتواصل معك ويصف التفاصيل.'],
            ['q' => 'هل بياناتي الشخصية محمية؟', 'a' => 'نعم. لا نعرض رقم هاتفك أو بريدك الإلكتروني علنًا.'],
            ['q' => 'كيف أبلغ عن إعلان مخالف؟', 'a' => 'افتح صفحة الإعلان واضغط على "الإبلاغ عن الإعلان"، ثم اختر السبب وأرسل.'],
            ['q' => 'ماذا يعني "تم الاسترجاع"؟', 'a' => 'هي حالة تُعلّم بها إعلانك بعد استعادة الشيء.'],
        ];
    @endphp

    @foreach($faqs as $faq)
        <details class="bg-white rounded-xl shadow-sm p-5 group cursor-pointer">
            <summary class="flex items-center justify-between font-semibold text-gray-900 list-none">
                <span>{{ $faq['q'] }}</span>
                <i class="fa-solid fa-chevron-down text-gray-400 group-open:rotate-180 transition"></i>
            </summary>
            <p class="text-gray-600 mt-3 leading-relaxed">{{ $faq['a'] }}</p>
        </details>
    @endforeach
</div>
@endsection