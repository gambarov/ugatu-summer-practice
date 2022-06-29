<?php

namespace App\Models\Equipment;

use App\Models\Note;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $with = ['type'];

    protected $guarded = ['id'];

    protected $fillable = [
        'inventory_id',
        'name',
        'equipment_type_id',
    ];

    public function type()
    {
        return $this->belongsTo(EquipmentType::class, 'equipment_type_id');
    }

    public function chars()
    {
        return $this->belongsToMany(Equipment::class, 'equipment_char', 'equipment_id', 'char_id')
            ->withPivot('value')
            ->withTimestamps();
    }

    public function audiences()
    {
        return $this->belongsToMany(Audience::class, 'placements')
            ->withPivot('id', 'placed_at', 'removed_at')
            ->using(PLacement::class)
            ->as('placements');
    }

    public function currentAudience()
    {
        return $this->audiences()->orderBy('id', 'desc')->first();
    }

    public function currentPlacement() {
        return $this->currentAudience()->placements->latest('placed_at')->first();
    }    

    public function sets()
    {
        return $this->belongsToMany(Set::class, 'equipment_set');
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function works() 
    {
        return $this->morphMany(Work::class, 'workable');
    }
}
