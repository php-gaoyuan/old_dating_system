<?php
header("content-type:text/html;charset=utf-8");
error_reporting(E_ALL);
require("../../foundation/asession.php");
require("../../configuration.php");
require("../../includes.php");
require("../common.php");

require("../../{$langPackageBasePath}/paymentlp.php");
$paymentlp = new paymentlp();

//读写分离定义函数
$dbo = new dbex;
dbtarget('w', $dbServs);
$order_no = $_GET["oid"];

$user_id = get_sess_userid();
$sql = "select * from wy_balance where uid={$user_id} and ordernumber='{$order_no}'";
$order = $dbo->getRow($sql, "arr");
if (empty($order)) {
    header("location:/");
    exit;
}
//获取用户邮箱
$user = $dbo->getRow("select user_email from wy_users where user_id={$user_id}", "arr");
//echo "<pre>";print_r($user);exit;
$Ipasspay = new Ipasspay();
$result = $Ipasspay->pay($order,$user);
//echo "<pre>";print_r($result);exit;
if ($result['status'] == 'success') {
    if ($order['type'] == 1) {
        $payRes = payRecharge($result, $dbo, $paymentlp);
    } elseif ($order['type'] == 2) {
        $payRes = payUpgrade($result, $dbo, $paymentlp);
    }
} else {
    $sql = "UPDATE wy_balance SET `pay_msg`='{$result['err_msg']}' WHERE ordernumber='{$order['ordernumber']}'";
    $dbo->exeUpdate($sql);
    $payRes = $result['err_msg'];
}
//echo "<pre>";print_r($payRes);exit;
returnJs("{$payRes}");


class Ipasspay
{
    //跳转网关地址 Host Gateway Url
    //product: https://service.ipasspay.biz/gateway/Index/checkout
    //sandbox: https://sandbox.service.ipasspay.biz/gateway/Index/checkout
    protected $gateway_url = 'https://service.ipasspay.biz/gateway/Index/checkout';
    protected $merchant_id = '1001184160520293580800';
    protected $app_id = "20122854485356664";
    protected $api_secret = 'WT8hq0AlQE1n2s6e8tyzGxDGwmPP';

    public function pay($order,$user)
    {
        if (strpos($_SERVER['HTTP_HOST'],"m.")!==false){
            $this->app_id = "20122848102481453";
        }else{
            if (strpos($_SERVER['HTTP_HOST'],"www.")!==false){
                $this->app_id = "20122854555249663";
            }
        }
        $protocol = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
        $curlPost['merchant_id'] = $this->merchant_id;
        $curlPost['app_id'] = $this->app_id;
        $curlPost['version'] = '2.0';

        //base info
        $curlPost['order_no'] = $order["ordernumber"];
        $curlPost['order_currency'] = 'USD';
        $curlPost['order_amount'] = sprintf("%.2f",$order["money"]); //请务必注意！！这里订单金额务必保留2位小数，否则会出现验签错误
        $curlPost['order_items'] = 'Iphone RX';

        //other info
        $curlPost['source_url'] = $protocol . $_SERVER['HTTP_HOST'];
        $curlPost['syn_notify_url'] = $protocol . $_SERVER['HTTP_HOST'] . '/payment/ipasspay/return.php';//同步
        $curlPost['asyn_notify_url'] = $protocol . $_SERVER['HTTP_HOST'] . '/payment/ipasspay/notify.php';//异步
        $curlPost['signature'] = hash('sha256', $curlPost['merchant_id'] . $curlPost['app_id'] . $curlPost['order_no'] . $curlPost['order_amount'] . $curlPost['order_currency'] . $this->api_secret);

        //bill info
        $curlPost['bill_email'] = $user['user_email'];
        $curlPost = http_build_query($curlPost);
        $gateway_host_url = $this->gateway_url."?".$curlPost;
        //echo "<pre>";print_r($gateway_host_url);exit;
        Header("HTTP/1.1 303 See Other");
        Header("Location: {$gateway_host_url}");
        exit;
    }
}

