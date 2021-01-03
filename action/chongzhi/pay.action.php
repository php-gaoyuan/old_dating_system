<?php
//引入公共模块
require("api/base_support.php");
$er_langpackage = new rechargelp;

//读写分离定义函数
$dbo = new dbex;
dbtarget('w', $dbServs);

$touser = get_argp("touser");
$post_gold = intval(get_argp("custom_gold"));
$friend_username = get_argp("friend_username");
$pay_method = get_argp("pay_method");
//echo "<pre>";print_r($_POST);exit;
$pay_type=1;
if($pay_method=='lianyin2'){//2是本地
    $pay_type=2;//single
    $pay_method="lianyin";
}

$user_id = get_sess_userid();
$user_name = get_sess_username();
$ordernumber = 'RE' . time() . mt_rand(100, 999);
//echo "<pre>";print_r($_POST);exit;

if ($touser == 'self') {//给自己充值
    $touser = Api_Proxy("user_self_by_uid", "user_group", $user_id);
    $sql = "insert into wy_balance set touid={$user_id},touname='{$user_name}',message='给自己充值{$post_gold}金币'";
} else if ($touser == 'friend') {//给朋友充值
    if (!empty($friend_username)) {
        $sql = "select * from wy_users where user_name = '{$friend_username}'";
        $touser = $dbo->getRow($sql);
        $sql = "insert into wy_balance set touid={$touser['user_id']},touname='{$touser['user_name']}',message='给{$touser['user_name']}充值{$post_gold}金币',tofpay=1";
    } else {
        exit("<script>alert('" . $er_langpackage->er_userrecharge . "');window.close();</script>");
    }
}
$sql .= ",state='0',addtime='" . date('Y-m-d H:i:s') . "',funds='{$post_gold}',ordernumber='$ordernumber',type='1',uid={$user_id},uname='{$user_name}',money='$post_gold',pay_method='{$pay_method}',pay_from='PC'";
//echo $sql;exit;
if (!$dbo->exeUpdate($sql)) {
    exit("<script>alert('" . $er_langpackage->er_rechargewill . "');window.close();</script>");
}
$order = array('out_trade_no' => $ordernumber, 'price' => $post_gold);
if ($pay_method == 'paypal') {
    require("payment/paypal.php");
    $pay = new Paypal;
    $pay->dsql = $dbo;
    $pay->return_url = "http://{$_SERVER["HTTP_HOST"]}/do.php?act=paynotify&code=paypal";
    $button = $pay->GetCode($order);
    echo $button;
} else if ($pay_method == 'yingfu') {//上海赢付
    $payUrl = "/payment/yingfu/index.php?oid={$ordernumber}&am={$post_gold}&pt=1";
    header("location:{$payUrl}");exit;
} else if ($pay_method == 'lianyin') {//联银支付
    $payUrl = "/payment/lianyin/index.php?oid={$ordernumber}&am={$post_gold}&pt=1&pay_type={$pay_type}";
    //echo "<pre>";print_r($payUrl);exit;
    header("location:{$payUrl}");exit;
} else if ($pay_method == 'ipasspay') {//ipasspay
    $payUrl = "/payment/ipasspay/pay.php?oid={$ordernumber}";
    //echo "<pre>";print_r($payUrl);exit;
    header("location:{$payUrl}");exit;
}
?>