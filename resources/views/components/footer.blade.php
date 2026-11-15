<footer class="bg-gray-900 text-gray-300 mt-16">
    <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">

        <div>
            <h3 class="text-white text-xl font-bold mb-4 flex items-center gap-2">
                <i class="fa-solid fa-magnifying-glass-location"></i>
                MAFQOOD
            </h3>
            <p class="text-sm leading-relaxed">
                منصة عربية متخصصة في المفقودات والموجودات، تساعد الناس على استعادة ممتلكاتهم بأمان وسهولة.
            </p>
        </div>

        <div>
            <h4 class="text-white font-semibold mb-4">روابط سريعة</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('home') }}" class="hover:text-white">الرئيسية</a></li>
                <li><a href="{{ route('items.index') }}" class="hover:text-white">كل الإعلانات</a></li>
                <li><a href="{{ route('categories.index') }}" class="hover:text-white">التصنيفات</a></li>
            </ul>
        </div>

        <div>
            <h4 class="text-white font-semibold mb-4">معلومات</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('how-it-works') }}" class="hover:text-white">كيف يعمل الموقع؟</a></li>
                <li><a href="{{ route('faq') }}" class="hover:text-white">الأسئلة الشائعة</a></li>
                <li><a href="{{ route('privacy') }}" class="hover:text-white">سياسة الخصوصية</a></li>
            </ul>
        </div>

        <div>
            <h4 class="text-white font-semibold mb-4">تواصل معنا</h4>
            <ul class="space-y-2 text-sm">
                <li><i class="fa-solid fa-envelope w-5"></i> info@mafqood.com</li>
                <li><i class="fa-solid fa-phone w-5"></i>+963 938 201 176</li>
            </ul>
        </div>
    </div>

    <div class="border-t border-gray-800 py-4 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} MAFQOOD — جميع الحقوق محفوظة
    </div>
</footer>