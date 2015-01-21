<?php 
// Include Class
include 'lib/ArrayToXml.php';

$data = readFileStr('./sitemap.xml');

// XML TO ARRAY
$arr = ArrayToXML::toArray($data);

//ARRAY TO XML
$xml = ArrayToXML::toXML($arr);

writeFileStr('test.xml', $xml, false);


// 通用方法 ---------------------------

// 读取文件
function readFileStr($filename){
    $fp=fopen($filename,"r"); 
    $content=fread($fp,filesize($filename));//读文件 
    fclose($fp); 
    return $content;
}

// 写入文件
function writeFileStr($filename, $content, $append = true) {

	if ($append) {
		file_put_contents($filename, $content, FILE_APPEND|LOCK_EX);
	} else { 
		file_put_contents($filename, $content, LOCK_EX);
	}
	
	if (file_exists($filename) && !is_writeable($filename)){ 
        return false;
    } else {
		return true;
	}
	
}

