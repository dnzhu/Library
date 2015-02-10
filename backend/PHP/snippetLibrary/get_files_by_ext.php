<?php 

//Files by extension

function get_files_by_ext($path, $ext){
 
    $files = array();
 
    if (is_dir($path)){
        $handle = opendir($path); 
        while ($file = readdir($handle)) { 
            if ($file[0] == '.'){ continue; }
            if (is_file($path.$file) and preg_match('/\.'.$ext.'$/', $file)){ 
                $files[] = $file;
            } 
        }
        closedir($handle);
        sort($files);
    }
 
    return $files;
 
}
 
/*
** Example:
*/
 
print_r(get_files_by_ext('data/', 'txt'));
