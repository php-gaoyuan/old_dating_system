<?php
//引入模块公共方法文件
// require ("foundation/aanti_refresh.php");
// require ("foundation/goodlefanyi.php");
// require ("foundation/fgrade.php");
// require ("api/base_support.php");
//引入邮件发送极致
require("iweb_mini_lib/send_email.php");
//echo "<pre>";print_r($_GET);exit;
$dbo = new dbex;
dbtarget('w', $dbServs);


$user_id = get_sess_userid(); //发件人id
$user_sex = get_sess_usersex(); //发件人id
$user_name = get_sess_username(); //发件人id
if($user_sex == '1' || empty($user_id)){
    echo "无权访问";exit;
}


$id = intval($_GET['id']);
$info = $dbo->getRow("select * from wy_msg_outbox where user_id='{$user_id}' and mess_id='{$id}'");
if(empty($info)){
    echo "无权访问";exit;
}

$uinfo = $dbo->getRow("select user_email, email_passwd, user_name from wy_users where user_id='$user_id'");
$to_uinfo = $dbo->getRow("select user_name, user_email from wy_users where user_id='{$info['to_user_id']}'");
//echo "<pre>";print_r($uinfo);exit;

// $uinfo['user_email'] = "meng_a_happy@outlook.com";
// $uinfo['email_passwd'] = "xgaoyuan1224";
// $to_uinfo['user_email'] = "347356860@qq.com";
//开始发送真实邮件
if($user_sex == '0'){
    if(empty($info['mess_title'])){
        $info['mess_title'] = "好友的".$uinfo['user_email']."消息";
    }
    
    $res = sendMail($uinfo['user_email'], $uinfo['email_passwd'], 'pauzzz好友'.$uinfo['user_name'], $to_uinfo['user_email'], $to_uinfo['user_name'], $info['mess_title'], $info['mess_content']);
    if($res !== false){
        echo "<script>alert('真实邮件发送成功');window.close();//location.href='modules.php?app=msg_moutbox';</script>";exit();
    }else{
        echo "<script>alert('真实邮件发送失败');window.close();//location.href='modules.php?app=msg_moutbox';</script>";
    }
    echo "<pre>";print_r($res);exit;
}



?>

