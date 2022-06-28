<?php

namespace App\Http\Requests\Employee;

use App\Helpers\AuthHelper;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return AuthHelper::authorize();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'surname' => 'sometimes|string|max:255',
            'name' => 'sometimes|string|max:255',
            'patronymic' => 'sometimes|string|max:255',
            'role_id' => 'sometimes|integer:exists:App\Models\Role,id',
            'email' => 'sometimes|string|email|max:255|unique:App\Models\Employee,email,' . auth()->user()->id,
            'password' => 'sometimes|string|min:6',
        ];
    }
}
