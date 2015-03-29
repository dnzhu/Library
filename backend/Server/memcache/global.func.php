<?php

/**
 * 全局函数，初始化类库memcacheServer
 * 此函数在类中调用到 ，在此之前还必须定义memcache 配置 $configMemcache
 */
function mcServer($key, $value = null, $exp = 0){
    global $configMemcache;
    // 是否开启Memcache缓存 , s
    if(MEMCACHE_TF == false) {
        return false;
    }
    // 引入类库
    require_once ROOT_PATH . 'memcacheServer.class.php';
    //使用方式,初始化化类库
    $mc = memcacheServer::getInstance($configMemcache);
    //是否设置缓存，null 表示，获取缓存；否则设置缓存
    if($value === null){
        $data = $mc->get($key);
    }else {
        $data = $mc->set($key, $value, $exp);
    }
    return $data;
}
