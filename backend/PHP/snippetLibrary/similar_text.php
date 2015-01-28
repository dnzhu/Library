<?php
//Shows how to use the similar_text() function to compare similar words.
//It returns how similar the words are.

$word2compare = "stupid";
 
$words = array(
    'stupid',
    'stu and pid',
    'hello',
    'foobar',
    'stpid',
    'upid',
    'stuuupid',
    'sstuuupiiid',
);
 
while(list($id, $str) = each($words)){
    similar_text($str, $word2compare, $percent);
    print "Comparing '$word2compare' with '$str': ";
    print round($percent) . "%\n";
}
 
 
/*
Results:
 
Comparing 'stupid' with 'stupid': 100%
Comparing 'stupid' with 'stu and pid': 71%
Comparing 'stupid' with 'hello': 0%
Comparing 'stupid' with 'foobar': 0%
Comparing 'stupid' with 'stpid': 91%
Comparing 'stupid' with 'upid': 80%
Comparing 'stupid' with 'stuuupid': 86%
Comparing 'stupid' with 'sstuuupiiid': 71%
*/

//--------------------------------------------------------------------------------------------------------------------------------------------------------

//关键词
$word2compare = "结婚彩礼";

//分类名称
$words = array(
    101 => '结婚',
    103 => '离婚办理',
    105 => '离婚财产',
    107 => '子女抚养',
    109 => '涉外婚姻',
    111 => '婚姻协议',
    113 => '婚姻文书',
    115 => '婚姻法规',
	117 => '其他婚姻问题'
);

/**
 * 获取相似度最高的键值
 * @param $word2compare 将要比对的词
 * @param $words 待比对的词组
 * @return 返回结果键值
 */

function get_similar($word2compare, $words)
{
	$similar_str = '';
	while(list($id, $str) = each($words)){
		similar_text($str, $word2compare, $percent);
		$similar_str .= $id .'-'. round($percent) . ',';
	}
	$similar_arr = explode(',',rtrim($similar_str,','));
	for($i=0; $i<count($similar_arr); $i++){
		$compare_result[explode('-',$similar_arr[$i])[0]] = explode('-',$similar_arr[$i])[1];
	}
	arsort($compare_result);
	return array_shift(array_flip($compare_result));	
}


echo get_similar($word2compare, $words); //return 101





