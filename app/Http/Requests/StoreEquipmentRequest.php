<?php

namespace App\Http\Requests;

use App\Rules\SerialNumber;
use Illuminate\Foundation\Http\FormRequest;

class StoreEquipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            '*' => 'array',
            '*.equipment_type_id' => 'required|integer|exists:equipment_types,id',
            '*.sn' => ['required', 'string', 'unique:equipment,sn', new SerialNumber($this->input('*.equipment_type_id'))],
            '*.comment' => 'string|nullable',
        ];
    }
}
