<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Char\CharGroupResource;
use App\Models\Equipment\CharGroup;
use Illuminate\Http\Request;

class CharGroupController extends Controller
{
    public function index()
    {
        return CharGroupResource::collection(CharGroup::all());
    }
}
