<?php

namespace App\Models\Equipment;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Placement extends Pivot
{
    protected $table = 'placements';
 
    public $timestamps = false;
    
    protected $guarded = ['id'];
    
    protected $fillable = [
        'equipment_id',
        'audience_id',
        'placed_at',
        'removed_at',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function audience()
    {
        return $this->belongsTo(Audience::class);
    }
}
