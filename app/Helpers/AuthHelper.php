<?php

namespace App\Helpers;

use Illuminate\Validation\ValidationException;

class AuthHelper
{
    public static function authorize()
    {
        $user = auth()->user();

        if (!$user)
            return false;

        return $user->load('role')->role->name === 'Администратор';
    }
}
