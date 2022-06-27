<?php

namespace App\Http\Requests\Work;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkRequest extends FormRequest
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
            'workable_id' => 'required|integer',
            'workable_type' => 'required|string',
            'work_type_id' => 'required|integer|exists:App\Models\Equipment\WorkType,id',
            'work_status_id' => 'required|integer|exists:App\Models\Equipment\WorkStatus,id',
            'employee_id' => 'nullable|integer|exists:App\Models\Employee,id',
            'started_at' => 'sometimes|date',
            'ended_at' => 'nullable|date',
        ];
    }
}
