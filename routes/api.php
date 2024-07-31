<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/equipment', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::resource('equipment', \App\Http\Controllers\Api\EquipmentController::class)->except(['create', 'edit']);

Route::get('equipment-type', [\App\Http\Controllers\Api\EquipmentTypeController::class, 'index']);