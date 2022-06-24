<?php

namespace App\Models\Equipment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentType extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    protected $fillable = [
        'name',
    ];

    public function equipment() {
        return $this->hasMany(Equipment::class);
    }
}
