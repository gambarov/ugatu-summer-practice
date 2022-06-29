<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Work\WorkStatusResource;
use App\Models\Equipment\WorkStatus;
use Illuminate\Http\Request;

class WorkStatusController extends Controller
{
    public function index()
    {
        return WorkStatusResource::collection(WorkStatus::all());
    }
}
