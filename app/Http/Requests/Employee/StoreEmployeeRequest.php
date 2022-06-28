<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->user();

        if (!$user)
            return false;

        return $user->load('role')->role->name === 'Администратор';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'surname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'patronymic' => 'required|string|max:255',
            'role_id' => 'required|integer:exists:App\Models\Role,id',
            'email' => 'required|string|email|max:255|unique:App\Models\Employee,email',
            'password' => 'required|string|min:6',
        ];
    }
}
