<?php

namespace App\Http\Requests\Blacklist;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBlacklistRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // no auth system exists yet in this project
    }

    public function rules(): array
    {
        return [
            'vehicle_id' => ['required', 'integer', 'exists:vehicles,id'],
            'status' => ['required', 'string', 'max:255'],
            'priority' => ['required', 'string', Rule::in(['high', 'medium', 'low'])],
            'wanted' => ['sometimes', 'boolean'],
        ];
    }
}
