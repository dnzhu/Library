<?php

//已被百度收录则输出收录，否则输出未收录

function checkBaidu($url){
    $url='http://www.baidu.com/s?wd='.$url;
    $curl=curl_init();
    curl_setopt($curl,CURLOPT_URL,$url);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
    $rs=curl_exec($curl);
    curl_close($curl);
    $arr=parse_url($url);
    if(strpos($arr['query'],'http://')){
      $arr['query']=str_replace('http://','',str_replace('wd=','',$arr['query']));
    }else{
      $arr['query']=str_replace('wd=','',$arr['query']);
    }
    if(strpos($arr['query'],'?')){
      $str=strstr($arr['query'],'?');
      $arr['query']=str_replace($str,'',$arr['query']);
    }
    if(strpos($arr['query'],'/')){
      $narr=explode('/',$arr['query']);
      $arr['query']=$narr[0];
    }
    if(strpos($rs,'<b>'.$arr['query'].'</b>')){
      return '收录';
    }else{
      return '未收录';
    }
}
echo checkBaidu('www.jingwentian.com');
?>
