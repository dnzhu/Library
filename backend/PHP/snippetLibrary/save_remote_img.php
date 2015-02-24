<?php  

define('BASE_URL','http://demo.jingwentian.com/save_remote_img'); 

if($_POST) {
	//开始远程存图
	$content = $_POST['content']?:file_get_contents($_POST['url']);
	$img_array = array(); 
	$fileArray="";
	$content = stripslashes($content); 
	if (get_magic_quotes_gpc()) $content = stripslashes($content);
	//echo $content;
	preg_match_all("/(src|SRC)=\"(http:\/\/(.+).(gif|jpg|jpeg|bmp|png))/isU",$content,$img_array);//正则开始匹配所有的图片并放入数据
	$img_array = array_unique(dhtmlspecialchars($img_array[2])); 
	//print_r($img_array);
	set_time_limit(0); 
	foreach ($img_array as $key => $value) { 
	
		$get_file = file_get_contents($value);//开始获取图片了哦 
		$filetime = time(); 
		$filepath = "./upload/".date("Y",$filetime).date("m",$filetime)."/";//图片保存的路径目录
		!is_dir($filepath) ? mkdirs($filepath) : null;  
		
		//$filepath="./";
		$filename = date("YmdHis",$filetime).".".substr($value,-3,3); 
		$fp = @fopen($filepath.$filename,"w"); 
		@fwrite($fp,$get_file); 
		fclose($fp);//完工
		
		//将原图片链接替换成保存后的
		$content = preg_replace("/".addcslashes($value,"/")."/isU", BASE_URL."/upload/".date("Y",$filetime).date("m",$filetime)."/".$filename, $content);  //顺便替换一下文章里面的图片地址  
		echo $content;
		
		//生成一个数组文件，用来选择主图。
		$fileArray=$fileArray."/upload/".date("Y",$filetime).date("m",$filetime)."/".$filename."|";
		
	}

	//远程存图结束。
}   

function mkdirs($dir) { 
    if(!is_dir($dir)) 
    { 
        mkdirs(dirname($dir)); 
        mkdir($dir); 
    } 
    return ; 
}

function dhtmlspecialchars($string, $is_url = 0) {
    if(is_array($string)) {
        foreach($string as $key => $val) {
                $string[$key] = dhtmlspecialchars($val);
        }
    } else {
        if (!$is_url) $string = str_replace('&', '&', $string);
        $string = preg_replace('/&((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
                str_replace(array('&', '"', '<', '>'), array('&', '"', '<', '>'), $string));
	}
    return $string;
}


?>


<form action="index.php" method="post">
	<textarea name="content" placeholder="正文" style="width:500px;height:150px;"></textarea>
	或者：
	<input type="url" name="url" placeholder="链接" style="width:500px;height:50px;" />
	<input type="submit" value="submit" />
</form>
 
