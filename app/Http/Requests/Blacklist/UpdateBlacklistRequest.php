<?php

namespace App\Http\Requests\Blacklist;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBlacklistRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['sometimes', 'string', 'max:255'],
            'priority' => ['sometimes', 'string', Rule::in(['عالي', 'متوسط', 'منخفض'])],
            'wanted' => ['sometimes', 'boolean'],
        ];
    }
}
