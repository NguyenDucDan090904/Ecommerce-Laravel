<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('category'); // Lấy ID khi đang ở route update
        return [
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ];
    }
}
