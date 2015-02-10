<?php

//优雅的打印数据方法

function dval($val, $print=true, $method='var_export'){ 
 
    // dval = Debug a VALue -> easy to remember for me
 
    if ($method == 'var_export'){
        $r = var_export($val, true);
    }
    else {
        $r = print_r($val, true);
    }
 
    if ($print){ print "<pre>" . htmlspecialchars($r) . "</pre>"; }
    else { return "<pre>" . htmlspecialchars($r) . "</pre>"; }
}

$v = array(1,2,3,array(1,2,3));
 
dval($v);
dval($v, 1, 'print_r');

/**
 * 输出各种类型的数据，调试程序时打印数据使用。
 * @param	mixed	参数：可以是一个或多个任意变量或值
 */
function p(){
	$args=func_get_args();  //获取多个参数
	if(count($args)<1){
		Debug::addmsg("<font color='red'>必须为p()函数提供参数!");
		return;
	}

	echo '<div style="width:100%;text-align:left; background-color: #fff;"><pre>';
	//多个参数循环输出
	foreach($args as $arg){
		if(is_array($arg)){
			print_r($arg);
			echo '<br>';
		}else if(is_string($arg)){
			echo $arg.'<br>';
		}else{
			var_dump($arg);
			echo '<br>';
		}
	}
	echo '</pre></div>';
}
