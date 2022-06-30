<?php

namespace App\Services\Equipment;

use App\Models\Equipment\Equipment;
use App\Services\BaseService;
use Illuminate\Support\Arr;

class UpdateEquipmentService extends BaseService
{
    /**
     * Обновить оборудование
     *
     * @param  array  $data
     * @return Equipment
     */
    public function execute(array $data): Equipment
    {
        $equipment = Equipment::findOrFail($data['id']);
        $equipment->update(Arr::only($data, ['name', 'inventory_id', 'equipment_type_id']));        

        if (Arr::has($data, ['sets'])) {
            $equipment->sets()->sync($data['sets']);
        }

        if (Arr::has($data, ['audiences'])) {
            $equipment->audiences()->sync($data['audiences']);
        }

        if (Arr::has($data, ['chars'])) {
            foreach ($data['chars'][0] as $id => $char) {
                $equipment->chars()->sync($id, ['value' => $char['value']]);
            }
        }

        return $equipment;
    }
}
