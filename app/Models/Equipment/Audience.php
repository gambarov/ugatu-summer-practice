<?php

namespace App\Models\Equipment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audience extends Model
{
    use HasFactory;

    protected $with = ['type'];

    protected $guarded = ['id'];

    protected $fillable = [
        'building',
        'number',
        'letter',
        'audience_type_id',
    ];

    public function equipment() {
        return $this->belongsToMany(Equipment::class, 'placements')
            ->withPivot(['placed_at', 'removed_at'])
            ->using(Placement::class)
            ->as('placements');
    }

    public function type() {
        return $this->belongsTo(AudienceType::class, 'audience_type_id');
    }
}
