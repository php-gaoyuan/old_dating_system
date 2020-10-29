<?php
//引入公共模块
require("api/base_support.php");
$er_langpackage = new rechargelp;
$dbo = new dbex;
//读写分离定义函数
dbtarget('w', $dbServs);
//echo "<pre>";print_r($_SERVER);exit;
//ajax校验email和验证码
if (get_argg('ajax') == 1) {
	$user_name = get_argg("user_name");
	if ($user_name) {
		$sql = "select user_group from wy_users where user_name='$user_name'";
		$user_info = $dbo->getRow($sql);
		if ($user_info) {
			if ($user_info['user_group'] == 'base') {
				echo 0;
			} else {
				echo $user_info['user_group'];
			}
		}
	}
	exit;
}
$touser = get_argp("touser");
$user_id = get_sess_userid();
$user_name = get_sess_username();
$ordernumber = 'S-P' . time() . mt_rand(100, 999);
$zibi = '';
if (get_argp("sxzibi")) {
	$zibi = get_argp("sxzibi");
} else {
	$zibi = get_argp("zibi");
}
$dbo = new dbex;
//读写分离定义函数
dbtarget('w', $dbServs);
//echo $zibi;exit;
if ($touser == '1') { //给自己充值
	$touser = Api_Proxy("user_self_by_uid", "user_group", $user_id);
	$sql = "insert into wy_balance set type='1',uid='$user_id',uname='$user_name',touid='$user_id',touname='$user_name',message='给自己充值" . $zibi . "金币',state='0',addtime='" . date('Y-m-d H:i:s') . "',funds='$zibi',ordernumber='$ordernumber'";
} else if ($touser == '2') { //给朋友充值
	if (get_argp("friends")) {
		$sql = "select * from wy_users where user_name = '" . get_argp("friends") . "'";
		$touser = $dbo->getRow($sql);
		$sql = "insert into wy_balance set type='1',uid='$user_id',uname='$user_name',touid='" . $touser['user_id'] . "',touname='" . $touser['user_name'] . "',message='给" . $touser['user_name'] . "充值" . $zibi . "金币',state='0',addtime='" . date('Y-m-d H:i:s') . "',funds='$zibi',ordernumber='$ordernumber',tofpay=1";
	} else {
		echo "<script>alert('" . $er_langpackage->er_userrecharge . "');location.href='/modules.php?app=user_pay';</script>";
		exit();
	}
}
$sumoney = 0;
switch ($touser['user_group']) {
	/*case 1:
	$sumoney=$zibi*95/100;
	break;*/
	case 2:
		//$sumoney=$zibi*95/100;
		$sumoney = $zibi;
		break;
	case 3:
		//$sumoney=$zibi*9/10;
		$sumoney = $zibi;
		break;
	default:
		$sumoney = $zibi;
}
$sql .= ",money='$sumoney'";
if ($dbo->exeUpdate($sql)) {
	$order = array('out_trade_no' => $ordernumber, 'price' => $sumoney);
	if (get_argp("zhifu") == '1') { //PayPal支付
		require("payment/paypal.php");
		$pay = new Paypal;
		$pay->dsql = $dbo;
		$pay->return_url = 'http://www.puivip.com/do.php?act=paynotify';
		$button = $pay->GetCode($order, 'annimeet@outlook.com');
		echo $button;
	} else if (get_argp("zhifu") == '2') { //Corpay支付接口
		//echo "<pre>";print_r(get_argp("cvv"));exit;
		require("payment/newpay.php");
		$newpay = new Newpay();
		$res_data = $newpay->pay($order, $dbo);
		//------------------------------
		//处理业务开始
		//------------------------------
		//echo "<pre>";print_r($res_data);exit;
		//注意交易单不要重复处理
		//注意判断返回金额
		if ($res_data['status'] == "success") { //
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
					} else {
						echo "<script>alert('支付成功，金币已经到账！');window.location.href='/main2.0.php?app=user_pay'</script>";
						exit;
					}
				}
			}
		} else {
			//echo "<script>alert('支付失败!（参数错误）请联系工作人员！');window.location.href='/main2.0.php?app=user_pay'</script>";exit;
			echo "<script>alert('Failure to pay;" . $res_data["err_msg"] . "');window.location.href='/main2.0.php?app=user_pay'</script>";
			exit;
		}
		//------------------------------
		//处理业务完毕
		//------------------------------
	}
} else {
	echo "<script>alert('" . $er_langpackage->er_rechargewill . "');location.href='/modules.php?app=user_pay';</script>";
	exit();
}
?>