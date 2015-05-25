<?php  

class GetImage
{
    public $source;
    public $save_to;
    public $set_extension;
    public $quality;
    public $newname;
    
    public function download($method = 'curl')
    {
        $info = @GetImageSize($this->source);
        $mime = $info['mime'];
        if (!$mime) {
            die('Could not obtain mime-type information. Make sure that the remote file is actually a valid image.');
        }
        // What sort of image?
        $type = substr(strrchr($mime, '/'), 1);
        switch ($type) {
            case 'jpeg':
                $image_create_func = 'ImageCreateFromJPEG';
                $image_save_func = 'ImageJPEG';
                $new_image_ext = 'jpg';
                // Best Quality: 100
                $quality = isset($this->quality) ? $this->quality : 100;
                break;
            case 'png':
                $image_create_func = 'ImageCreateFromPNG';
                $image_save_func = 'ImagePNG';
                $new_image_ext = 'png';
                // Compression Level: from 0  (no compression) to 9
                $quality = isset($this->quality) ? $this->quality : 0;
                break;
            case 'bmp':
                $image_create_func = 'ImageCreateFromBMP';
                $image_save_func = 'ImageBMP';
                $new_image_ext = 'bmp';
                break;
            case 'gif':
                $image_create_func = 'ImageCreateFromGIF';
                $image_save_func = 'ImageGIF';
                $new_image_ext = 'gif';
                break;
            case 'vnd.wap.wbmp':
                $image_create_func = 'ImageCreateFromWBMP';
                $image_save_func = 'ImageWBMP';
                $new_image_ext = 'bmp';
                break;
            case 'xbm':
                $image_create_func = 'ImageCreateFromXBM';
                $image_save_func = 'ImageXBM';
                $new_image_ext = 'xbm';
                break;
            default:
                $image_create_func = 'ImageCreateFromJPEG';
                $image_save_func = 'ImageJPEG';
                $new_image_ext = 'jpg';
        }
        if (isset($this->set_extension)) {
            if (isset($this->newname)) {
                $ext = strrchr($this->source, '.');
                $strlen = strlen($ext);
                $new_name = basename(substr($this->source, 0, -$strlen)) . '.' . $new_image_ext;
            } else {
                $new_name = $this->newname . '.' . $new_image_ext;
            }
            
        } else {
            if (isset($this->newname)) {
                $ext = strrchr($this->source, '.');
                $new_name = $this->newname . $ext;
            } else {
                $new_name = basename($this->source);
            }
            
        }
        $save_to = $this->save_to . $new_name;
        if ($method == 'curl') {
            $save_image = $this->LoadImageCURL($save_to);
        } elseif ($method == 'gd') {
            $img = $image_create_func($this->source);
            if (isset($quality)) {
                $save_image = $image_save_func($img, $save_to, $quality);
            } else {
                $save_image = $image_save_func($img, $save_to);
            }
        }
        return $save_image;
    }
    public function LoadImageCURL($save_to)
    {
        $ch = curl_init($this->source);
        $fp = fopen($save_to, 'wb');
        // set URL and other appropriate options
        $options = array(CURLOPT_FILE => $fp, CURLOPT_HEADER => 0, CURLOPT_FOLLOWLOCATION => 1, CURLOPT_TIMEOUT => 60);
        // 1 minute timeout (should be enough)
        curl_setopt_array($ch, $options);
        $save = curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        return $save;
    }
}

include_once 'class.get.image.php';

// initialize the class
$image = new GetImage;

// just an image URL
$image->source = 'http://static.php.net/www.php.net/images/php_snow_2008.gif';
$image->save_to = 'images/'; // with trailing slash at the end

$get = $image->download('curl'); // using GD

if($get)
{
echo 'The image has been saved.';
}


//------------------------------------------------------------------------------------------------------------

/*
    * [下载远程图片保存到本地]
    * @param  string  $url      图片URL       
    * @param  string  $save_dir 保存文件路径
    * @param  string  $filename 保存文件名称(当保存文件名称为空时则使用远程文件原来的名称)
    * @param  int     $type    使用的下载方式(0|1) 
    * @return array
    */
    function getImage($url,$save_dir='',$filename='',$type=0){
        if(trim($url)==''){
            return array('file_name'=>'','save_path'=>'','error'=>1);
        }
        if(trim($save_dir)==''){
            $save_dir='./';
        }
        if(trim($filename)==''){//保存文件名
            $ext=strrchr($url,'.');
            if($ext!='.gif'&&$ext!='.jpg'){
                return array('file_name'=>'','save_path'=>'','error'=>3);
            }
            $filename=time().$ext;
        }
        if(0!==strrpos($save_dir,'/')){
            $save_dir.='/';
        }
        //创建保存目录
        if(!file_exists($save_dir)&&!mkdir($save_dir,0777,true)){
            return array('file_name'=>'','save_path'=>'','error'=>5);
        }
        //获取远程文件所采用的方法 
        if($type){
            $ch=curl_init();
            $timeout=5;
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
            $img=curl_exec($ch);
            curl_close($ch);
        }else{
            ob_start(); 
            readfile($url);
            $img=ob_get_contents(); 
            ob_end_clean(); 
        }
        //$size=strlen($img);
        //文件大小 
        $fp2=@fopen($save_dir.$filename,'a');
        fwrite($fp2,$img);
        fclose($fp2);
        unset($img,$url);
        return array('file_name'=>$filename,'save_path'=>$save_dir.$filename,'error'=>0);
    }


//------------------------------------------------------------------------------------------------------------

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
 
