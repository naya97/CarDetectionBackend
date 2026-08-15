<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'plate_number' => 'required|string|max:255|unique:vehicles,plate_number',
            'country_code' => 'nullable|string|max:10',
            'type'         => 'nullable|string|max:100',
            'model'        => 'nullable|string|max:100',
            'color'        => 'nullable|string|max:50',
            'owner_name'   => 'nullable|string|max:255',
        ];
    }


    public function messages(): array
    {
        return [
            'plate_number.required' => 'plate_number is required.',
            'plate_number.unique' => 'This plate number is already registered in the system.',
        ];
    }
}
