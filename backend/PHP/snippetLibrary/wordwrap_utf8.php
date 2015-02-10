<?php 

//UTF-8编码的wordwrap函数

$long_text = 'this is a long text 这是一个长文本';

//wordwrap将一段字符串根据指定长度来进行自动换行，但它不支持UTF-8.
$new_text = wordwrap($long_text, 15, "<br/>\n", true); 

/**
 * utf-8编码的自动换行
 * utf-8编码的wordwrap实现
 * @param string $str 
 * @param int $length 
 * @param string $break 
 * @return string
 */

function wordwrap_utf8($str, $length = 75, $break = '<br />') {

	$len = mb_strlen($str,'utf-8');
	if($len <= $length) return $str;
	$temp = array();
	$num = ceil($len/$length);	
	for($i = 0; $i < $num; $i++) {
		array_push($temp, 
			mb_substr($str, $length*$i, $length, 'utf-8')
		);		
	}
	return implode($break, $temp);
}

#测试

echo wordwrap_utf8('一二三四五六七八九十1234567890甲乙丙丁jingwentian.com', 5);
