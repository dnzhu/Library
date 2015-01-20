<?php

//Checks if a IP adress has a valid format
 
function IsIPValid($ip){
 
    if (preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $ip)){
        return true;
    }
 
    return false;
}

// examples:
 
var_dump(IsIPValid('192.168.100.1'));
// => bool(true)
 
var_dump(IsIPValid('192...1'));
// => bool(false)
 
var_dump(IsIPValid('127001'));
// => bool(false)
 
var_dump(IsIPValid('127.0.0.1'));
// => bool(true)

