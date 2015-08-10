<?php

echo "时间格式1：".date("Y-m-d H:i:s ")."<br>";// 2010-06-12 10:26:31   
echo "时间格式2：".date("y-M-D h:i:S ")."<br>";// 10-Jun-Sat 10:43:th   
echo "月份，英文全名：".date("F")."<br>";// June   
echo "月份，二位数字，补零：".date("m")."<br>";//  06  
echo "月份，二位数字，不补零：".date("n")."<br>";//  6  
echo "月份，三个英文：".date("M")."<br>";// Jun  
echo "星期几，英文全名：".date("l")."<br>";// Saturday  
echo "星期几，三个英文：".date("D")."<br>";// Sat  
echo "星期几，数字型：".date("w")."<br>";// 6  

/*
Y - 年，四位数字; 如: "1999"
y - 年，二位数字; 如: "99"
z - 一年中的第几天; 如: "0" 至 "365"
F - 月份，英文全名; 如: "January"
m - 月份，二位数字，若不足二位则在前面补零; 如: "01" 至 "12"
n - 月份，二位数字，若不足二位则不补零; 如: "1" 至 "12"
M - 月份，三个英文字母; 如: "Jan"
t - 指定月份的天数; 如: "28" 至 "31"
d - 几日，二位数字，若不足二位则前面补零; 如: "01" 至 "31"
j - 几日，二位数字，若不足二位不补零; 如: "1" 至 "31"
h - 12 小时制的小时; 如: "01" 至 "12"
H - 24 小时制的小时; 如: "00" 至 "23"
g - 12 小时制的小时，不足二位不补零; 如: "1" 至 12"
G - 24 小时制的小时，不足二位不补零; 如: "0" 至 "23"
i - 分钟; 如: "00" 至 "59"
s - 秒; 如: "00" 至 "59"
S - 字尾加英文序数，二个英文字母; 如: "th"，"nd"
U - 总秒数
D - 星期几，三个英文字母; 如: "Fri"
l - 星期几，英文全名; 如: "Friday"
w - 数字型的星期几，如: "0" (星期日) 至 "6" (星期六)
a - "am" 或是 "pm"
A - "AM" 或是 "PM"
*/

----

echo date("Ymd",strtotime("now")), "\n"; 
echo date("Ymd",strtotime("-1 week Monday")), "\n"; 
echo date("Ymd",strtotime("-1 week Sunday")), "\n"; 
echo date("Ymd",strtotime("+0 week Monday")), "\n"; 
echo date("Ymd",strtotime("+0 week Sunday")), "\n"; 


//date('n') 第几个月 
//date("w") 本周周几 
//date("t") 本月天数 

echo '<br>上周:<br>'; 
echo date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1-7,date("Y"))),"\n"; 
echo date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7-7,date("Y"))),"\n"; 
echo '<br>本周:<br>'; 
echo date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1,date("Y"))),"\n"; 
echo date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y"))),"\n"; 

echo '<br>上月:<br>'; 
echo date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m")-1,1,date("Y"))),"\n"; 
echo date("Y-m-d H:i:s",mktime(23,59,59,date("m") ,0,date("Y"))),"\n"; 
echo '<br>本月:<br>'; 
echo date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),1,date("Y"))),"\n"; 
echo date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("t"),date("Y"))),"\n"; 

$getMonthDays = date("t",mktime(0, 0 , 0,date('n')+(date('n')-1)%3,1,date("Y")));//本季度未最后一月天数 
echo '<br>本季度:<br>'; 
echo date('Y-m-d H:i:s', mktime(0, 0, 0,date('n')-(date('n')-1)%3,1,date('Y'))),"\n"; 
echo date('Y-m-d H:i:s', mktime(23,59,59,date('n')+(date('n')-1)%3,$getMonthDays,date('Y'))),"\n"; 
