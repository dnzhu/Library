<?php

/**
 * 导出CSV格式文件
 */


//方法1：

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=file.csv");
// Disable caching
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

function outputCSV($data) {
    $output = fopen("php://output", "w");
    foreach ($data as $row) {
        fputcsv($output, $row); // here you can change delimiter/enclosure
    }
    fclose($output);
}

outputCSV(array(
    array("name 1", "age 1", "city 1"),
    array("name 2", "age 2", "city 2"),
    array("name 3", "age 3", "city 3")
));

//方法2：

function download_csv_results($results, $name = NULL)
{
    if( ! $name)
    {
        $name = md5(uniqid() . microtime(TRUE) . mt_rand()). '.csv';
    }

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename='. $name);
    header('Pragma: no-cache');
    header("Expires: 0");

    $outstream = fopen("php://output", "w");

    foreach($results as $result)
    {
        fputcsv($outstream, $result);
    }

    fclose($outstream);
}

download_csv_results($results_arr, 'your_name_here.csv');


//Reference: http://stackoverflow.com/questions/217424/create-a-csv-file-for-a-user-in-php


