<?php 

require('memcacheServer.class.php');

//配置 定义Memcache 主库
$configMemcache['master'] = array(
    array('host'=>'127.0.0.1',
        'port'=>'11211'
    )
);
 
//配置 定义Memcache 从库
$configMemcache['slave'] = array(
    array('host'=>'127.0.0.1',
        'port'=>'11211'
    )
);
 
$mc = memcacheServer::getInstance($configMemcache);
$mc->set('mc_test','This memcache test');
$mc->set('mc_ok','This memcache ok');
$arr['test'] = $mc->get('mc_test');
$arr['ok'] = $mc->get('mc_ok');
echo "<pre>";
print_r($arr);
