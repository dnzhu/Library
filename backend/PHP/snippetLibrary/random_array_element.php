<?php

function random_array_element(&$a){
 
    mt_srand((double)microtime()*1000000);  
 
    // get all array keys:
    $k = array_keys($a);
 
    // find a random array key:
    $r = mt_rand(0, count($k)-1);
    $rk = $k[$r];
 
    // return the random key (if exists):
    return isset($a[$rk]) ? $a[$rk] : '';
}

// works with both array types:
$array = array(1,2,3);
 
// and also:
$array = array('one' => 1, 'two' => 2, 'three' => 3);
 
// example:
print random_array_element($array);
