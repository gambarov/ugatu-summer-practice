<?php

namespace App\Services\Placement;

use App\Models\Equipment\Equipment;
use App\Models\Equipment\Placement;
use App\Services\BaseService;
use Carbon\Carbon;

class CreatePlacementService extends BaseService
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
    public function execute(array $data): Placement
    {
        $this->validate($data);

        // Получаем оборудование, которое нужно сместить
        $equipment = Equipment::findOrFail($data['equipment_id']);

        if ($equipment->audience()) {
            // Получаем последнее (текущее) расположение, если оно есть
            $placement = $equipment->audience()->placements->latest('placed_at')->first();

            // Закрываем предыдущее расположение
            if ($placement) {
                $placement->update([
                    'removed_at' => Carbon::now(),
                ]);
            }
        }

        // Создаем новое расположение
        return Placement::create($data);
    }
}
