<?php

namespace App\Models\Equipment;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = ['id'];
    
    protected $fillable = [
        'workable_id',
        'workable_type',
        'work_type_id',
        'work_status_id',
        'started_at',
        'ended_at',
        'employee_id'
    ];

    public function workable() {
        return $this->morphTo(__FUNCTION__, 'workable_type', 'workable_id');
    }

    public function type() {
        return $this->belongsTo(WorkType::class, 'work_type_id');
    }

    public function status() {
        return $this->belongsTo(WorkStatus::class, 'work_status_id');
    }

    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}
