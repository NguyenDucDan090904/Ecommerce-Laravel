<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ImportProductRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:csv,txt|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'Vui lòng chọn một file CSV.',
            'file.mimes' => 'Hệ thống chỉ chấp nhận file định dạng .csv',
            'file.max' => 'Dung lượng file không được vượt quá 5MB.',
        ];
    }
}
