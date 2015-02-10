<?php 

//Human readable filesize

/**
 * Returns a human readable filesize
 */
function HumanReadableFilesize($size) {
 
    // Adapted from: http://www.php.net/manual/en/function.filesize.php
 
    $mod = 1024;
 
    $units = explode(' ','B KB MB GB TB PB');
    for ($i = 0; $size > $mod; $i++) {
        $size /= $mod;
    }
 
    return round($size, 2) . ' ' . $units[$i];
}

print HumanReadableFilesize(filesize('test_2mb.zip'));

//---------------------------------------------------------------------------------------------

//A easy way to check the file size

function StringSizeToBytes($Size){
 
    $Unit = strtolower($Size);
    $Unit = preg_replace('/[^a-z]/', '', $Unit);
 
    $Value = intval(preg_replace('/[^0-9]/', '', $Size));
 
    $Units = array('b'=>0, 'kb'=>1, 'mb'=>2, 'gb'=>3, 'tb'=>4);
    $Exponent = isset($Units[$Unit]) ? $Units[$Unit] : 0;
 
    return ($Value * pow(1024, $Exponent));            
}

// Example usage:
// Check if a file is bigger than 10 MB
 
if (filesize('example.zip') > StringSizeToBytes('10 MB')){
    print 'File is to big !';
}
else {
    print 'File is okay';
}
