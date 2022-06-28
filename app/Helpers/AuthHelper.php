<?php

namespace App\Helpers;

class AuthHelper
{
    public static function authorize()
    {
        $user = auth()->user();

        if (!$user)
            return false;

        $role = mb_strtolower($user->load('role')->role->name);
        return $role == 'администратор';
    }
}
