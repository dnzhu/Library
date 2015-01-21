<?php
//Saves the phpinfo() page to an file

function PHPInfo2File($target_file){
 
    ob_start();
    phpinfo();
    $info = ob_get_contents();
    ob_end_clean();
 
    $fp = fopen($target_file, "w+");
    fwrite($fp, $info);
    fclose($fp);
}

//OR
ob_start();
phpinfo();
file_put_contents($filename, ob_get_clean());
