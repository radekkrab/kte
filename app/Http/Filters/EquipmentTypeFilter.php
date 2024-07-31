<?php


namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;

class EquipmentTypeFilter extends AbstractFilter
{
    public const ID = 'id';
    public const NAME = 'name';
    public const MASKSN = 'masksn';

    protected function getCallbacks(): array
    {
        return [
            self::ID => [$this, 'id'],
            self::NAME => [$this, 'name'],
            self::MASKSN => [$this, 'masksn'],
        ];
    }

    public function id(Builder $builder, $value)
    {
        $builder->where('id', $value);
    }

    public function name(Builder $builder, $value)
    {
        $builder->where('name', 'like', "%{$value}%");
    }

    public function masksn(Builder $builder, $value)
    {
        $builder->where('masksn', 'like', "%{$value}%");
    }

}
