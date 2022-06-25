<?php

namespace App\Services\Equipment;

use App\Models\Equipment\Equipment;
use App\Services\BaseService;
use Illuminate\Support\Arr;

class CreateEquipmentService extends BaseService
{
    /**
     * Создать оборудование
     *
     * @param  array  $data
     * @return Equipment
     */
    public function execute(array $data): Equipment
    {
        $equipment = Equipment::create(Arr::only($data, ['name', 'inventory_id', 'equipment_type_id']));

        if (Arr::has($data, ['sets'])) {
            $equipment->sets()->attach($data['sets']);
        }

        return $equipment;
    }
}
