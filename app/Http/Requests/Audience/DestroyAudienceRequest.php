<?php

namespace App\Http\Requests\Audience;

use Illuminate\Foundation\Http\FormRequest;

class DestroyAudienceRequest extends FormRequest
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
            //
        ];
    }
}
