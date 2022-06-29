<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Audience\AudienceTypeResource;
use App\Models\Equipment\AudienceType;
use Illuminate\Http\Request;

class AudienceTypeController extends Controller
{
    public function index()
    {
        return AudienceTypeResource::collection(AudienceType::all());
    }
}
