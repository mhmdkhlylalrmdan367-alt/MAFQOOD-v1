<footer @class(['site-footer border-t border-[#416357] text-[#dce8e1]', 'mt-16' => !request()->routeIs('home')])>
    <div class="mx-auto grid max-w-7xl grid-cols-2 gap-x-4 gap-y-8 px-4 py-10 sm:px-8 lg:grid-cols-[1.5fr_1fr_1fr_1.2fr]">
        <div class="col-span-2 lg:col-span-1">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 text-white focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#e5ca91]">
                <span class="relative size-11 shrink-0 overflow-hidden rounded-[30%]">
                    <img src="{{ asset('images/luqya-sham-logo.png') }}" alt="" width="1536" height="1024" loading="lazy"
                         class="absolute top-0 left-0 h-auto w-[233%] max-w-none -translate-x-[28.5%] -translate-y-[18.4%]">
                </span>
                @if(app()->getLocale() === 'ar')
                    <span class="inline-flex items-baseline gap-1.5"><span class="text-2xl font-extrabold">لُقيا</span><span class="text-base font-bold">الشام</span></span>
                @else
                    <span class="text-xl font-extrabold">{{ __('messages.app_name') }}</span>
                @endif
            </a>
            <p class="mt-3 max-w-xs text-sm leading-7">منصة عربية تساعدك تلاقي أغراضك المفقودة وتردّ الموجودات لأصحابها.</p>
        </div>

        <nav aria-label="روابط التصفّح">
            <h2 class="mb-3 text-sm font-extrabold text-[#efd8a8]">تصفّح</h2>
            <ul class="space-y-2 text-sm leading-6">
                <li><a href="{{ route('items.index', ['type' => 'lost']) }}" class="hover:text-white hover:underline">المفقودات</a></li>
                <li><a href="{{ route('items.index', ['type' => 'found']) }}" class="hover:text-white hover:underline">الموجودات</a></li>
                <li><a href="{{ route('categories.index') }}" class="hover:text-white hover:underline">التصنيفات</a></li>
            </ul>
        </nav>

        <nav aria-label="روابط المساعدة">
            <h2 class="mb-3 text-sm font-extrabold text-[#efd8a8]">المساعدة</h2>
            <ul class="space-y-2 text-sm leading-6">
                <li><a href="{{ route('how-it-works') }}" class="hover:text-white hover:underline">كيف يعمل الموقع؟</a></li>
                <li><a href="{{ route('faq') }}" class="hover:text-white hover:underline">الأسئلة الشائعة</a></li>
                <li><a href="{{ route('privacy') }}" class="hover:text-white hover:underline">سياسة الخصوصية</a></li>
            </ul>
        </nav>

        <div class="col-span-2 lg:col-span-1">
            <h2 class="mb-3 text-sm font-extrabold text-[#efd8a8]">تواصل معنا</h2>
            <ul class="space-y-2 text-sm">
                <li><a href="mailto:info@mafqood.com" class="inline-flex items-center gap-2 py-1 hover:text-white hover:underline"><i class="fa-solid fa-envelope" aria-hidden="true"></i><bdi>info@mafqood.com</bdi></a></li>
                <li><a href="tel:+963938201176" class="inline-flex items-center gap-2 py-1 hover:text-white hover:underline"><i class="fa-solid fa-phone" aria-hidden="true"></i><bdi dir="ltr">+963 938 201 176</bdi></a></li>
            </ul>
        </div>
    </div>

    <div class="border-t border-white/15">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-3 px-4 py-4 text-xs text-[#c1d4c9] sm:px-8">
            <p>&copy; {{ date('Y') }} {{ __('messages.app_name') }}. جميع الحقوق محفوظة.</p>
            <a href="#page-top" class="inline-flex items-center gap-2 rounded-full border border-white/25 px-3 py-2 font-bold hover:bg-white/10">
                للأعلى <i class="fa-solid fa-arrow-up" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</footer>

