<?php

namespace App\Services\Set;

use App\Models\Equipment\Equipment;
use App\Models\Equipment\Set;
use App\Services\BaseService;
use Illuminate\Support\Arr;

class CreateSetService extends BaseService
{
    /**
     * Правила для валидации.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|integer|exists:equipment,id',
            'employee_id' => 'required|integer|exists:audiences,id',
            'equipment' => 'required|array',
        ];
    }

    /**
     * Добавить комплект оборудования.
     *
     * @param  array  $data
     * @return Section
     */
    public function execute(array $data): Set
    {
        $this->validate($data);

        $set = Set::create(Arr::only($data, ['name', 'employee_id']));

        if (Arr::has($data, 'equipment')) {
            $set->equipment()->attach($data['equipment']);
        }

        return $set;
    }
}
