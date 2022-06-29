<?php

namespace App\Http\Requests\Char;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCharRequest extends FormRequest
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
            'char_group_id' => 'required|integer|exists:App\Models\Equipment\CharGroup,id',
            'char_measure_id' => 'required|integer|exists:App\Models\Equipment\CharMeasure,id',
        ];
    }
}
