<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderStatusRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'status' => 'required|in:pending,processing,shipping,completed,cancelled',
        ];
    }

    public function messages(): array
    {
        return [
            'status.in' => 'Trạng thái đơn hàng không hợp lệ.',
        ];
    }
}
