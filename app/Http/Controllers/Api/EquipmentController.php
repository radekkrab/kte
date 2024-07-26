<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Http\Resources\EquipmentResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equioments = Equipment::paginate(7);

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

            $success[] = $item;
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
    public function update(UpdateEquipmentRequest $request, Equipment $equipment)
    {
        //
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
