<?php

//1. 利用Curl封装的一个能访问HTTPS内容的函数
function getHTTPS($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

//2. 以前从数据库取回记录后总要foreach去取其中一个字段,不过后来PHP支持了匿名函数:

$users = array(
	0 => array('id' => 1,'name' => 'tom', 'age' => 10),
	1 => array('id' => 2,'name' => 'kitty','age' => 11),
	2 => array('id' => 2,'name' => 'billy','age' => 12),
	3 => array('id' => 2,'name' => 'kandy','age' => 13),
);
//[1] get names in an array
foreach ($users as $user) {
	$names[] = $user['name'];
}

//[2] get names in an array
//anonymous function
$names2 = array_map(function($user) {
	return $user['name'];
}, $users);

/*Array
(
    [0] => tom
    [1] => kitty
    [2] => billy
    [3] => kandy
)*/
?>
