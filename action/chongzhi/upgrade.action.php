<?php
//引入公共模块
require("api/base_support.php");
$er_langpackage = new rechargelp;
$user_group = get_argp("user_group");
$touser = get_argp("touser");
$friend_username = get_argp("friend_username");
$money = 0;
$day = 0;
$groups = 1;
switch ($user_group) {
    case 'bj1':
        $money = 12;
        $day = 30;
        $groups = '2';
        break;
    case 'bj2':
        $money = 30;
        $day = 90;
        $groups = '2';
        break;
    case 'bj3':
        $money = 59;
        $day = 180;
        $groups = '2';
        break;
    case 'bj4':
        $money = 108;
        $day = 360;
        $groups = '2';
        break;
    case 'zs1':
        $money = 100;
        $day = 30;
        $groups = '3';
        break;
    case 'zs2':
        $money = 288;
        $day = 90;
        $groups = '3';
        break;
    case 'zs3':
        $money = 521;
        $day = 180;
        $groups = '3';
        break;
    case 'zs4':
        $money = 999;
        $day = 360;
        $groups = '3';
        break;
}
//echo "<pre>";print_r($_POST);exit;
$dbo = new dbex;
dbtarget('w', $dbServs);

$user_id = get_sess_userid();
$user_name = get_sess_username();
$sql = "select * from wy_users where user_id={$user_id}";
$golds = $dbo->getRow($sql);

if ($golds['golds'] - $money < 0) {
    exit("<script>alert('" . $er_langpackage->er_mess2 . "');location.href='/modules2.0.php?app=user_pay';</script>");
}
//扣除金币
$sql = "UPDATE wy_users SET golds=golds-{$money} WHERE user_id={$user_id}";
if (!$dbo->exeUpdate($sql)) {
    exit("<script>alert('" . $er_langpackage->er_rechargewill . "');location.href='/modules2.0.php?app=user_pay';</script>");
}
$mid = "";
$ordernumber = 'U' . time() . mt_rand(100, 999);
if ($touser == 'self') {
    $mid = $user_id;
    $sql = "insert into wy_balance set type='2',uid='$user_id',uname='$user_name',touid='$user_id',touname='$user_name',message='会员自己升级消费" . $money . "',state='2',addtime='" . date('Y-m-d H:i:s') . "',funds='$money',ordernumber='$ordernumber'";
} else if ($touser == 'friend') {
    if ($friend_username) {
        $sql = "select * from wy_users where user_name = '{$friend_username}'";
        $touser = $dbo->getRow($sql);
        $mid = $touser['user_id'];
        $sql = "insert into wy_balance set type='2',uid='$user_id',uname='$user_name',touid='" . $touser['user_id'] . "',touname='" . $touser['user_name'] . "',message='{$user_name}给{$touser['user_name']}升级，消费" . $money . "',state='2',addtime='" . date('Y-m-d H:i:s') . "',funds='$money',ordernumber='$ordernumber'";
    } else {
        echo "<script>alert('" . $er_langpackage->er_userrecharge . "');location.href='/modules2.0.php?app=user_pay';</script>";
        exit();
    }
}
$dbo->exeUpdate($sql);
//echo "<pre>";print_r($touser);exit;
$upgrade = $dbo->getRow("select * from wy_upgrade_log where mid='$mid' and state='0' order by id desc limit 1");
if ($upgrade) {
    if ($groups == $upgrade['groups']) {
        $nowtime = $upgrade['endtime'];
    } else {
        $nowtime = date("Y-m-d");
    }
} else {
    $nowtime = date("Y-m-d");
}
$sql = "update wy_upgrade_log set state='1' where mid='$mid'";
$dbo->exeUpdate($sql);
//$nowtime=date("Y-m-d");
$end = date("Y-m-d", strtotime($nowtime) + $day * 24 * 3600);
$sql = "insert into wy_upgrade_log set mid='$mid',groups='$groups',howtime='$day',state='0',addtime='" . date('Y-m-d H:i:s') . "',endtime='$end'";
$dbo->exeUpdate($sql);

exit("<script>alert('" . $er_langpackage->er_good . "');top.location.href='/main.php';</script>");
?>