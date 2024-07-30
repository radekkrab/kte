<?php


namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;

class EquipmentFilter extends AbstractFilter
{
    public const SN = 'sn';
    public const COMMENT = 'comment';

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

}
