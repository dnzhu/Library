<?php 

/**
 * @备份数据库
 * @author [jingwentian] <[mini.mosquitor@gmail.com]>
 * 1.PHP备份数据库
 * 2.PHP压缩
 * 3.PHP发邮件
 * 4.PHP计划任务
 */

require('PHPMailer/class.phpmailer.php');
require("PHPMailer/class.smtp.php"); 

/* @配置 */

$host = "localhost"; //数据库地址
$dbname = "dbname"; //数据库名称
$user = "root"; //数据库账号
$password = "123456"; //数据库密码
$sendmail = "mini.mosquitor@gmail.com"; //发件邮箱
$mailpassword = "123456"; //发件邮箱密码
$sendmailname = "jing-backup-mysql"; //发件人昵称
$inbox ="562234934@qq.com"; //收件邮箱


/* @数据备份 */

if (!mysql_connect($host, $user, $password)) // 连接mysql数据库
{
    echo '数据库连接失败，请核对后再试';
    exit;
} 
if (!mysql_select_db($dbname)) // 是否存在该数据库
{
    echo '不存在数据库:' . $dbname . ',请核对后再试';
    exit;
} 
mysql_query("set names 'utf8'");
$mysql = "set charset utf8;\r\n"; 
$q1 = mysql_query("show tables");
while ($t = mysql_fetch_array($q1))
{
    $table = $t[0];
    $q2 = mysql_query("show create table `$table`");
    $sql = mysql_fetch_array($q2);
    $mysql .= $sql['Create Table'] . ";\r\n";
    $q3 = mysql_query("select * from `$table`");
    while ($data = mysql_fetch_assoc($q3))
    {
        $keys = array_keys($data);
        $keys = array_map('addslashes', $keys);
        $keys = join('`,`', $keys);
        $keys = "`" . $keys . "`";
        $vals = array_values($data);
        $vals = array_map('addslashes', $vals);
        $vals = join("','", $vals);
        $vals = "'" . $vals . "'";
        $mysql .= "insert into `$table`($keys) values($vals);\r\n";
    } 
} 
$filename = $dbname . date('Ymd') . ".sql"; //存放路径
$fp = fopen($filename, 'w');
fputs($fp, $mysql);
fclose($fp);


/* @创建一个zip文件 */

function create_zip($files = array(),$destination = '',$overwrite = false) {
    if(file_exists($destination) && !$overwrite){ //检测zip文件是否存在
        return false;
    }
    if(is_array($files)) { //检测文件是否存在
        foreach($files as $file) { //循环通过每个文件
            if(file_exists($file)) { //确定这个文件存在
                $valid_files[] = $file;
            }
        }
    }
    if(count($valid_files)) {
        $zip = new ZipArchive(); //创建zip文件
        if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true){
            return false;
        }
        foreach($valid_files as $file) { //添加文件
            $zip->addFile($file,$file);
        }
        $zip->close();
        return file_exists($destination);

    } else {
        return false;
    }
}

$zipfilename=$dbname . date('Ymd') . ".zip";
create_zip(array($filename),$zipfilename,true);//执行压缩文件


/* @发送邮件 */

$mail = new PHPMailer(); //建立邮件发送类
$mail->CharSet    = "UTF-8";                //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置为 UTF-8
$mail->IsSMTP();                            // 设定使用SMTP方式发送
$mail->SMTPAuth   = true;                   // 启用 SMTP 验证功能
$mail->SMTPSecure = "ssl";                  // SMTP 安全协议
$mail->Host       = "smtp.gmail.com";       // SMTP 服务器(您的企业邮局域名)
$mail->Port       = 465;                    // SMTP服务器的端口号
$mail->Username   = $sendmail;              // SMTP服务器用户名(请填写完整的email地址)
$mail->Password   = $mailpassword;          // SMTP服务器密码
$mail->From       = $sendmail;              // 邮件发送者email地址
$mail->FromName   = $sendmailname;          // 邮件发送者昵称
$mail->SetFrom($sendmail, $sendmailname);   // 设置发件人地址和名称
$mail->AddReplyTo($sendmail, $sendmailname);  // 设置邮件回复人地址和名称
$mail->AddAddress($inbox, "jingwentian");   // 收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")

$mail->AddAttachment("$zipfilename");       // 添加附件
$mail->Subject    = '数据库备份';            // 设置邮件标题
$mail->Body       = "数据库备份邮件";        //邮件内容(可选项，向下兼容考虑)
$mail->AltBody    = "This is the body in plain text for non-HTML mail clients"; // 附加信息，可以省略
$mail->MsgHTML("<b>数据库自动备份,备份时间: ".date('Y-m-d H:i:s',time())."</b>");  // 设置邮件内容


if(!$mail->Send())
{
    echo "邮件发送失败. <p>";
    echo "错误原因: " . $mail->ErrorInfo;
    exit;
}
echo "邮件发送成功";

/* @删除本地数据库文件sql和zip */

unlink($filename);
unlink($zipfilename);
