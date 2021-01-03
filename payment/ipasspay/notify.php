<?php

header("content-type:text/html;charset=utf-8");
require("../../foundation/asession.php");
require("../../configuration.php");
require("../../includes.php");
require("../common.php");

require("../../{$langPackageBasePath}/paymentlp.php");
$paymentlp = new paymentlp();

$dbo = new dbex;
dbtarget('w', $dbServs);
file_put_contents("./ipasspay_notify.log",date("Y-m-d H:i:s").PHP_EOL.var_export($_POST,true).PHP_EOL,FILE_APPEND);

//获取通知信息
$request_data['merchant_id'] = $_POST['merchant_id'];
$request_data['app_id'] = $_POST['app_id'];
$request_data['order_no'] = $_POST['order_no'];
$request_data['gateway_order_no'] = $_POST['gateway_order_no'];
$request_data['order_currency'] = $_POST['order_currency'];
$request_data['order_amount'] = $_POST['order_amount'];
$request_data['order_available_amount'] = $_POST['order_available_amount'];
$request_data['order_settle_currency'] = $_POST['order_settle_currency'];
$request_data['order_settle_amount'] = $_POST['order_settle_amount'];
$request_data['pay_mode'] = $_POST['pay_mode'];
$request_data['syn_url'] = $_POST['syn_url'];
$request_data['pay_url'] = $_POST['pay_url'];
$request_data['custom_data'] = $_POST['custom_data'];
$request_data['billing_desc'] = $_POST['billing_desc'];
$request_data['order_status'] = $_POST['order_status'];
$request_data['signature'] = $_POST['signature'];
$request_data['errmsg'] = $_POST['errmsg'];

//封装验证信息
$order_no = $request_data['order_no'];
$gateway_order_no = $request_data['gateway_order_no'];
$order_currency = $request_data['order_currency'];
$order_amount = $request_data['order_amount'];
$order_status = $request_data['order_status'];

//配置信息
$api_secret = 'WT8hq0AlQE1n2s6e8tyzGxDGwmPP';
$merchant_id = '20122848102481453';
$app_id = '20122854485356664';
if (strpos($_SERVER['HTTP_HOST'],"www.")!==false){
    $app_id = "20122854555249663";
}

//验证信息
$signature = hash('sha256', $merchant_id . $app_id . $order_no . $gateway_order_no . $order_currency . $order_amount . $order_status . $api_secret);

if ($signature == $request_data['signature']) {
    //验证成功 处理业务逻辑
    switch ($order_status) {
        case '2':
        case '5':
            // TODO 支付成功业务逻辑处理
            $result = array(
                'status' => 'success',
                'ordernumber' => $order_no,
                'amount' => $order_amount,
                'out_trade_no' => $gateway_order_no,
                'err_msg' => $request_data['errmsg']
            );
            $sql = "SELECT * FROM wy_balance WHERE ordernumber = '{$order_no}'";
            $order = $dbo->getRow($sql, "arr");
            if ($order['type'] == 1) {
                $payRes = payRecharge($result, $dbo, $paymentlp);
            } elseif ($order['type'] == 2) {
                $payRes = payUpgrade($result, $dbo, $paymentlp);
            }
            break;
        case '3':
            //TODO 支付拒绝业务逻辑处理
            break;
        case '8':
            //TODO 已退款业务逻辑处理
            break;
        case '9':
            //TODO 已拒付业务逻辑处理
            break;
        case '10':
            //TODO 拒付撤销业务逻辑处理
            break;
        default:
            break;
    }
    //商户正确响应示例
    $res = array(
        'errcode' => '0',
        'errmsg' => 'success'
    );
} else {
    //验证失败
    $res = array(
        'errcode' => '1',
        'errmsg' => 'signer error'
    );
}
echo json_encode($res);
exit;

