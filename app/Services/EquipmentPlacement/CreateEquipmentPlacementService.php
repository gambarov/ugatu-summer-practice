<?php

namespace App\Services\EquipmentPlacement;

use App\Models\Equipment;
use App\Models\EquipmentPlacement;
use App\Services\BaseService;
use Carbon\Carbon;

class CreateEquipmentPlacementService extends BaseService
{
    /**
     * Правила для валидации.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'equipment_id' => 'required|integer|exists:equipment,id',
            'audience_id' => 'required|integer|exists:audiences,id',
        ];
    }

    /**
     * Разместить оборудование в аудитории.
     *
     * @param  array  $data
     * @return Section
     */
    public function execute(array $data) : EquipmentPlacement
    {
        $this->validate($data);

        // Получаем оборудование, которое нужно сместить
        $equipment = Equipment::findOrFail($data['equipment_id']);
        // Получаем последнее (текущее) расположение, если оно есть
        $placement = $equipment->audience()->placements->latest('placed_at')->first();

        // Закрываем предыдущее расположение
        if ($placement) {
            $placement->update([
                'removed_at' => Carbon::now(),
            ]);
        }

        // Создаем новое расположение
        return EquipmentPlacement::create($data);
    }
}
