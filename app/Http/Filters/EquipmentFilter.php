<?php


namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;

class EquipmentFilter extends AbstractFilter
{
    public const SN = 'sn';
    public const COMMENT = 'comment';
    public const EQUIPMENT_TYPE_ID = 'equipment_type_id';

    protected function getCallbacks(): array
    {
        return [
            self::SN => [$this, 'sn'],
            self::COMMENT => [$this, 'comment'],
        ];
    }

    public function sn(Builder $builder, $value)
    {
        $builder->where('sn', $value);
    }

    public function comment(Builder $builder, $value)
    {
        $builder->where('comment', 'like', "%{$value}%");
    }

    public function equipment_type_id(Builder $builder, $value)
    {
        $builder->where('equipment_type_id', $value);
    }

}
