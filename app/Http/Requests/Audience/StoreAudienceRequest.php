<?php

namespace App\Http\Requests\Audience;

use App\Helpers\AuthHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAudienceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return AuthHelper::isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'building' => [
                'required',
                'integer',
                Rule::unique('App\Models\Equipment\Audience')->where(function ($query) {
                    return $query->where('building', $this->building)
                        ->where('number', $this->number)
                        ->where('letter', $this->letter);
                })
            ],
            'number' => 'required|integer',
            'letter' => 'nullable|string',
            'audience_type_id' => 'required|integer|exists:App\Models\Equipment\AudienceType,id',
            'equipment' => 'sometimes|array',
            'equipment.*' => 'sometimes|integer|exists:App\Models\Equipment\Equipment,id',
        ];
    }

    public function messages()
    {
        return [
            'building.unique' => 'Аудитория уже существует'
        ];
    }
}
