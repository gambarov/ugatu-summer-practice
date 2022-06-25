<?php

use App\Http\Controllers\API\V1\AudienceController;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\EmployeeController;
use App\Http\Controllers\API\V1\EquipmentController;
use App\Http\Controllers\API\V1\PlacementController;
use App\Http\Controllers\API\V1\SetController;
use App\Http\Controllers\API\V1\NoteController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::patch('/equipment/{id}', [EquipmentController::class, 'update']);
Route::apiResource('/equipment', EquipmentController::class, [
    'only' => ['index', 'store', 'show', 'destroy'],
]);

Route::patch('/sets/{id}', [SetController::class, 'update']);
Route::apiResource('/sets', SetController::class, [
    'only' => ['index', 'store', 'show', 'destroy'],
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
    'only' => ['index', 'store', 'show'],
]);