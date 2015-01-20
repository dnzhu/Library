<?php
//This function returns a random file from a given folder. It also allows extension filtering.
function RandomFile($folder='', $extensions='.*'){
 
    // fix path:
    $folder = trim($folder);
    $folder = ($folder == '') ? './' : $folder;
 
    // check folder:
    if (!is_dir($folder)){ die('invalid folder given!'); }
 
    // create files array
    $files = array();
 
    // open directory
    if ($dir = @opendir($folder)){
 
        // go trough all files:
        while($file = readdir($dir)){
 
            if (!preg_match('/^\.+$/', $file) and 
                preg_match('/\.('.$extensions.')$/', $file)){
 
                // feed the array:
                $files[] = $file;                
            }            
        }        
        // close directory
        closedir($dir);    
    }
    else {
        die('Could not open the folder "'.$folder.'"');
    }
 
    if (count($files) == 0){
        die('No files where found :-(');
    }
 
    // seed random function:
    mt_srand((double)microtime()*1000000);
 
    // get an random index:
    $rand = mt_rand(0, count($files)-1);
 
    // check again:
    if (!isset($files[$rand])){
        die('Array index was not found! very strange!');
    }
 
    // return the random file:
    return $folder . $files[$rand];
 
}

// "jpg|png|gif" matches all files with these extensions
print RandomFile('test_images/','jpg|png|gif');
// returns test_07.gif
 
// ".*" matches all extensions (all files)
print RandomFile('test_files/','.*');
// returns foobar_1.zip
 
// "[0-9]+" matches all extensions that just 
// contain numbers (like backup.1, backup.2)
print RandomFile('test_files/','[0-9]+');
// returns backup.7
