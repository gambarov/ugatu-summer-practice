<?php

use App\Http\Controllers\API\V1\AudienceController;
use App\Http\Controllers\API\V1\EmployeeController;
use App\Http\Controllers\API\V1\EquipmentController;
use App\Http\Controllers\API\V1\PlacementController;
use App\Http\Controllers\API\V1\SetController;
use App\Http\Controllers\API\V1\NoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
| These routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/equipment', EquipmentController::class, [
    'only' => ['index', 'store', 'show', 'update', 'destroy'],
]);

Route::apiResource('/sets', SetController::class, [
    'only' => ['index', 'store', 'show', 'update', 'destroy'],
]);

Route::apiResource('/audiences', AudienceController::class, [
    'only' => ['index', 'store', 'show', 'update', 'destroy'],
]);

Route::apiResource('/employees', EmployeeController::class, [
    'only' => ['index', 'store', 'show', 'update', 'destroy'],
]);

Route::apiResource('/notes', NoteController::class, [
    'only' => ['index', 'store', 'show', 'update', 'destroy'],
]);

Route::apiResource('/placements', PlacementController::class, [
    'only' => ['index', 'store'],
]);