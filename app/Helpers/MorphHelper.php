<?php

namespace App\Helpers;

use Illuminate\Validation\ValidationException;

class MorphHelper
{
    public static function getMorphType($name)
    {
        switch ($name) {
            case 'equipment':
                return 'App\Models\Equipment\Equipment';
            case 'set':
                return 'App\Models\Equipment\Set';
            default:
                throw ValidationException::withMessages([
                    'workable_type' => 'Некорректный тип сущности',
                ]);
        }
    }
}
