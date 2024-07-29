<?php

namespace App\Http\Requests;

use App\Rules\SerialNumber;
use App\Rules\SerialNumberUpdate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEquipmentRequest extends FormRequest
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
            '*.sn' => ['required', 'string', new SerialNumberUpdate($this->get('*.equipment_type_id'))],
            '*.comment' => 'string|nullable',
        ];
    }
}
