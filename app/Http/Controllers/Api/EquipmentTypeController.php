<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Filters\EquipmentTypeFilter;
use App\Http\Requests\FilterTypeRequest;
use App\Models\EquipmentType;
use App\Http\Requests\StoreEquipmentTypeRequest;
use App\Http\Requests\UpdateEquipmentTypeRequest;
use App\Http\Resources\EquipmentTypeResource;

class EquipmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FilterTypeRequest $request)
    {
        if ($request) {
            $data = $request->validated();
            $filter = app()->make(EquipmentTypeFilter::class, ['queryParams' => array_filter($data)]);
            $equipmentTypes = EquipmentType::filter($filter)->get();
        } else {
            $equipmentTypes = EquipmentType::all();
        }        

        return EquipmentTypeResource::collection($equipmentTypes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquipmentTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EquipmentType $equipmentType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EquipmentType $equipmentType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipmentTypeRequest $request, EquipmentType $equipmentType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EquipmentType $equipmentType)
    {
        //
    }
}
