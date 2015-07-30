<?php 

// [根据身份证号获取生日,是否成年]

<?php
//用php从身份证中提取生日,包括15位和18位身份证
function getIDCardInfo($IDCard){
	$result['error']=0;//0：未知错误，1：身份证格式错误，2：无错误
	$result['flag']='';//0标示成年，1标示未成年
	$result['tdate']='';//生日，格式如：2012-11-15
	if(!eregi("^[1-9]([0-9a-zA-Z]{17}|[0-9a-zA-Z]{14})$",$IDCard)){
		$result['error']=1;
		return $result;
	}else{
		if(strlen($IDCard)==18){
			$tyear=intval(substr($IDCard,6,4));
			$tmonth=intval(substr($IDCard,10,2));
			$tday=intval(substr($IDCard,12,2));
			if($tyear>date("Y")||$tyear<(date("Y")-100)){
				$flag=0;
			}elseif($tmonth<0||$tmonth>12){
				$flag=0;
			}elseif($tday<0||$tday>31){
				$flag=0;
			}else{
				$tdate=$tyear."-".$tmonth."-".$tday." 00:00:00";
				if((time()-mktime(0,0,0,$tmonth,$tday,$tyear))>18*365*24*60*60){
					$flag=0;
				}else{
					$flag=1;
				}
			}
		}elseif(strlen($IDCard)==15){
			$tyear=intval("19".substr($IDCard,6,2));
			$tmonth=intval(substr($IDCard,8,2));
			$tday=intval(substr($IDCard,10,2));
			if($tyear>date("Y")||$tyear<(date("Y")-100)){
				$flag=0;
			}elseif($tmonth<0||$tmonth>12){
				$flag=0;
			}elseif($tday<0||$tday>31){
				$flag=0;
			}else{
				$tdate=$tyear."-".$tmonth."-".$tday." 00:00:00";
				if((time()-mktime(0,0,0,$tmonth,$tday,$tyear))>18*365*24*60*60){
					$flag=0;
				}else{
					$flag=1;
				}
			}
		}
	}
	$result['error']=2;//0：未知错误，1：身份证格式错误，2：无错误
	$result['isAdult']=$flag;//0标示成年，1标示未成年
	$result['birthday']=$tdate;//生日日期
	return $result;
}

//[根据生日获取星座]-------------------------------------------------------------------------------------------------------------------------

function constellation($month,$day){
	//检查参数有效性 http://www.phpernote.com/
	if($month<1||$month>12||$day<1||$day>31) return false;	
	//星座名称以及开始日期
	$constellations=array(
		array("20"=>"宝瓶座"),
		array("19"=>"双鱼座"),
		array("21"=>"白羊座"),
		array("20"=>"金牛座"),
		array("21"=>"双子座"),
		array("22"=>"巨蟹座"),
		array("23"=>"狮子座"),
		array("23"=>"处女座"),
		array("23"=>"天秤座"),
		array("24"=>"天蝎座"),
		array("22"=>"射手座"),
		array("22"=>"摩羯座")
	);
	list($constellation_start,$constellation_name)=each($constellations[(int)$month-1]);
	if($day<$constellation_start){
		list($constellation_start,$constellation_name)=each($constellations[($month-2<0)?$month=11:$month-=2]);
	}
	return $constellation_name;
}

//------------------------------------------------------------------------------------------

<?php 
// check
class check{
    // $num为身份证号码，$checkSex：1为男，2为女，不输入为不验证
    public function checkIdentity($num,$checkSex=''){
        // 不是15位或不是18位都是无效身份证号
        if(strlen($num) != 15 && strlen($num) != 18){
            return false;
        }
        // 是数值
        if(is_numeric($num)){
            // 如果是15位身份证号
            if(strlen($num) == 15 ){
                // 省市县（6位）
                $areaNum = substr($num,0,6);
                // 出生年月（6位）
                $dateNum = substr($num,6,6);
                // 性别（3位）
                $sexNum = substr($num,12,3);
            }else{
            // 如果是18位身份证号
                // 省市县（6位）
                $areaNum = substr($num,0,6);
                // 出生年月（8位）
                $dateNum = substr($num,6,8);
                // 性别（3位）
                $sexNum = substr($num,14,3);
                // 校验码（1位）
                $endNum = substr($num,17,1);
            }
        }else{
        // 不是数值
            if(strlen($num) == 15){
                return false;
            }else{
                // 验证前17位为数值，且18位为字符x
                $check17 = substr($num,0,17);
                if(!is_numeric($check17)){
                    return false;
                }
                // 省市县（6位）
                $areaNum = substr($num,0,6);
                // 出生年月（8位）
                $dateNum = substr($num,6,8);
                // 性别（3位）
                $sexNum = substr($num,14,3);
                // 校验码（1位）
                $endNum = substr($num,17,1);
                if($endNum != 'x' && $endNum != 'X'){
                    return false;
                }
            }
        }
 
        if(isset($areaNum)){
            if(!$this ->checkArea($areaNum)){
                return false;
            }
        }
 
        if(isset($dateNum)){
            if(!$this ->checkDate($dateNum)){
                return false;
            }
        }
 
        // 性别1为男，2为女
        if($checkSex == 1){
            if(isset($sexNum)){
                if(!$this ->checkSex($sexNum)){
                    return false;
                }
            }
        }else if($checkSex == 2){
            if(isset($sexNum)){
                if($this ->checkSex($sexNum)){
                    return false;
                }
            }
        }
 
        if(isset($endNum)){
            if(!$this ->checkEnd($endNum,$num)){
                return false;
            }
        }
        return true;
    }
 
    // 验证城市
    private function checkArea($area){
        $num1 = substr($area,0,2);
        $num2 = substr($area,2,2);
        $num3 = substr($area,4,2);
        // 根据GB/T2260—999，省市代码11到65
        if(10 < $num1 && $num1 < 66){
            return true;
        }else{
            return false;
        }
        //============
        // 对市 区进行验证
        //============
    }
 
    // 验证出生日期
    private function checkDate($date){
        if(strlen($date) == 6){
            $date1 = substr($date,0,2);
            $date2 = substr($date,2,2);
            $date3 = substr($date,4,2);
            $statusY = $this ->checkY('19'.$date1);
        }else{
            $date1 = substr($date,0,4);
            $date2 = substr($date,4,2);
            $date3 = substr($date,6,2);
            $nowY = date("Y",time());
            if(1900 < $date1 && $date1 <= $nowY){
                $statusY = $this ->checkY($date1);
            }else{
                return false;
            }
        }
        if(0<$date2 && $date2 <13){
            if($date2 == 2){
                // 润年
                if($statusY){
                    if(0 < $date3 && $date3 <= 29){
                        return true;
                    }else{
                        return false;
                    }
                }else{
                // 平年
                    if(0 < $date3 && $date3 <= 28){
                        return true;
                    }else{
                        return false;
                    }
                }
            }else{
                $maxDateNum = $this ->getDateNum($date2);
                if(0<$date3 && $date3 <=$maxDateNum){
                    return true;
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
    }
 
    // 验证性别
    private function checkSex($sex){
        if($sex % 2 == 0){
            return false;
        }else{
            return true;
        }
    }
 
    // 验证18位身份证最后一位
    private function checkEnd($end,$num){
        $checkHou = array(1,0,'x',9,8,7,6,5,4,3,2);
        $checkGu = array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);
        $sum = 0;
        for($i = 0;$i < 17; $i++){
            $sum += (int)$checkGu[$i] * (int)$num[$i];
        }
        $checkHouParameter= $sum % 11;
        if($checkHou[$checkHouParameter] != $num[17]){
            return false;
        }else{
            return true;
        }
    }
 
    // 验证平年润年，参数年份,返回 true为润年  false为平年
    private function checkY($Y){
        if(getType($Y) == 'string'){
            $Y = (int)$Y;
        }
        if($Y % 100 == 0){
            if($Y % 400 == 0){
                return true;
            }else{
                return false;
            }
        }else if($Y % 4 ==  0){
            return true;
        }else{
            return false;
        }
    }
 
    // 当月天数 参数月份（不包括2月）  返回天数
    private function getDateNum($month){
        if($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10 || $month == 12){
            return 31;
        }else if($month == 2){
        }else{
            return 30;
        }
    }
 
}
 
 
// 测试
header("content-type:text/html;charset=utf-8");
$num = '350322199001282536';
// 1为男，2为女，不输入为不验证
$sex = 1;
$test = new check();
$data = $test ->checkIdentity($num,$sex);
var_dump($data);
 
 
// 新的18位身份证号码各位的含义: 
// 1-2位省、自治区、直辖市代码；    11-65
// 3-4位地级市、盟、自治州代码； 
// 5-6位县、县级市、区代码； 
// 7-14位出生年月日，比如19670401代表1967年4月1日； 
// 15-17位为顺序号，其中17位男为单数，女为双数； 
// 18位为校验码，0-9和X，由公式随机产生。 
// 举例： 
// 130503 19670401 0012这个身份证号的含义: 13为河北，05为邢台，03为桥西区，出生日期为1967年4月1日，顺序号为001，2为验证码。 
 
 
// 15位身份证号码各位的含义: 
// 1-2位省、自治区、直辖市代码； 
// 3-4位地级市、盟、自治州代码； 
// 5-6位县、县级市、区代码； 
// 7-12位出生年月日,比如670401代表1967年4月1日,这是和18位号码的第一个区别； 
// 13-15位为顺序号，其中15位男为单数，女为双数； 
// 与18位身份证号的第二个区别：没有最后一位的验证码。 
// 举例：
// 130503 670401 001的含义; 13为河北，05为邢台，03为桥西区，出生日期为1967年4月1日，顺序号为001。
