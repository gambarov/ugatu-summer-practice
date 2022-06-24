<?php

namespace App\Http\Resources\Note;

use App\Http\Resources\Employee\EmployeeResource;
use App\Http\Resources\Equipment\EquipmentResource;

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
            'equipment' => new EquipmentResource($this->whenLoaded('equipment')),
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
        ];
    }
}
