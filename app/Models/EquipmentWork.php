<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentWork extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'equipment_work_type_id',
        'equipment_work_status_id',
        'started_at',
        'ended_at',
        'employee_id'
    ];
}
