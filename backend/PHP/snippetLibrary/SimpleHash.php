<?php 

//Simple hand-made hash function
//This example shows how to create a one-way encryption method by using a very simplified algorithm.

function SimpleHash($str){    
 
    $n = 0;
 
    // The magic happens here:
    // I just loop trough all letters and add the
    // ASCII value to a integer variable. 
    for ($c=0; $c < strlen($str); $c++)
        $n += ord($str[$c]);
 
    // After we went trough all letters
    // we have a number that represents the
    // content of the string
 
    return $n;
}

$TestString = 'www.jingwentian.com';
 
print SimpleHash($TestString); 
