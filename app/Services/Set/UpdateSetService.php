<?php

namespace App\Services\Set;

use App\Models\Equipment\Set;
use App\Services\BaseService;
use Illuminate\Support\Arr;

class UpdateSetService extends BaseService
{
    /**
     * Обновить комплект оборудования.
     *
     * @param  array  $data
     * @return Section
     */
    public function execute(array $data): Set
    {
        $set = Set::findOrFail($data['id']);
        $set->update(Arr::only($data, ['name', 'employee_id']));

        if (Arr::has($data, 'equipment')) {
            $set->equipment()->sync($data['equipment']);
        }

        return $set;
    }
}
