<?php

class Yingfu
{
    protected $wintopayUrl = "https://stg-gateway.wintopay.com/api/v2/gateway/payment";//请求网关地址，查看接口文档
    protected $merchant_id = '70204';//商户号
    protected $md5key = 'Ak(SKe]rB2Yj';//密钥key
    protected $website = 'www.missinglovelove.com';

    public function pay($order)
    {
        $post_data = array();
        $post_data['merchantMID'] = $this->mchid;//商户号必填
        $post_data['newcardtype'] = '4';//客户的支付使用卡的类型3(jcb)，4（visa），5(master)
        $post_data['cardnum'] = base64_encode(str_replace(" ", "", trim($_POST['card_number'])));//BASE64Encoder加密过的卡号
        $post_data['cvv2'] = base64_encode($_POST['cvv']);//信用卡安全码BASE64Encoder
        $post_data['month'] = base64_encode($_POST['exp_date'][1]);//信用卡有效期（月份格式：MM）BASE64Encode
        $post_data['year'] = base64_encode($_POST['exp_date'][0]);//信用卡有效期（年份格式：YYYY）BASE64Encoder
        $post_data['BillNo'] = $order['out_trade_no'];//商户订单号
        $post_data['Amount'] = $order['price'];//订单金额
        $post_data['Currency'] = 1;//币种类型编号（整数）1(USD）,2(EUR),3(CNY),4(GBP),6(JPY),7(AUD),11(CAD)
        $post_data['Language'] = 'en';//支付语言（国家两位简码）默认：en
        $post_data['ReturnURL'] = 'http://' . $_SERVER['HTTP_HOST'] . '/wpay/results.php';//交易网站返回地址
        $str = $this->mchid . $post_data['BillNo'] . $post_data['Currency'] . $post_data['Amount'] . $post_data['Language'] . $post_data['ReturnURL'] . $this->key;
        $md5Str = md5($str);
        $post_data['HASH'] = strtoupper($md5Str);//merchantMID+BillNo +Currency +Amount +Language+ReturnURL+MD5key的md5加密串(大写)


//		echo $str."<br>";
//		echo $md5Str."<br>";
//		echo $post_data["HASH"]."<br>";
        //客户购物输入的信息：
        $post_data['shippingFirstName'] = $_POST['name'][0];//西方人名的第一个字
        $post_data['shippingLastName'] = $_POST['name'][1];//后面的名字
        $post_data['shippingEmail'] = $_POST['Email'];//邮箱
        $post_data['shippingPhone'] = $_POST['Phone'];//电话
        $post_data['shippingZipcode'] = $_POST['Zipcode'];//邮编
        $post_data['shippingAddress'] = $_POST['Address'];//地址
        $post_data['shippingCity'] = $_POST['City'];//地址城市
        $post_data['shippingSstate'] = $_POST['Sstate'];//区域
        $post_data['shippingCountry'] = $_POST['Country'];//国家简码（最后页附）

        //客户账单地址信息：
        $post_data['firstname'] = $_POST['name'][0];//西方人名的第一个字
        $post_data['lastname'] = $_POST['name'][1];//后面的名字
        $post_data['email'] = $_POST['Email'];//邮箱
        $post_data['phone'] = $_POST['Phone'];//电话
        $post_data['zipcode'] = $_POST['Zipcode'];//邮编
        $post_data['address'] = $_POST['Address'];//地址
        $post_data['city'] = $_POST['City'];//地址城市
        $post_data['state'] = $_POST['Sstate'];//区域
        $post_data['country'] = $_POST['Country'];//国家简码（最后页附）
        $post_data['ipAddr'] = $this->get_client_ip();//客户端IP
        $post_data['products'] = 'recharge';//通过商户网站抛送过来商品信息

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
            'sku' => '123',
            'name' => 'iPhone 12 Pro Max',
            'amount' => '688.99',
            'quantity' => '2',
            'currency' => 'USD'
        );
        $products[] = array(
            'sku' => '333',
            'name' => 'iPne 12 Pro Max',
            'amount' => '68.99',
            'quantity' => '6',
            'currency' => 'USD'
        );

        $total = isset($_REQUEST['amount']) ? $_REQUEST['amount'] : '';
        $currency = isset($_REQUEST['currency']) ? $_REQUEST['currency'] : '';

//卡信息
        $card_number = isset($_REQUEST['cardNum']) ? $_REQUEST['cardNum'] : '';
        $exp_month = isset($_REQUEST['month']) ? $_REQUEST['month'] : '';
        $exp_year = isset($_REQUEST['year']) ? $_REQUEST['year'] : '';
        $cvv = isset($_REQUEST['cvv']) ? $_REQUEST['cvv'] : '';

//支付语言，默认en
        $language = 'en';
//生成订单号
        $orderId = $merchant_id . date('YmdHis');
        $metadata = array(
            'site_id' => '5656',
            'site_url' => 'XXXXX'
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
            'ip' => getIP(),
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
            'card_number' => aesEncryptHex($this->md5key, $card_number),
            'exp_year' => aesEncryptHex($this->md5key, $exp_year),
            'exp_month' => aesEncryptHex($this->md5key, $exp_month),
            'cvv' => aesEncryptHex($this->md5key, $cvv),
            //HASH,商户号+md5Key+订单号+订单金额+订单币种+网站url，按照顺序拼接，计算SHA-256摘要值，并转为16进制字符串（小写）
            'hash' => sha256Encrypt($this->merchant_id . $this->md5key . $orderId . $total . $currency . $this->website),
            'version' => '20201001',
            'session_id' => $session_id,
            'metadata' => json_encode($metadata), //非必填,为空或者json数据
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ];
        foreach ($data as $key => $value) {
            if (empty($value)) {
                echo $key . " is empty,Pay fail!";
                return 0;
                break;
            }
        }
        $paymentResult = $this->payCurlPost($this->wintopayUrl, $merchant_id, $data, $website);
        //对返回结果进行解析处理,返回结果为json类型
        $result = json_decode($paymentResult, true);
        $str = $result['id'] . $result['status'] . $result['amount_value'] . $this->md5key . $this->merchant_id . $result['request_id'];
        if (sha256Encrypt($str) == $result['sign_verify']) { //验证返回信息
//            if($result['status'] == 'paid'){
//                echo 'payment success'.'<br>'; //支付成功
//            }
            return $result;
        }
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
        $website = !empty($website) ? $website : 'www.demo.com';
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