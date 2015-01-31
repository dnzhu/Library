<?php

//PHP实现HTML批量转TXT文件

function html2text($str){  
  $str = preg_replace("/<style .*?<\/style>/is", "", $str);
  $str = preg_replace("/<script .*?<\/script>/is", "", $str);
  $str = preg_replace("/\n|\r/", "", $str);//先把文本中所有的换行替换为空，避免下面替换换行时冲突 
  $str = preg_replace("/<br\s?\/?>/i", "\n", $str);
  $str = preg_replace("/<\/p>/i", "\n\n", $str);
  $str = preg_replace("/<\/?td>/i", "\n", $str);
  $str = preg_replace("/<\/?div>/i", "\n", $str);
  $str = preg_replace("/<\/?blockquote>/i", "\n", $str);
  $str = preg_replace("/<\/?li>/i", "\n", $str);
  $str = preg_replace("/\&nbsp\;/i", " ", $str);
  $str = preg_replace("/\&amp\;/i", "&", $str);
  $str = preg_replace("/\&lt\;/i", "<", $str);
  $str = preg_replace("/\&gt\;/i", ">", $str);
  $str = preg_replace("/\&quot\;/i", '"', $str);
  $str = preg_replace("/\&ldquo\;/i", '“', $str);
  $str = preg_replace("/\&rdquo\;/i", '”', $str);
  $str = preg_replace("/\&lsquo\;/i", "‘", $str);
  $str = preg_replace("/\&rsquo\;/i", "’", $str);
  $str = preg_replace("/\&mdash\;/i", '—', $str);
  $str = preg_replace("/\&hellip\;/i", '…', $str);
  $str = preg_replace("/\&middot\;/i", '·', $str);
  $str = preg_replace("/\&times\;/i", '×', $str);
  //如果有特殊需求，请在本行下面按照以上格式继续加HTML特殊符号和转换后的符号
  $str = strip_tags($str);//去除空字符、HTML 和 PHP 标记
  $str = html_entity_decode($str, ENT_QUOTES, $encode);//解码双引号和单引号 &#039;
  $str = preg_replace("/\&\#.*?\;/i", "", $str); //替换所有&#开始;结尾的特殊字符
 return $str;
}

//把文件夹下的所有HTML文件转为TXT文件

//要读取的目录
 $folder='E:\APMServ\www\htdocs\tool\html-to-txt\files';
//打开目录
$fp=opendir($folder);
//阅读目录
while (($file = readdir($fp)) !== false){
$filetype = substr ( $file, strripos ( $file, "." ) + 1 );
$filename=substr($file,0,strrpos($file,'.'));
if($file!='.' &&$file!='..'&&$filetype == "html"){
echo $filename.'<br />';
$content=file_get_contents("$folder/$file");
//打开文件
$op = fopen("$folder/$filename.txt", 'a');
//写入文件
fwrite($op,html2text($content));
//关闭文件
fclose($op);
//删除HTML文件
unlink("$folder/$file");
}
}
//关闭目录
closedir($fp);
