<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'name',
        'equipment_type_id',
    ];

    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class);
    }

    public function chars() {
        return $this->belongsToMany(EquipmentChar::class, 'equipment_char_map');
    }

    public function audiences() {
        return $this->belongsToMany(Audience::class, 'equipment_placement_map');
    }

    public function audience() {
        return $this->audiences()->orderBy('id', 'desc')->first();
    }

    public function sets() {
        return $this->belongsToMany(EquipmentSet::class, 'equipment_set_map');
    }
}
