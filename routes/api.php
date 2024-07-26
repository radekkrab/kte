<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/equipment', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/equipment', [\App\Http\Controllers\Api\EquipmentController::class, 'store']);

Route::get('/equipment', [\App\Http\Controllers\Api\EquipmentController::class, 'index']);

Route::delete('/equipment/{id}', [\App\Http\Controllers\Api\EquipmentController::class, 'destroy']);

Route::get('/equipment-type', [\App\Http\Controllers\Api\EquipmentTypeController::class, 'index']);
