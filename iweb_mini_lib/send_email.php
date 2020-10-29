<?php 
/*发送邮件方法
 *@param $to：接收者 $title：标题 $content：邮件内容
 *@return bool true:发送成功 false:发送失败
 */

function sendMail($from_addr,$password,$from_name,$to_addr,$to_name,$title,$content){
    //引入PHPMailer的核心文件 使用require_once包含避免出现PHPMailer类重复定义的警告
    require_once("phpmailer/PHPMailerAutoload.php"); 
    //实例化PHPMailer核心类
    $mail = new PHPMailer();

    //是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
    $mail->SMTPDebug = 0;
    //使用smtp鉴权方式发送邮件
    $mail->isSMTP();
    //smtp需要鉴权 这个必须是true
    $mail->SMTPAuth=true;
    //发件人使用的smtp服务地址
    //$mail->Host = 'ssl://smtp.qq.com:465';
    $mail->Host = 'tls://smtp.office365.com:587';
    $mail->CharSet = 'utf-8';

    //smtp登录的账号 这里填入字符串格式的qq号即可
    $mail->Username = trim($from_addr);
    //smtp登录的密码 使用生成的授权码（就刚才叫你保存的最新的授权码）
    //$mail->Password = 'tlzhztngksxwbgce';
    $mail->Password = trim($password);//'xgaoyuan1224';



    //发件人地址和姓名
    $mail->setFrom(trim($from_addr), trim($from_name));
    //收件人地址和姓名
    $mail->addAddress(trim($to_addr), trim($to_name));//对方用户名



    //添加发送邮件标题
    $mail->Subject = trim($title);
    //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
    $mail->isHTML(true); 
    //添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
    $mail->Body = $content;

    //为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
    // $mail->addAttachment('./d.jpg','mm.jpg');
    //同样该方法可以多次调用 上传多个附件
    // $mail->addAttachment('./Jlib-1.1.0.js','Jlib.js');

    //echo "<pre>";print_r($mail);exit;

    $status = $mail->send();
    //简单的判断与提示信息
    if($status) {
        return true;
    }else{
        return false;
    }
}
?>