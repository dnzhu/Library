<?php 

/**
 * PHP网址缩短代码
 * http://www.sjyhome.com/php/shorturl.html
 */

function urlShort($url){
    $url= crc32($url);
    $result= sprintf("%u", $url);
    $sUrl= '';
    while($result>0){
        $s= $result%62;
        if($s>35){
            $s= chr($s+61);
        } elseif($s>9 && $s<=35){
            $s= chr($s+ 55);
        }
        $sUrl.= $s;
        $result= floor($result/62);
    }
    return $sUrl;
} 


$url = 'www.jingwentian.com';
$sUrl = urlShort($url);

echo '原网址：'.$url;
echo '缩短后：'.$sUrl; 
