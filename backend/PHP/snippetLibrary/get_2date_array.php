<?php

//如何获取2个时间段之内的日期

$start = '2014-11-17';
$end = date('Y-m-d', strtotime('-1 day'));

// 获取start 和end 之间的日期数组
$xAxis = array();
$start = new \DateTime($start);
$interval = new \DateInterval('P1D');
$end = new \DateTime($end);
$period = new \DatePeriod($start, $interval, $end->modify('+1 day'));
foreach ($period as $date) {
  $xAxis[] = $date->format('Y-m-d');
}

print_r($xAxis);
