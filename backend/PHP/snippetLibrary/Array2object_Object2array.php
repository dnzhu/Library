<?php 

//Array2object and Object2array
//Convert an associative array to an anonymous object and vice versa.

function array2object($array) {
 
    if (is_array($array)) {
        $obj = new StdClass();
 
        foreach ($array as $key => $val){
            $obj->$key = $val;
        }
    }
    else { $obj = $array; }
 
    return $obj;
}
 
function object2array($object) {
    if (is_object($object)) {
        foreach ($object as $key => $value) {
            $array[$key] = $value;
        }
    }
    else {
        $array = $object;
    }
    return $array;
}
 
 
// example:
 
$array = array('foo' => 'bar', 'one' => 'two', 'three' => 'four');
 
$obj = array2object($array);
 
print $obj->one; // output's "two"
 
$arr = object2array($obj);
 
print $arr['foo']; // output's bar
