<?php

namespace App\Http\Requests\Work;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWorkRequest extends FormRequest
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
            'workable_id' => [
                'sometimes',
                'integer',
                Rule::requiredIf($this->request->has('workable_type'))
            ],
            'workable_type' => [
                'sometimes', 
                'string', 
                Rule::requiredIf($this->request->has('workable_id'))
            ],
            'work_type_id' => 'sometimes|integer|exists:App\Models\Equipment\WorkType,id',
            'work_status_id' => 'sometimes|integer|exists:App\Models\Equipment\WorkStatus,id',
            'employee_id' => 'nullable|integer|exists:App\Models\Employee,id',
            'started_at' => 'sometimes|date',
            'ended_at' => 'nullable|date',
        ];
    }
}
