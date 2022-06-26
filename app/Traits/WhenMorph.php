<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;

trait WhenMorph
{
    public function whenMorphLoaded($name, $map)
    {
        return $this->whenLoaded($name, function () use ($name, $map) {
            $morphType = $name . '_type';
            $morphAlias = $this->resource->$morphType;
            $morphResourceClass = $map[$morphAlias];
            return new $morphResourceClass($this->resource->$name);
        });
    }
}