<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleRequest extends FormRequest
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
        $vehicleId = $this->route('vehicle')->id;

        return [
            'plate_number' => 'sometimes|required|string|max:255|unique:vehicles,plate_number,' . $vehicleId,
            'country_code' => 'nullable|string|max:10',
            'type'         => 'nullable|string|max:100',
            'model'        => 'nullable|string|max:100',
            'color'        => 'nullable|string|max:50',
            'owner_name'   => 'nullable|string|max:255',
        ];
    }
}
