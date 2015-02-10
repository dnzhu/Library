<?php
//On this way you can find out how long a page needs to load.

$start = time();
 
// put a long operation in here
sleep(5);
 
 
$diff = time() - $start;
 
print "This page needed $diff seconds to load :-)";

//-----------------------------------------------------------------------------------------------------------------------------------

// if you want a more exact value, you could use the microtime function

// mt_get: returns the current microtime
function mt_get(){
    global $mt_time;
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}
 
// mt_start: starts the microtime counter
function mt_start(){
    global $mt_time; $mt_time = mt_get();
}
 
// mt_end: calculates the elapsed time
function mt_end($len=4){
    global $mt_time;
    $time_end = mt_get();
    return round($time_end - $mt_time, $len);
}

// start timer:
mt_start();
 
 
// put a long operation or 
// something similar in here:
for ($x=0; $x < 50000; $x++){
    print ($x % 2) ? '<!-- foo -->' : '';
}
 
 
// calculate elapsed time
$time = mt_end();
 
 
print "<br/><br/>The page needed ".$time." seconds to load.";


