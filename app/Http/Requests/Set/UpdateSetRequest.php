<?php

namespace App\Http\Requests\Set;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSetRequest extends FormRequest
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
            'name' => 'sometimes|string|max:255',
            'inventory_id' => 'sometimes|string|max:255',
            'employee_id' => 'sometimes|integer|exists:App\Models\Employee,id',
            'equipment' => 'sometimes|array',
            'equipment.*' => 'sometimes|integer|exists:App\Models\Equipment\Equipment,id',
        ];
    }
}
