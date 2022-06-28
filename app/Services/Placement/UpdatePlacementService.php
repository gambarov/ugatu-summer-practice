<?php

namespace App\Services\Placement;

use App\Models\Equipment\Placement;
use App\Services\BaseService;
use Illuminate\Support\Arr;

class UpdatePlacementService extends BaseService
{
    /**
     * Обновить информацию о размещении.
     *
     * @param  array  $data
     * @return Placement
     */
    public function execute(array $data): Placement
    {
        // Получаем оборудование, которое нужно сместить
        $placement = Placement::findOrFail($data['id']);

        $placement->update(Arr::only($data, ['equipment_id', 'audience_id', 'placed_at', 'removed_at']));

        return $placement;
    }
}
