<?php
//邀请好友
function yaoqing($user_email, $message)
{
    require("configuration.php");
    require("foundation/csmtp.class.php");
    require("foundation/asmtp_info.php");
    //发送邮件
    $smtp = new smtp($smtpAddress, $smtpPort, true, $smtpUser, $smtpPassword);
    $user_emails = explode(";", $user_email);
    foreach ($user_emails as $user_email) {
        $email_array = explode('@', $user_email);
        $email_site = strtolower($email_array[1]);
        //为hotmail和gmail邮箱单独设置字符集
        $utf8_site = array("hotmail.com", "gmail.com", "qq.com");
        if (!in_array($email_site, $utf8_site)) {
            $mailbody = iconv('UTF-8', 'GBK', $message);
            $mailtitle = iconv('UTF-8', 'GBK', $siteName . "通知");
        } else {
            //激活邮件的title和body信息
            $mailtitle = $siteName . "通知";
            $mailbody = $message;
        }
        //$smtp->debug = TRUE;输出调试信息
        $result = $smtp->sendmail($user_email, $smtpUser, $mailtitle, $mailbody, 'HTML');
    }
}

//获取本地IP
function getip()
{
    if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
        if ($_SERVER["HTTP_CLIENT_IP"]) {
            $proxy = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $proxy = $_SERVER["REMOTE_ADDR"];
        }
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else {
        if ($_SERVER["HTTP_CLIENT_IP"]) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }
    }
    return $ip;
}

//随机生成字符串
function getstr($length)
{
    $string = "3abc2de1fg6hijkl5mnop4q0rst8uvwx9yz7";
    $result = "";
    for ($i = 0; $i < $length - 1; $i++) {
        $j = rand($i, strlen($string));
        if ($j % 2 == 0) {
            $string = str_rot13($string);
        }
        $result .= substr($string, $j, 1);
    }
    return $result;
}

?>