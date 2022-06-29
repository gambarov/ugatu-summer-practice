<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Char\CharMeasureResource;
use App\Models\Equipment\CharMeasure;
use Illuminate\Http\Request;

class CharMeasureController extends Controller
{
    public function index()
    {
        return CharMeasureResource::collection(CharMeasure::all());
    }
}
