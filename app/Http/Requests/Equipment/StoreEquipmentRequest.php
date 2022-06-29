<?php

namespace App\Http\Requests\Equipment;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'equipment_type_id' => 'required|integer|exists:App\Models\Equipment\EquipmentType,id',
            'inventory_id' => 'required|string|max:255',
            'sets' => 'sometimes|array',
            'sets.*' => 'sometimes|integer|exists:App\Models\Equipment\Set,id',
            'chars' => 'sometimes|array',
        ];
    }
}
