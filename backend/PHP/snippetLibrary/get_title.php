<?php 

//PHP获取网页标题的代码

//1. 推荐方法 CURL获取

$c = curl_init();
$url = 'www.jingwentian.com';
curl_setopt($c, CURLOPT_URL, $url);
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($c);
curl_close($c);
$pos = strpos($data,'utf-8');
if($pos===false){$data = iconv("gbk","utf-8",$data);}
preg_match("/<title>(.*)<\/title>/i",$data, $title);
echo $title[1];

//2. 使用file()函数

$lines_array = file('http://www.jingwentian.com/');
$lines_string = implode('', $lines_array); 
$pos = strpos($lines_string,'utf-8');
if($pos===false){$lines_string = iconv("gbk","utf-8",$lines_string);}
eregi("<title>(.*)</title>", $lines_string, $title);
echo $title[1];

//3. 使用file_get_contents

$content=file_get_contents("http://www.jingwentian.com/");
$pos = strpos($content,'utf-8');
if($pos===false){$content = iconv("gbk","utf-8",$content);}
$postb=strpos($content,'<title>')+7;
$poste=strpos($content,'</title>');
$length=$poste-$postb;
echo substr($content,$postb,$length);
