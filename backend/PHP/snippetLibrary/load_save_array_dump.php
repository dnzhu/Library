<?php

//Load and save a array dump

function load_array_dump($filename) {
    $fp = fopen($filename,"r");
    $content = fread($fp,filesize($filename));
    fclose($fp);
 
    eval('$array='.gzuncompress(stripslashes($content)).';'); 
    return($array);
}
 
function save_array_dump($filename, $array) {
    $dump = addslashes(gzcompress(var_export($array,true),9));
    $fp = fopen($filename, "wb+");
    fwrite($fp, $dump);
    fclose($fp);
}

save_array_dump('test.txt', array(1,2,3));

$arr = load_array_dump('test.txt');

print_r($arr);
