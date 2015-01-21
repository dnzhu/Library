<?php
/*
This function helps you checking a UNIX timestamp with 
human readable time formats like 1m, 2d or 4y.
[ (s)econds, (m)inutes, (d)ays, (y)ears ]*/

function time_is_older_than($t, $check_time){
 
    $t = strtolower($t);
    $time_type = substr(preg_replace('/[^a-z]/', '', $t), 0, 1);
    $val = intval(preg_replace('/[^0-9]/', '', $t));
    $ts = 0;
 
    // (s)econds, (m)inutes, (d)ays, (y)ears
    if ($time_type == 's'){ $ts = $val; }
    else if ($time_type == 'm'){ $ts = $val * 60; }
    else if ($time_type == 'h'){ $ts = $val * 60 * 60; }
    else if ($time_type == 'd'){ $ts = $val * 60 * 60 * 24; }
    else if ($time_type == 'y'){ $ts = $val * 60 * 60 * 24 * 365; }
    else { die('Unknown time format given!'); }
 
    if ($check_time < (time()-$ts)){ return true; }
 
    return false;
}

// timestamp to test: 
// (could be from an database or something else)
$time = 1146722922;
 
// long if check:
if (time_is_older_than('30m', $time)){
    print 'The given timestamp: ' . date('l dS \of F Y h:i:s A',$time);
    print " - is older than 30 minutes<br/>\n";
}
else {
    print 'The given timestamp: ' . date('l dS \of F Y h:i:s A',$time);
    print " - is NOT older than 30 minutes<br/>\n";
}
 
// short checks:
 
if (time_is_older_than('10s', $time)){ print "Is older than 10 seconds<br/>\n"; }
 
if (time_is_older_than('200m', $time)){ print "Is older than 200 minutes<br/>\n"; }
 
if (time_is_older_than('2h', $time)){ print "Is older than 2 hours<br/>\n"; }
 
if (time_is_older_than('4d', $time)){ print "Is older than 4 days<br/>\n"; }
 
if (time_is_older_than('1y', $time)){ print "Is older than one year<br/>\n"; }
