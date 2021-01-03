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

$hashkey = 'SkKCUlfRiQxtajoRpPACePhloARbzirFAabg4QG3kfpVrXvd5Hj3hh2cdyotCer8y128hiWHjGs7zu3zeNe18xxsg7cFCmAgXqxz4v5XUKUKX3MREXpX8z8bDJ2ifrf5'; // 测试商户证书


if (!empty($_GET) && empty($_POST)) {
    $_POST = $_GET;
}
unset($_GET);
if (empty($_POST)) {
    die('data error');
}
$_GET = $_POST;
$merchant_id = $_GET ['merchant_id'];
$merch_order_ori_id = $_GET ['merch_order_ori_id'];
$merch_order_id = $_GET ['merch_order_id'];
$bill_email = $_GET ['bill_email'];
$price_currency = $_GET ['price_currency'];
$price_amount = $_GET ['price_amount'];
$order_remark = $_GET ['order_remark'];
$order_id = $_GET ['order_id'];
$status = $_GET ['status'];
$message = $_GET ['message'];
$signature = $_GET ['signature'];



//先记录返回的错误信息
$sql = "UPDATE wy_balance SET `pay_msg`='{$message}' WHERE ordernumber='{$merch_order_ori_id}'";
$dbo->exeUpdate($sql);

$strVale = $hashkey . $merchant_id . $merch_order_id . $price_currency . $price_amount . $order_id . $status;
$getsignature = md5($strVale);
if ($getsignature != $signature) {
    die ('Signature error!');
}
$str = "<br>支付网关反馈信息如下：<br>商户号：" . $merchant_id . "<br>商户订单号：" . $merch_order_id . "<br>交易币种：" . $price_currency . "<br>交易金额：" . $price_amount . "<br>签名：" . $signature . "<br>系统流水号：" . $order_id . "<br>商户原始订单号：" . $order_id . "<br>订单状态：" . $status . "<br>返回信息：" . $message;
//echo $str;

//根据得到的数据  进行相对应的操作
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
returnJs($message);
?>