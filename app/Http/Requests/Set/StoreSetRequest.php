<?php

namespace App\Http\Requests\Set;

use Illuminate\Foundation\Http\FormRequest;

class StoreSetRequest extends FormRequest
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
            'inventory_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'employee_id' => 'sometimes|integer|exists:App\Models\Employee,id',
            'equipment' => 'sometimes|array',
            'equipment.*' => 'sometimes|integer|exists:App\Models\Equipment\Equipment,id',
        ];
    }
}
