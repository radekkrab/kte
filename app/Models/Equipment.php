<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Filterable;

    protected $table = 'equipment';

    protected $fillable = [
        'equipment_type_id',
        'sn',
        'comment',
    ];

    public function equipmentType() {
        return $this->belongsTo(EquipmentType::class, 'equipment_type_id');
    }
    
}
