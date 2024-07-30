<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Filters\EquipmentFilter;
use App\Http\Requests\FilterRequest;
use App\Models\Equipment;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Http\Resources\EquipmentResource;
use App\Models\EquipmentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FilterRequest $request)
    {
        
        if ($request) {
            $data = $request->validated();
            $filter = app()->make(EquipmentFilter::class, ['queryParams' => array_filter($data)]);
            $equioments = Equipment::filter($filter)->paginate(7);
        } else {
            $equioments = Equipment::latest()->paginate(7);
        }      
        
        return EquipmentResource::collection($equioments);
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
    public function store(Request $request)
    {
        //dd($request->data);

        $equipments = new StoreEquipmentRequest($request->data);

        $validator = Validator::make($request->data, $equipments->rules());
        $errorsRequest = $validator->errors();
        $validated = $validator->valid();
        
        $success = [];


        foreach($validated as $item) {

            $equipment = Equipment::create([
                'equipment_type_id' => $item['equipment_type_id'],
                'sn' => $item['sn'],
                'comment' => $item['comment'] ?? null,
            ]);

            $success[] = new EquipmentResource(
                $equipment->load([
                    'equipmentType',
                ])
            );
        }

        $errors = (object)[];
        foreach($errorsRequest->messages() as $ue_key=>$ue_val) {
            $arr_key = explode('.', $ue_key);
            $key = $arr_key[0];
            $val = $arr_key[1];

            $errors->{$key}[] = str_replace($ue_key, $val, $ue_val[0]);
        }

        return response()->json((object)[
            'errors' => $errors,
            'success' => $success,
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $equipmentU = new UpdateEquipmentRequest($request->data);

        $validator = Validator::make($request->data, $equipmentU->rules());

        $errorsRequest = $validator->errors();
        $validated = $validator->valid();
        
        $success = [];


        foreach($validated as $item) {

            $equipment = Equipment::where('id', $id)->update([
                'equipment_type_id' => $item['equipment_type_id'],
                'sn' => $item['sn'],
                'comment' => $item['comment'] ?? null,
            ]);

            $updatedEquipment = Equipment::find($id);

            $success[] = new EquipmentResource(
                $updatedEquipment->load('equipmentType')
            );
        }

        $errors = (object)[];

        
        foreach($errorsRequest->messages() as $ue_key=>$ue_val) {
            
            $arr_key = explode('.', $ue_key);
            
            $key = $arr_key[0];
            $val = $arr_key[1];

            $errors->{$key}[] = str_replace($ue_key, $val, $ue_val[0]);
        }

        return response()->json((object)[
            'errors' => $errors,
            'success' => $success,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $equipment = Equipment::find($id);

        $equipment->delete();   

        return new EquipmentResource($equipment);
    }
}
