
@extends('layouts.admin')

@section('title', 'إضافة موظف جديد')

@section('description', 'أضف موظفاً جديداً وحدد بياناته وأدواره وصلاحياته.')

@section('content')

<div class="max-w-2xl">

    <a href="{{ route('admin.admins.index') }}"
       class="text-sm text-gray-500 hover:text-primary-600 mb-4 inline-block">
        <i class="fa-solid fa-arrow-right ml-1" aria-hidden="true"></i>
        العودة للموظفين
    </a>

    @if ($errors->any())
        <div role="alert"
             tabindex="-1"
             data-admin-errors
             class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm">

            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif

    <form action="{{ route('admin.admins.store') }}"
          method="POST"
          class="bg-white rounded-xl shadow-sm p-6 space-y-4">

        @csrf

        <div class="admin-form-title">
            <h2>إضافة موظف جديد</h2>
            <p>أدخل البيانات الأساسية وحدد أدوار الموظف وصلاحياته داخل لوحة التحكم.</p>
        </div>

        @include('admin.admins._form')

        <div class="flex gap-3 pt-4 border-t border-gray-100">

            <button type="submit"
                    class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-6 py-2.5 rounded-lg transition">
                <i class="fa-solid fa-check ml-2" aria-hidden="true"></i>
                حفظ الموظف
            </button>

            <a href="{{ route('admin.admins.index') }}"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-lg transition">
                إلغاء
            </a>
        </div>
    </form>
</div>
@endsection
