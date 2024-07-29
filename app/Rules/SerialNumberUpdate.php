<?php

namespace App\Rules;

use App\Models\EquipmentType;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class SerialNumberUpdate implements DataAwareRule, ValidationRule
{
    protected $equipment_type_id = [];
        
    protected $mask = [];

   /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->equipment_type_id = $data[0];
 
        return $this;
    }
    
    private function getRegexp($id): string {
        $i = 0;
        $genRegexp = [
            'N' => '\d',
            'A' => '[A-Z]',
            'a' => '[a-z]',
            'X' => '[A-Z0-9]',
            'x' => '[-_@]',
        ];
        $regexp = '';
        foreach (str_split($id) as $char) {
            $regexp .= $genRegexp[$char] ?? ''; // Using null coalescing operator to handle undefined characters
        }
        return $regexp;
    }
  

        /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {  
        $this->mask = EquipmentType::find($this->equipment_type_id["equipment_type_id"]);
        $regexp = $this->getRegexp($this->mask["masksn"]);
        if (!preg_match('/' . $regexp . '/', $value)) {
            $fail('The :attribute must match the specified pattern.');
        }
    }
}
