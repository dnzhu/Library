<?php 

/**
 * PHP日历函数 
 */

cal_days_in_month() // — 返回某个历法中某年中某月的天数
//如同:
function cal_days_in_month($calendar=1, $month, $year) { 
  return date('t', mktime(0, 0, 0, $month, 1, $year)); 
} 
cal_info() // — 返回选定历法的信息

//-------------------------------------------------

#Example 1

$num = cal_days_in_month(CAL_GREGORIAN, 11, 2014); // 30
echo "There was $num days in November 2014";

#Example 2

$info = cal_info(0);
print_r($info);

//Results
Array
(
    [months] => Array
        (
            [1] => January
            [2] => February
            [3] => March
            [4] => April
            [5] => May
            [6] => June
            [7] => July
            [8] => August
            [9] => September
            [10] => October
            [11] => November
            [12] => December
        )

    [abbrevmonths] => Array
        (
            [1] => Jan
            [2] => Feb
            [3] => Mar
            [4] => Apr
            [5] => May
            [6] => Jun
            [7] => Jul
            [8] => Aug
            [9] => Sep
            [10] => Oct
            [11] => Nov
            [12] => Dec
        )

    [maxdaysinmonth] => 31
    [calname] => Gregorian
    [calsymbol] => CAL_GREGORIAN
)

