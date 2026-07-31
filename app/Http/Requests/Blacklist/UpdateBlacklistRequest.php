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
            // vehicle_id intentionally NOT editable — a blacklist entry always
            // belongs to the vehicle it was created for
            'reason' => ['sometimes', 'string', 'max:255'],
            'status' => ['sometimes', 'string', Rule::in(['high', 'medium', 'low'])],
            'wanted' => ['sometimes', 'boolean'],
        ];
    }
}
