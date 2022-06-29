<?php

use App\Http\Controllers\API\V1\AudienceController;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\EmployeeController;
use App\Http\Controllers\API\V1\EquipmentController;
use App\Http\Controllers\API\V1\PlacementController;
use App\Http\Controllers\API\V1\SetController;
use App\Http\Controllers\API\V1\NoteController;
use App\Http\Controllers\API\V1\WorkController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

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

    Route::get('placements/equipment/{id}', [PlacementController::class, 'equipment']);
    Route::apiResource('/placements', PlacementController::class, [
        'only' => ['index', 'store', 'show', 'update', 'destroy'],
    ]);

    Route::get('works/workable/{id}', [WorkController::class, 'workable']);
    Route::apiResource('/works', WorkController::class, [
        'only' => ['index', 'store', 'show', 'update', 'destroy'],
    ]);
});
