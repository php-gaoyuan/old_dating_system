<?php
namespace payment;
use app\common\model\Balance;
class Ipasspay{
    //跳转网关地址 Host Gateway Url
    //product: https://service.ipasspay.biz/gateway/Index/checkout
    //sandbox: https://sandbox.service.ipasspay.biz/gateway/Index/checkout
    protected $gateway_url = 'https://service.ipasspay.biz/gateway/Index/checkout';
    protected $merchant_id = '1001184160520293580800';
    protected $app_id = "20122854485356664";
    protected $api_secret = 'WT8hq0AlQE1n2s6e8tyzGxDGwmPP';

    public function pay($order)
    {
        $user_id = session("user_id");
        $user = db('users')->field("user_email")->find($user_id);

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
        $curlPost['syn_notify_url'] = $protocol . $_SERVER['HTTP_HOST'] . '/index/payment/returnUrl?code=ipasspay';//同步
        $curlPost['asyn_notify_url'] = $protocol . $_SERVER['HTTP_HOST'] . '/index/payment/notifyUrl?code=ipasspay';//异步
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

    public function notify(){

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

        //验证信息
        $signature = hash('sha256', $this->merchant_id . $this->app_id . $order_no . $gateway_order_no . $order_currency . $order_amount . $order_status . $this->api_secret);

        if ($signature == $request_data['signature'] && in_array($order_status,['2','5'])) {
            return true;
        }else{
            return false;
        }
    }
}
?>