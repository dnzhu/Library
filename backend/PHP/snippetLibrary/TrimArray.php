<?php 

//Trim array (recursive)

/**
 * Trims a entire array recursivly.
 * @param       array      $Input      Input array
 */
function TrimArray($Input){
 
    if (!is_array($Input))
        return trim($Input);
 
    return array_map('TrimArray', $Input);
}

$DirtyArray = array(
    'Key1' => ' Value 1 ',
    'Key2' => '      Value 2      ',
    'Key3' => array(
        '   Child Array Item 1 ', 
        '   Child Array Item 2'
    )
);
 
$CleanArray = TrimArray($DirtyArray);
 
var_dump($CleanArray);
