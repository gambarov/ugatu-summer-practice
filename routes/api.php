<?php

use App\Http\Controllers\API\V1\AudienceController;
use App\Http\Controllers\API\V1\AudienceTypeController;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\CharController;
use App\Http\Controllers\API\V1\CharGroupController;
use App\Http\Controllers\API\V1\CharMeasureController;
use App\Http\Controllers\API\V1\EmployeeController;
use App\Http\Controllers\API\V1\EquipmentController;
use App\Http\Controllers\API\V1\EquipmentTypeController;
use App\Http\Controllers\API\V1\PlacementController;
use App\Http\Controllers\API\V1\SetController;
use App\Http\Controllers\API\V1\NoteController;
use App\Http\Controllers\API\V1\WorkController;
use App\Http\Controllers\API\V1\WorkStatusController;
use App\Http\Controllers\API\V1\WorkTypeController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/equipment/types', [EquipmentTypeController::class, 'index']);
    Route::get('/work/statuses', [WorkStatusController::class, 'index']);
    Route::get('/work/types', [WorkTypeController::class, 'index']);
    Route::get('/audience/types', [AudienceTypeController::class, 'index']);
    Route::get('/char/groups', [CharGroupController::class, 'index']);
    Route::get('/char/measures', [CharMeasureController::class, 'index']);

    Route::apiResource('/chars', CharController::class, [
        'only' => ['index', 'store', 'show', 'update', 'destroy'],
    ]);

    Route::get('/equipment/{id}/chars', [EquipmentController::class, 'chars']);
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

    Route::post('/notes/search', [NoteController::class, 'search']);
    Route::get('/notes/equipment/{id}', [NoteController::class, 'equipment']);
    Route::get('/notes/employee/{id}', [NoteController::class, 'employee']);
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
