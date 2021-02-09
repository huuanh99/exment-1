<?php
namespace Exceedone\Exment\Services\ViewFilter\Items\DayBeforeAfter;

use Exceedone\Exment\Enums\FilterOption;
use Carbon\Carbon;

class DayNextXDayOrBefore extends DayBeforeAfterBase
{
    public static function getFilterOption()
    {
        return FilterOption::DAY_NEXT_X_DAY_OR_BEFORE;
    }

    protected function getTargetDay($query_value)
    {
        $today =  Carbon::today();
        return $today->addDay(intval($query_value));
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
        $today = \Carbon\Carbon::today();
        $target_day = $today->addDay(intval($conditionValue));
        return \Exment::getCarbonOnlyDay($value)->lte($target_day);
    }
}
