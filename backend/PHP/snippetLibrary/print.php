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

//------------------------------------------------------------------------------------------

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

//------------------------------------------------------------------------------------------

//array_walk debug example

function debug_val($val, $key='', $depth=0) {
 
    if (is_array($val)){
        // call this function again with the "sub-array":
        array_walk($val, 'debug_val', $depth+5);
    }
    else {
        // if we hit a string or bool, etc. then print it:
        print str_repeat('&nbsp;', $depth);          
        print '<span style="color: blue;">' . $key . '</span>: ';
        print var_export($val, true);
        print "<br/>\n";
    }
}
 
 
/*example-start*/
 
// setup the test array 
$array = array(
    'php', 
    'cool', 
    array('foo', 1,2,3, array('mixed' => 'bar')),
    'php' => 'array', 
    'yes' => true, 'no' => false
);
 
// debug the array
debug_val($array);

//------------------------------------------------------------------------------------------------------------------

/**
 * 比var_dump更友好的格式化输出 从 ThinkPHP 提取 
 */
function dump($var, $echo=true, $label=null, $strict=true) {
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        } else {
            $output = $label . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    }else
        return $output;
}


