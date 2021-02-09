<?php
namespace Exceedone\Exment\Services\ViewFilter\Items\DayBeforeAfter;

use Exceedone\Exment\Enums\FilterOption;
use Carbon\Carbon;

class DayOnOrBefore extends DayBeforeAfterBase
{
    public static function getFilterOption()
    {
        return FilterOption::DAY_ON_OR_BEFORE;
    }

    protected function getTargetDay($query_value)
    {
        return Carbon::parse($query_value);
    }
    
    protected function getMark() : string
    {
        return "<=";
    }
    

    /**
     * compare 2 value
     *
     * @param mixed $value
     * @param mixed $conditionValue condition value. Sometimes, this value is not set(Ex. check value is not null)
     * @return boolean is match, return true
     */
    protected function _compareValue($value, $conditionValue) : bool{
        $condition_dt = \Carbon\Carbon::parse($conditionValue)->addDays(1);
        return \Exment::getCarbonOnlyDay($value)->lt($condition_dt);
    }
}
