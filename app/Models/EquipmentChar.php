<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentChar extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
    ];

    public function equipment()
    {
        return $this->belongsToMany(Equipment::class, 'equipment_char_map');
    }

    public function group()
    {
        return $this->belongsTo(EquipmentCharGroup::class);
    }

    public function measure()
    {
        return $this->belongsTo(EquipmentCharMeasure::class);
    }
}
