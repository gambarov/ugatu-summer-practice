<?php

namespace App\Models\Equipment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkType extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    protected $fillable = [
        'name'
    ];

    public function works()
    {
        return $this->hasMany(Work::class);
    }
}
