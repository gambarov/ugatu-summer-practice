<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Work\WorkTypeResource;
use App\Models\Equipment\WorkType;
use Illuminate\Http\Request;

class WorkTypeController extends Controller
{
    public function index()
    {
        return WorkTypeResource::collection(WorkType::all());
    }
}
