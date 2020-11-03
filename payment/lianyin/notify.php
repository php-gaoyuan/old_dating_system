<?php
header("content-type:text/html;charset=utf-8");
require("../../foundation/asession.php");
require("../../configuration.php");
require("../../includes.php");
require("../common.php");

require("../../{$langPackageBasePath}/paymentlp.php");
$paymentlp = new paymentlp();

$dbo = new dbex;
dbtarget('w',$dbServs);

$hashkey = 'hCmThCjUpLRI6nmimJaQalckHEdzU7Nca8OJ8tce1b7HrAiZQTEi84t4zcmMzTaq7OI7HLi1G5Y7nE2gvmRbCFdfPSj6gzOibQJL1kreKMKdfuR4igqmb7WBLCrYCkVg'; // 测试商户证书


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

//先记录返回的错误信息
$sql = "UPDATE wy_balance SET `pay_msg`='{$message}' WHERE ordernumber='{$merch_order_ori_id}'";
$dbo->exeUpdate($sql);
file_put_contents("lianyin_pc_notify.log", date("Y-m-d H:i:s").PHP_EOL.var_export($_GET, 1) .PHP_EOL, FILE_APPEND);

$strVale = $hashkey . $merchant_id . $merch_order_id . $price_currency . $price_amount . $order_id . $status;
$getsignature = md5 ( $strVale );
if ($getsignature != $signature) {
	die ( 'Signature error!' );
}

//根据得到的数据  进行相对应的操作
if($status=='Y'){
    $result = array(
        'status' => 'success',
        'ordernumber' => $merch_order_ori_id,
        'amount' => $price_amount,
        'out_trade_no' => $order_id,
        'err_msg' => $message
    );
	$sql="SELECT * FROM wy_balance WHERE ordernumber = '{$merch_order_ori_id}'";
    $order=$dbo->getRow($sql,"arr");
    if($order['type'] == 1){
        $payRes = payRecharge($result,$dbo,$paymentlp);
    }elseif($order['type'] == 2){
        $payRes = payUpgrade($result,$dbo,$paymentlp);
    }
}
exit('ISRESPONSION');
?>