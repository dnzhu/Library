<?php 

include("SessionManager.php");

new SessionManager(); //开启Session管理

$_SESSION['username'] = 'jingwentian'; //创建一个session变量
