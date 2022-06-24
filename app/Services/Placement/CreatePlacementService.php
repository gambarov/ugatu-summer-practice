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
        $audience = $equipment->currentAudience();

        if ($audience) {
            // Получаем последнее (текущее) расположение, если оно есть
            $placement = $audience->placements->latest('placed_at')->first();;
            // Закрываем предыдущее расположение
            $placement->update([
                'removed_at' => Carbon::now(),
            ]);
        }

        // Создаем новое расположение
        Placement::create($data);
        // FIXME: Приходится возращать расположение таким образом, 
        // потому что Placement::create() не возвращает данных с id, placed_at, removed_at 
        return $equipment->currentPlacement();
    }
}
