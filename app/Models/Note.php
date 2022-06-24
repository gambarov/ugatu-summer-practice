<?php

namespace App\Models;

use App\Models\Equipment\Equipment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'text',
        'equipment_id',
        'employee_id',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
