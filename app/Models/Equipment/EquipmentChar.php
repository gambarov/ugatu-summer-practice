<?php

namespace App\Models\Equipment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EquipmentChar extends Pivot
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'equipment_id',
        'char_id',
        'value',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }

    public function char()
    {
        return $this->belongsTo(Char::class, 'char_id');
    }
}
