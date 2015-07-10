<?php 

/**
 * 一个通过一个总数获取包含项的方法
 * 可以应用在很多场景: 支付方式的计算, 权限的计算等
 * 下面是一个示例
 */

// 权限规则
function getAuthArr(){
    $authArr = array(
          "add"=>0,#增 --1
            "delete"=>1,#删 --2
            "update"=>2,#改 --4
            "select"=>3,#查 --8
        );
    return $authArr;
}

// 通过权限值获取包含的权限
function getAuthMethod($num){
    $authArr = getAuthArr();
    $return = array();
    foreach ($authArr as $key => $value) {
        $p = pow(2,$value);
        if($p&$num){
        	  $return[$key] = 1;
        }else{
        	  $return[$key] = 0;
        }
    }
    return $return;
}

// 通过传入的权限列表计算总的权限值
function getAuthSum($list){
    $authArr = getAuthArr();
    $num = 0;
    foreach ($list as $key => $value) {
        if($value == 1){
            $num += pow(2,$authArr[$key]);
        }
    }
    return $num;
}

//------------------------------------------------

$authList = array('add'=>1,'delete'=>1);

echo getAuthSum($authList); // 3

print_r(getAuthMethod(3));

/*
Array
(
    [add] => 1
    [delete] => 1
    [update] => 0
    [select] => 0
)
*/
