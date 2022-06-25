<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

abstract class BaseService
{
    /**
     * Правила для валидации.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Валидирует данные согласно правилам 
     *
     * @param  array  $data
     * @return bool
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(array $data): bool
    {
        Validator::make($data, $this->rules())
            ->validate();

        return true;
    }

    public abstract function execute(array $data): Model;
}