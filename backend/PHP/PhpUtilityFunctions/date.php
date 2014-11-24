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


//---------------------------------------------------------------------------------------------------

/**
 *
 * 统计软件与文章等月、周、当天排行
 * $field_id(文章ID)
 */
//统计月、周、当天排行的方法
require_once(dirname(__FILE__)."/../include/common.inc.php");
function countdown($field_id){
date_default_timezone_set('Asia/Shanghai'); //设置默认时区
global $dsql;
$re_total = 1;
$tableName = '#@__tongji';
$nowDateArray  = getdate(time());
$sql_tongji = "select * from `$tableName` where aid=$field_id";
$rs = $dsql->ExecuteNoneQuery2($sql_tongji);
//如果不存在此篇文章信息,则新插入一条
if($rs <= 0){
//获取栏目ID值
$sql_typeid = "select typeid from `#@__archives` where id=$field_id";
$t_row = $dsql->GetOne($sql_typeid);
$query = " INSERT INTO `$tableName` VALUES($field_id,$t_row[typeid],1,1,1,1,$nowDateArray[0]); ";
$dsql->ExecNoneQuery($query);
}else{
 $result = $dsql->GetOne($sql_tongji);
 $oldTimeStamp = $result['lasttime'];   //最后点击时间 
 $m_total =      $result['m_total'];    //月点击
 $w_total =      $result['w_total'];    //周点击
 $d_total =      $result['d_total'];    //日点击 
 $t_total =      $result['t_total'];    //总点击 
 $oldDateArray   =  getdate($oldTimeStamp); 
 
 //统计当月
if($nowDateArray["year"] == $oldDateArray["year"] && $nowDateArray["mon"] == $oldDateArray["mon"]){
  $m_total++;
 }else{
  $m_total = 1; 
 }
 
//统计本周
$tmpStartDate = mktime(0,0,0,$nowDateArray[ "mon"],$nowDateArray[ "mday"],$nowDateArray[ "year"]) - ($nowDateArray[ "wday "] * 86400); 
$tmpEndDate = mktime(23,59,59,$nowDateArray[ "mon"],$nowDateArray[ "mday"],$nowDateArray[ "year"]) + ((6 - $nowDateArray[ "wday"]) * 86400); 
if($oldTimeStamp >= $tmpStartDate && $oldTimeStamp <= $tmpEndDate){
  $w_total++; 
}else{
  $w_total = 1;     
}
 
//统计今日
$dayStart   =mktime(0,0,0,$nowDateArray[ "mon"],$nowDateArray[ "mday"],$nowDateArray[ "year"]);  //当天开始时间戳
$dayEnd   =mktime(23,59,59,$nowDateArray[ "mon"],$nowDateArray[ "mday"],$nowDateArray[ "year"]); //当天结束时间戳
if($oldTimeStamp >= $dayStart && $oldTimeStamp <= $dayEnd){
  $d_total++;
}else{
  $d_total = 1;
}
 $t_total++;
//更新统计数
 $dsql->ExecuteNoneQuery("update $tableName set m_total=$m_total,w_total=$w_total,d_total=$d_total,t_total=$t_total,lasttime=$nowDateArray[0] where aid=$field_id");
 $dsql->ExecuteNoneQuery("update dede_archives set click=$t_total where id=$field_id");
 $re_total = $t_total;
}
return $re_total;
}
 
countdown($aid); //方法调用
 
/*
//mysql表结构
 
CREATE TABLE IF NOT EXISTS `dede_tongji` (
  `aid` int(11) NOT NULL,
  `cid` smallint(5) NOT NULL,
  `tid` smallint(5) NOT NULL,
  `m_total` int(11) NOT NULL DEFAULT '1',
  `w_total` int(11) NOT NULL DEFAULT '1',
  `d_total` int(11) NOT NULL DEFAULT '1',
  `t_total` int(11) NOT NULL DEFAULT '1',
  `lasttime` int(12) NOT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
*/


//---------------------------------------------------------------------------------------------------

//php获取今日开始时间戳和结束时间戳
 
$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
 
$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
 
//php获取昨日起始时间戳和结束时间戳
 
$beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
 
$endYesterday=mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
 
//php获取上周起始时间戳和结束时间戳
 
$beginLastweek=mktime(0,0,0,date('m'),date('d')-date('w')+1-7,date('Y'));
 
$endLastweek=mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y'));
 
//php获取本月起始时间戳和结束时间戳
 
$beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
 
$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));


//---------------------------------------------------------------------------------------------------







?>
