<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EquipmentPlacement extends Pivot
{
    protected $table = 'equipment_placements';
 
    public $timestamps = false;
    
    protected $fillable = [
        'equipment_id',
        'audience_id',
        'placed_at',
        'removed_at',
    ];
}
