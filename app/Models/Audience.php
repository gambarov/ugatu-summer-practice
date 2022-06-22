<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audience extends Model
{
    use HasFactory;

    protected $with = ['type'];

    protected $fillable = [
        'building',
        'number',
        'letter',
    ];

    public function equipment() {
        return $this->belongsToMany(Equipment::class, 'equipment_audience_map');
    }

    public function type() {
        return $this->belongsTo(AudienceType::class);
    }
}
