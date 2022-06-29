<?php

namespace App\Http\Requests\Note;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNoteRequest extends FormRequest
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
            'text' => 'sometimes|string',
            'equipment_id' => 'sometimes|integer|exists:App\Models\Equipment\Equipment,id',
            'employee_id' => 'sometimes|integer|exists:App\Models\Employee,id',
        ];
    }
}
