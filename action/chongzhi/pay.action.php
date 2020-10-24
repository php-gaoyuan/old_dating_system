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
$pay_type = get_argp("pay_type");

$user_id = get_sess_userid();
$user_name = get_sess_username();
$ordernumber = 'R' . time() . mt_rand(100, 999);
//echo "<pre>";print_r($_POST);exit;

if ($touser == 'self') {//给自己充值
    $touser = Api_Proxy("user_self_by_uid", "user_group", $user_id);
    $sql = "insert into wy_balance set type='1',uid={$user_id},uname='{$user_name}',touid={$user_id},touname='{$user_name}',message='给自己充值{$post_gold}金币',state='0',addtime='" . date('Y-m-d H:i:s') . "',funds='{$post_gold}',ordernumber='$ordernumber'";
} else if ($touser == 'friend') {//给朋友充值
    if (!empty($friend_username)) {
        $sql = "select * from wy_users where user_name = '{$friend_username}'";
        $touser = $dbo->getRow($sql);
        $sql = "insert into wy_balance set type='1',uid={$user_id},uname='{$user_name}',touid={$touser['user_id']},touname='{$touser['user_name']}',message='给{$touser['user_name']}充值{$post_gold}金币',state='0',addtime='" . date('Y-m-d H:i:s') . "',funds='{$post_gold}',ordernumber='$ordernumber',tofpay=1";
    } else {
        exit("<script>alert('" . $er_langpackage->er_userrecharge . "');window.close();</script>");
    }
}

$sumoney = $post_gold;
$sql .= ",money='$sumoney'";
//echo $sql;exit;
if (!$dbo->exeUpdate($sql)) {
    exit("<script>alert('" . $er_langpackage->er_rechargewill . "');window.close();</script>");
}
$order = array('out_trade_no' => $ordernumber, 'price' => $sumoney);
if ($pay_type == 'paypal') {
    require("payment/paypal.php");
    $pay = new Paypal;
    $pay->dsql = $dbo;
    $pay->return_url = "http://{$_SERVER["HTTP_HOST"]}/do.php?act=paynotify&code=paypal";
    $button = $pay->GetCode($order);
    echo $button;
} else if ($pay_type == 'yingfu') {//上海赢付
    $payUrl = "/payment/yingfu/index.php?oid={$ordernumber}&am={$post_gold}&pt=member recharge";
    header("location:{$payUrl}");exit;
    //echo "<pre>";print_r($res);exit;
} else if ($pay_type == 'lianyin') {//联银支付
    $payUrl = "/payment/lianyin/index.php?oid={$ordernumber}&am={$post_gold}&pt=member recharge";
    header("location:{$payUrl}");exit;
    //echo "<pre>";print_r($res_data);exit;

    //注意判断返回金额
    if ($res_data['status'] == "success") {//
        $sql = "SELECT * FROM wy_balance WHERE ordernumber = '{$res_data['order_sn']}'";
        $row = $dbo->getRow($sql);

        if ($row['state'] == 2) {
            echo "<script>alert('该订单已经支付过了!');window.location.href='/main2.0.php?app=user_pay'</script>";
            exit;
        }
        if ($res_data['amount'] != $row['funds']) {
            echo "<script>alert('支付金额出错!');window.location.href='/main2.0.php?app=user_pay'</script>";
            exit;
        }

        if ($row['state'] != '2') {
            $sql = "UPDATE wy_balance SET `state`='2' WHERE ordernumber = '{$res_data['order_sn']}'";

            if ($dbo->exeUpdate($sql)) {
                $touid = $row['touid'];
                $sql = "UPDATE wy_users SET golds=golds+{$row['funds']} WHERE user_id='$touid'";
                if (!$dbo->exeUpdate($sql)) {
                    echo "<script>alert('支付成功，添加金币失败!请联系工作人员！');window.location.href='/main2.0.php?app=user_pay'</script>";
                    exit;
                    exit;
                } else {
                    echo "<script>alert('支付成功，金币已经到账！');window.location.href='/main2.0.php?app=user_pay'</script>";
                    exit;
                }

            }
        }
    } else {
        echo "<script>alert('Failure to pay;" . $res_data["err_msg"] . "');window.location.href='/main2.0.php?app=user_pay'</script>";
        exit;
    }
    //------------------------------
    //处理业务完毕
    //------------------------------
}
?>