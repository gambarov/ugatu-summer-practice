<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'equipment_id' => $this->equipment_id,
            'equipment' => new WithEquipmentResource($this->equipment),
            'employee_id' => $this->employee_id,
            'employee' => new WithEmployeeResource($this->employee),
        ];
    }
}
