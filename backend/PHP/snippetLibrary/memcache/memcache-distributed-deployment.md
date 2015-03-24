#Memcached分布式部署方案

有两种方案,第一种是普通Hash分布,第二种是一致性Hash分布

##普通Hash分布

    function _mHash($key) {
    	$md5 = substr(md5($key),0,8);
    	$seed = 31;
    	$hash = 0;
    	for ($i = 0;$i<8;$i++) {
    		$hash = $hash*$seed+ord($md5{$i});
    		$i++;
    	}
    	return $hash & 0x7FFFFFFF;
    }
    
    $servers = array(
    	array('host'=>'192.168.0.1','port'=>11211),
    	array('host'=>'192.168.0.2','port'=>11211)
    );
    
    $key = "TheKey";
    $value = "TheValue";
    
    $sc = $servers[_Hash($key) % 2]; //通过hash函数把key化成整数后,利用这个整数与memcached服务器数量取模
    
    $memcached = new Memcached($sc);
    $memcached->set($key, $value);
    $memcached->get($key);
    
##一致性Hash分布

php一致性hash类: [Flexihash](https://github.com/pda/flexihash)

    $hash = new Flexihash();
    
    // bulk add
    $hash->addTargets(array('cache-1', 'cache-2', 'cache-3'));
    
    // simple lookup
    $hash->lookup('object-a'); // "cache-1"
    $hash->lookup('object-b'); // "cache-2"
    
    // add and remove
    $hash
      ->addTarget('cache-4')
      ->removeTarget('cache-1');
    
    // lookup with next-best fallback (for redundant writes)
    $hash->lookupList('object', 2); // ["cache-2", "cache-4"]
    
    // remove cache-2, expect object to hash to cache-4
    $hash->removeTarget('cache-2');
    $hash->lookup('object'); // "cache-4"
