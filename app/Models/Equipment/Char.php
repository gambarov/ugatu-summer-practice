<?php

namespace App\Models\Equipment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Char extends Model
{
    use HasFactory;

    protected $with = ['group', 'measure'];

    protected $guarded = ['id'];
    
    protected $fillable = [
        'name',
        'value',
        'char_group_id',
        'char_measure_id',
    ];

    public function equipment()
    {
        return $this->belongsToMany(Equipment::class, 'equipment_char', 'char_id', 'equipment_id')
            ->withPivot('value')
            ->withTimestamps();
    }

    public function group()
    {
        return $this->belongsTo(CharGroup::class, 'char_group_id');
    }

    public function measure()
    {
        return $this->belongsTo(CharMeasure::class, 'char_measure_id');
    }
}
