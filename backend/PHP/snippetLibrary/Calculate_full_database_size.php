<?php

//Calculates the total size of a MySQL database in KB/MB or GB...


function CalcFullDatabaseSize($database, $db) {
 
    $tables = mysql_list_tables($database, $db);
    if (!$tables) { return -1; }
 
    $table_count = mysql_num_rows($tables);
    $size = 0;
 
    for ($i=0; $i < $table_count; $i++) {
        $tname = mysql_tablename($tables, $i);
        $r = mysql_query("SHOW TABLE STATUS FROM ".$database." LIKE '".$tname."'");
        $data = mysql_fetch_array($r);
        $size += ($data['Index_length'] + $data['Data_length']);
    };
 
    $units = array(' B', ' KB', ' MB', ' GB', ' TB');
    for ($i = 0; $size > 1024; $i++) { $size /= 1024; }
    return round($size, 2).$units[$i];
}

/*
** Example:
*/
 
// open mysql connection:
$handle = mysql_connect('localhost', 'user', 'password'); 
 
if (!$handle) { die('Connection failed!'); }
 
// get the size of all tables in this database:
print CalcFullDatabaseSize('customer1234', $handle);
// --> returns something like: 484.2 KB
 
// close connection:
mysql_close($handle);
