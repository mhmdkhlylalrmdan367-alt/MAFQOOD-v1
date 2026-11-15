<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>403 - غير مصرح</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="text-center">
        <div class="text-9xl font-bold text-red-500 mb-4">403</div>
        <h1 class="text-3xl font-bold text-gray-900 mb-3">غير مصرح لك بالوصول</h1>
        <p class="text-gray-500 mb-8">ليس لديك صلاحية للوصول إلى هذه الصفحة.</p>
        <a href="{{ route('home') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold">
            العودة للرئيسية
        </a>
    </div>
</body>
</html>