<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    public function equipment() 
    {
        return $this->belongsTo(Equipment::class);
    }

    public function employee() 
    {
        return $this->belongsTo(Employee::class);
    }
}
