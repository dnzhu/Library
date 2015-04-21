<?php 

// PHP 二维数组根据某个字段排序

$arrArticles = [
  array('id'=> 1, 'title'=>'aaa', 'click'=>10),
  array('id'=> 2, 'title'=>'bbb', 'click'=>2),
  array('id'=> 3, 'title'=>'ccc', 'click'=>5),
  array('id'=> 4, 'title'=>'ddd', 'click'=>7),
];

// 按照 click字段进行排序

$sort = array(
  'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
  'field'     => 'click',       //排序字段
);
$arrSort = array();
foreach($arrArticles AS $uniqid => $row){
    foreach($row AS $key=>$value){
        $arrSort[$key][$uniqid] = $value;
    }
}
if($sort['direction']){
    array_multisort($arrSort[$sort['field']], constant($sort['direction']), $arrArticles);
}
var_dump($arrUsers);
