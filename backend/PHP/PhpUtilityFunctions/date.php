<?php

<?php

/**
 * 用php判断时间戳来输出刚刚/分钟前/小时前/昨天/时间
 * @Usage echo T("时间戳");
 */
function T($time)
{
   //获取今天凌晨的时间戳
   $day = strtotime(date('Y-m-d',time()));
   //获取昨天凌晨的时间戳
   $pday = strtotime(date('Y-m-d',strtotime('-1 day')));
   //获取现在的时间戳
   $nowtime = time();
    
   $tc = $nowtime-$time;
   if($time<$pday){
      $str = date('Y-m-d H:i:s',$time);
   }elseif($time<$day && $time>$pday){
      $str = "昨天";
   }elseif($tc>60*60){
      $str = floor($tc/(60*60))."小时前";
   }elseif($tc>60){
      $str = floor($tc/60)."分钟前";
   }else{
      $str = "刚刚";
   }
   return $str;
}
