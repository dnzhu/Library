<?php

//With this function you can convert a normal HEX-color (like #FF00FF) into it's RGB values (Array(179,218,245)).

function Hex2RGB($color){
    $color = str_replace('#', '', $color);
    if (strlen($color) != 6){ return array(0,0,0); }
    $rgb = array();
    for ($x=0;$x<3;$x++){
        $rgb[$x] = hexdec(substr($color,(2*$x),2));
    }
    return $rgb;
}
 
// Example usage:
print_r(Hex2RGB('#B3DAF5'));
 
/*
Returns an array (R,G,B):
 
Array
(
    [0] => 179
    [1] => 218
    [2] => 245
)
*/

//This function inverses a color to it's opposite.
//(White to black, blue to yellow, etc.)
 
function color_inverse($color){
    $color = str_replace('#', '', $color);
    if (strlen($color) != 6){ return '000000'; }
    $rgb = '';
    for ($x=0;$x<3;$x++){
        $c = 255 - hexdec(substr($color,(2*$x),2));
        $c = ($c < 0) ? 0 : dechex($c);
        $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
    }
    return '#'.$rgb;
}
