<?php

namespace payment;
use app\common\model\Balance;
use app\common\model\UpgradeLog;

class Yingfu
{
    protected $wintopayUrl = "https://stg-gateway.wintopay.com/api/v2/gateway/payment";//请求网关地址，查看接口文档
    protected $merchant_id = '70204';//商户号
    protected $md5key = 'Ak(SKe]rB2Yj';//密钥key

    public function pay($order)
    {
        $website = 'www.missinglovelove.com';
//持卡人账单信息
        $billing_first_name = isset($_REQUEST['billing_first_name']) ? $_REQUEST['billing_first_name'] : '';
        $billing_last_name = isset($_REQUEST['billing_last_name']) ? $_REQUEST['billing_last_name'] : '';
        $billing_email = isset($_REQUEST['billing_email']) ? $_REQUEST['billing_email'] : '';
        $billing_country = isset($_REQUEST['billing_country']) ? $_REQUEST['billing_country'] : '';
        $billing_state = isset($_REQUEST['billing_state']) ? $_REQUEST['billing_state'] : '';
        $billing_city = isset($_REQUEST['billing_city']) ? $_REQUEST['billing_city'] : '';
        $billing_postal_code = isset($_REQUEST['billing_postal_code']) ? $_REQUEST['billing_postal_code'] : '';
        $billing_address = isset($_REQUEST['billing_address']) ? $_REQUEST['billing_address'] : '';
        $billing_phone = isset($_REQUEST['billing_phone']) ? $_REQUEST['billing_phone'] : '';

//收货地址,没有就保持和账单信息一致
        $shipping_first_name = !empty($_REQUEST['shipping_first_name']) ? $_REQUEST['shipping_first_name'] : $billing_first_name;
        $shipping_last_name = !empty($_REQUEST['shipping_last_name']) ? $_REQUEST['shipping_last_name'] : $billing_last_name;
        $shipping_email = !empty($_REQUEST['shipping_email']) ? $_REQUEST['shipping_email'] : $billing_email;
        $shipping_country = !empty($_REQUEST['shipping_country']) ? $_REQUEST['shipping_country'] : $billing_country;
        $shipping_state = !empty($_REQUEST['shipping_state']) ? $_REQUEST['shipping_state'] : $billing_state;
        $shipping_city = !empty($_REQUEST['shipping_city']) ? $_REQUEST['shipping_city'] : $billing_city;
        $shipping_postal_code = !empty($_REQUEST['shipping_postal_code']) ? $_REQUEST['shipping_postal_code'] : $billing_postal_code;
        $shipping_address = !empty($_REQUEST['shipping_address']) ? $_REQUEST['shipping_address'] : $billing_address;
        $shipping_phone = !empty($_REQUEST['shipping_phone']) ? $_REQUEST['shipping_phone'] : $billing_phone;

//session_id
        $session_id = isset($_REQUEST['session_id']) ? $_REQUEST['session_id'] : '';

//商品信息
        $products[] = array(
            'sku' => '',
            'name' => $order['type'] == 1 ? 'recharge' : 'upgrade',
            'amount' => $order['money'],
            'quantity' => '1',
            'currency' => 'USD'
        );

        $total = $order['money'];
        $currency = 'USD';

//卡信息
        $card_number = isset($_REQUEST['cardNum']) ? $_REQUEST['cardNum'] : '';
        $exp_month = isset($_REQUEST['month']) ? $_REQUEST['month'] : '';
        $exp_year = isset($_REQUEST['year']) ? $_REQUEST['year'] : '';
        $cvv = isset($_REQUEST['cvv']) ? $_REQUEST['cvv'] : '';

//支付语言，默认en
        $language = 'en';
//生成订单号
        $orderId = $this->merchant_id . date('YmdHis');
        $metadata = array(
            'ordernumber' => $order['ordernumber']
        );
        $data = [
            'billing_first_name' => $billing_first_name,
            'billing_last_name' => $billing_last_name,
            'billing_email' => $billing_email,
            'billing_phone' => $billing_phone,
            'billing_postal_code' => $billing_postal_code,
            'billing_address' => $billing_address,
            'billing_city' => $billing_city,
            'billing_state' => $billing_state,
            'billing_country' => $billing_country,
            //获取客户ip
            'ip' => $this->getIP(),
            'products' => json_encode($products), //json类型
            'shipping_first_name' => $shipping_first_name,
            'shipping_last_name' => $shipping_last_name,
            'shipping_email' => $shipping_email,
            'shipping_phone' => $shipping_phone,
            'shipping_postal_code' => $shipping_postal_code,
            'shipping_address' => $shipping_address,
            'shipping_city' => $shipping_city,
            'shipping_state' => $shipping_state,
            'shipping_country' => $shipping_country,
            //商户号
            'merchant_id' => $this->merchant_id,
            'language' => $language,
            'currency' => $currency,
            'amount' => $total,
            'order_id' => $orderId,
            //卡信息
            'card_number' => $this->aesEncryptHex($this->md5key, $card_number),
            'exp_year' => $this->aesEncryptHex($this->md5key, $exp_year),
            'exp_month' => $this->aesEncryptHex($this->md5key, $exp_month),
            'cvv' => $this->aesEncryptHex($this->md5key, $cvv),
            //HASH,商户号+md5Key+订单号+订单金额+订单币种+网站url，按照顺序拼接，计算SHA-256摘要值，并转为16进制字符串（小写）
            'hash' => $this->sha256Encrypt($this->merchant_id . $this->md5key . $orderId . $total . $currency . $website),
            'version' => '20201001',
            'session_id' => $session_id,
            'metadata' => json_encode($metadata), //非必填,为空或者json数据
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ];
//echo "<pre>";print_r($data);exit;
        $paymentResult = $this->payCurlPost($this->wintopayUrl, $this->merchant_id, $data, $website);
//对返回结果进行解析处理,返回结果为json类型
        $result = json_decode($paymentResult, true);
        file_put_contents("yingfu_wap_return.log", var_export($result, 1) . "\n\n", FILE_APPEND);
//echo "<pre>";print_r($result);exit;
        $str = $result['id'] . $result['status'] . $result['amount_value'] . $this->md5key . $this->merchant_id . $result['request_id'];
        if ($this->sha256Encrypt($str) != $result['sign_verify']) { //验证返回信息
            returnJs("sign error!");
        }

        if ($result['status'] == 'paid') {
            $payRes = array(
                'status' => 'success',
                'ordernumber' => $order['ordernumber'],
                'amount' => $order['money'],
                'out_trade_no' => $result['order_id'],
                'err_msg' => $result['message']
            );
        } else {
            $payRes = $result['message'];
        }
        return $payRes;//支付成功
    }


    //获取用户ip
    private function getIP()
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $online_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $online_ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_REAL_IP'])) {
            $online_ip = $_SERVER['HTTP_X_REAL_IP'];
        } else {
            $online_ip = $_SERVER['REMOTE_ADDR'];
        }
        $ips = explode(",", $online_ip);
        return $ips[0];
    }

    /**
     *
     * @param string $url 请求地址
     * @param string $merchant_id 商户号
     * @param array $data 请求参数
     * @param string $website referer
     * @return string
     */
    private function payCurlPost($url, $merchant_id, $data, $website)
    {
        //设置referer
        $website = !empty($website) ? $website : 'www.missinglovelove.com';
        //请求头设置
        $headers = array(
            'MerNo:' . $merchant_id,
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_REFERER, $website);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        $data = curl_exec($ch);
        if ($data === false) {
            echo 'Curl error: ' . curl_error($ch);
        }
        curl_close($ch);
        return $data;
    }

    /**
     *卡信息加密
     * @param string $string 需要加密的字符串
     * @param string $md5key 商户md5key
     * @return string
     */
    private function aesEncryptHex($md5key, $string)
    {
        $key = substr(openssl_digest(openssl_digest($md5key, 'sha1', true), 'sha1', true), 0, 16);

        $data = openssl_encrypt($string, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
        $data = strtolower(bin2hex($data));

        return $data;
    }

    /**
     * HASH加密
     * @param $str
     */
    private function sha256Encrypt($str)
    {
        return hash('sha256', $str);
    }
}

?>