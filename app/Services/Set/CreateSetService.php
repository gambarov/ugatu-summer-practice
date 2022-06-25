<?php

namespace App\Services\Set;

use App\Models\Equipment\Set;
use App\Services\BaseService;
use Illuminate\Support\Arr;

class CreateSetService extends BaseService
{
    /**
     * Добавить комплект оборудования.
     *
     * @param  array  $data
     * @return Set
     */
    public function execute(array $data): Set
    {
        $set = Set::create(Arr::only($data, ['name', 'employee_id']));

        if (Arr::has($data, 'equipment')) {
            $set->equipment()->attach($data['equipment']);
        }

        return $set;
    }
}
