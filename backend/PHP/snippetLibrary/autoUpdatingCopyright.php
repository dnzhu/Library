<?php 

//Auto updating copyright
//A short function that helps you keeping the current year in your copyright sentence.

function autoUpdatingCopyright($startYear){
 
    // given start year (e.g. 2004)
    $startYear = intval($startYear);
 
    // current year (e.g. 2007)
    $year = intval(date('Y'));
 
    // is the current year greater than the
    // given start year?
    if ($year > $startYear)
        return $startYear .'-'. $year;
    else
        return $startYear;
}

print '&copy; ' . autoUpdatingCopyright(2001) . ' Jonas John';
 
/*
Output:
 
(c) 2001-2007 Jonas John
 
*/
