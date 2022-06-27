<?php

namespace App\Http\Requests\Placement;

use Illuminate\Foundation\Http\FormRequest;

class StorePlacementRequest extends FormRequest
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
            'equipment_id' => 'required|integer|exists:App\Models\Equipment\Equipment,id',
            'audience_id' => 'required|integer|exists:App\Models\Equipment\Audience,id',
            'placed_at' => 'sometimes|date',
            'removed_at' => 'sometimes|date',
        ];
    }
}
