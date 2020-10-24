<?php
header("content-type:text/html;charset=utf-8");
require("../foundation/asession.php");
require("../configuration.php");
require("../includes.php");
$dbo = new dbex;
//读写分离定义函数
dbtarget('w',$dbServs);




if (!empty($_GET) && empty($_POST)) {
    $_POST = $_GET;
}
unset($_GET);
if (empty($_POST)) {
    die('data error');
}
$_GET = $_POST;
$merchant_id = $_GET ['merchant_id'];
$merch_order_id = $_GET ['merch_order_id'];
$price_currency = $_GET ['price_currency'];
$price_amount = $_GET ['price_amount'];
$merch_order_ori_id = $_GET ['merch_order_ori_id'];
$order_id = $_GET ['order_id'];
$status = $_GET ['status'];
$message = $_GET ['message'];
$signature = $_GET ['signature'];
$hashkey = 'HsjuLrgOk5FV8f6y2N3QvBIDjEsx2aFKgZGQtowgF1HNjnTMUbjaLVOgSPlg8RUjA3PjIpeNrXkD33u5UPM10E8ulA7NdqhXhxnoHJeE6ESWKklYupvse1s44u7irzKa'; // 测试商户证书
$strVale = $hashkey . $merchant_id . $merch_order_id . $price_currency . $price_amount . $order_id . $status;
$getsignature = md5 ( $strVale );
if ($getsignature != $signature) {
	die ( 'Signature error!' );
}


// $merch_order_ori_id='S-P1543462560989';
// $price_amount = '200';
// $status = "Y";
//根据得到的数据  进行相对应的操作
if($status=='Y'){
	$sql="SELECT * FROM wy_balance WHERE ordernumber = '{$merch_order_ori_id}'";
	$row=$dbo->getRow($sql);

	if($row['state']  == 2){
		echo "<script>alert('该订单已经支付过了!');window.location.href='/main2.0.php?app=user_pay'</script>";exit;
	}
	if($price_amount != $row['funds']){
		echo "<script>alert('支付金额出错!');window.location.href='/main2.0.php?app=user_pay'</script>";exit;
	}

	if($row['state'] != '2'){
		$sql = "UPDATE wy_balance SET `state`='2' WHERE ordernumber = '{$merch_order_ori_id}'";

		if($dbo->exeUpdate($sql)){
			$touid=$row['touid'];
			$sql = "UPDATE wy_users SET golds=golds+{$row['funds']} WHERE user_id='$touid'";
			if(!$dbo->exeUpdate($sql)){
				echo "<script>alert('支付成功，添加金币失败!请联系工作人员！');window.location.href='/main2.0.php?app=user_pay'</script>";exit;
				exit;
			}else{
				echo "<script>alert('支付成功，金币已经到账！');window.location.href='/main2.0.php?app=user_pay'</script>";exit;
			}

		}
	}
	//echo 'ISRESPONSION';
	//echo ('交易成功');//可以跳转到指定的成功页面
	die;
}elseif($status=='T'){
	echo 'ISRESPONSION';
	echo ('交易处理中...........');//可以跳转到指定的成功页面
	die;
}else{
	echo 'ISRESPONSION';
	echo ('交易失败');//可以跳转到指定的成功页面
	die;
}
?>