<?php
//This function returns the last argument (filename or directory name) of an given path.

function path_get_last_arg($path){
    $path = str_replace('\\', '/', $path); 
    $path = preg_replace('/\/+$/', '', $path);
    $path = explode('/', $path);
    $l = count($path)-1;
    return isset($path[$l]) ? $path[$l] : '';
}

print path_get_last_arg('c:\\htdocs\\foobar\\file1.php');
// => returns 'file1.php'
 
print path_get_last_arg('/htdocs/usr1/web/');
// => returns 'web'
 
print path_get_last_arg('1/2/3/4');
// => returns '4'

