<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reason' => ['required', 'in:spam,fraud,wrong_category,offensive,duplicate,other'],
            'details' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'reason.required' => 'سبب البلاغ مطلوب',
            'reason.in' => 'سبب البلاغ غير صالح',
        ];
    }
}