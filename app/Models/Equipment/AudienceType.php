<?php

namespace App\Models\Equipment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudienceType extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    protected $fillable = [
        'name',
    ];

    public function audiences()
    {
        return $this->hasMany(Audience::class);
    }
}
