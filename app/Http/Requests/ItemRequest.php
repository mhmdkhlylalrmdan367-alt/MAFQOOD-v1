<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:5', 'max:120'],
            'description' => ['required', 'string', 'min:20', 'max:3000'],
            'type' => ['required', 'in:lost,found'],
            'category_id' => ['required', 'exists:categories,id'],
            'region_id' => ['nullable', 'exists:regions,id'],
            'location_description' => ['nullable', 'string', 'max:255'],
            'event_date' => ['nullable', 'date', 'before_or_equal:today'],
            'images' => ['nullable', 'array', 'max:5'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'عنوان الإعلان مطلوب',
            'title.min' => 'العنوان يجب أن يكون 5 أحرف على الأقل',
            'description.required' => 'وصف الشيء مطلوب',
            'description.min' => 'الوصف يجب أن يكون 20 حرفًا على الأقل',
            'type.required' => 'نوع الإعلان مطلوب',
            'category_id.required' => 'التصنيف مطلوب',
            'images.*.image' => 'الملف يجب أن يكون صورة',
            'images.*.max' => 'حجم الصورة يجب أن يكون أقل من 4 ميجابايت',
        ];
    }
}