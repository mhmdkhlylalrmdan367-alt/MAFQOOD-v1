<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SiteReportRequest extends FormRequest
{
    // public function authorize(): bool
    // {
    //     return $this->user()?->isAdmin() === true;
    // }

    public function rules(): array
    {
        return [
            'from' => ['required', 'date_format:Y-m-d'],
            'to' => ['required', 'date_format:Y-m-d', 'after_or_equal:from'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->mergeIfMissing([
            'from' => now()->subDays(29)->toDateString(),
            'to' => now()->toDateString(),
        ]);
    }

    public function attributes(): array
    {
        return ['from' => 'بداية الفترة', 'to' => 'نهاية الفترة'];
    }

    public function messages(): array
    {
        return [
            '*.required' => 'يرجى تحديد :attribute.',
            '*.date_format' => 'يجب أن يكون :attribute تاريخاً بصيغة YYYY-MM-DD.',
            'to.after_or_equal' => 'يجب أن تكون نهاية الفترة بعد بدايتها أو مساوية لها.',
        ];
    }
}
