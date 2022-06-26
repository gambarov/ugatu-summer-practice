<?php

namespace App\Models\Equipment;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    use HasFactory;

    protected $with = ['employee'];

    protected $guarded = ['id'];
    
    protected $fillable = [
        'name',
        'inventory_id',
        'employee_id',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function equipment()
    {
        return $this->belongsToMany(Equipment::class, 'equipment_set');
    }

    public function works()
    {
        return $this->morphMany(Work::class, 'workable');
    }
}
