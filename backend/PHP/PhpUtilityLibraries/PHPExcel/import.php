<?php 

error_reporting(0);
require_once 'common.php';
require_once 'libs/PHPExcel/PHPExcel.php';       
require_once 'libs/PHPExcel/PHPExcel/Writer/Excel5.php'; 
require_once 'libs/PHPExcel/PHPExcel/IOFactory.php';   

//use medoo orm
$result = $db->select('user',[
	'cnname',
	'mobile',
	'email',
	'qq'
]);

$resultPHPExcel = new PHPExcel();  
        
$resultPHPExcel->getActiveSheet()->setCellValue('A1', '序号');  
$resultPHPExcel->getActiveSheet()->setCellValue('B1', '姓名');  
$resultPHPExcel->getActiveSheet()->setCellValue('C1', '电话'); 
$resultPHPExcel->getActiveSheet()->setCellValue('D1', '邮箱');  
$resultPHPExcel->getActiveSheet()->setCellValue('E1', 'QQ');  
  
$i = 2;  
foreach($result as $key => $item){  
    $resultPHPExcel->getActiveSheet()->setCellValue('A' . $i, $key+1);  
    $resultPHPExcel->getActiveSheet()->setCellValue('B' . $i, $item['cnname']);  
    $resultPHPExcel->getActiveSheet()->setCellValue('C' . $i, $item['mobile']);  	
	$resultPHPExcel->getActiveSheet()->setCellValue('D' . $i, $item['email']?:'-');  
    $resultPHPExcel->getActiveSheet()->setCellValue('E' . $i, $item['qq']?:'-');  

    $i ++;  
}  

$outputFileName = 'total.xls';  
$xlsWriter = new PHPExcel_Writer_Excel5($resultPHPExcel);  
//ob_start();  ob_flush();  
header("Content-Type: application/force-download");  
header("Content-Type: application/octet-stream");  
header("Content-Type: application/download");  
header('Content-Disposition:inline;filename="'.$outputFileName.'"');  
header("Content-Transfer-Encoding: binary");  
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");  
header("Pragma: no-cache");  
  
$xlsWriter->save( "php://output" );  
