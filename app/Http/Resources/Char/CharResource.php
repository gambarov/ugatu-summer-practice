<?php

namespace App\Http\Resources\Char;

use Illuminate\Http\Resources\Json\JsonResource;

class CharResource extends JsonResource
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
            'name' => $this->name,
            'char_group' => new CharGroupResource($this->whenLoaded('group')),
            'char_measure' => new CharMeasureResource($this->whenLoaded('measure')),
            'value' => $this->whenPivotLoaded('equipment_char', function () {
                return $this->pivot->value;
            }),
        ];
    }
}
