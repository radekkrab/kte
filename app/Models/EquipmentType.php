<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentType extends Model
{
    use HasFactory;
    use Filterable;

    protected $table = 'equipment_types';

    protected $fillable = [
        'name',
        'masksn',
    ];
}
