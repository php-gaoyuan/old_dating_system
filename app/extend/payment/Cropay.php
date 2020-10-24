<?php
namespace payment;
class Cropay {
	private $server_url = "https://gateway.cropay.com/Payment/payCredit.aspx";// 支付网关地址
	private $mch_id = '600684';
	private $hashkey = 'AeDWkEOIzF6VFqTEm7mLKolujcdv05oaJgoHTr51tepLz2ycv6ioDerm1iNiAsRDq5mycmT4btsG8I4pNba3XaFEXcOLMXAawUvCQ8ajmnnjVUntmyEzsWOqzRJaGirn';

//	private $mch_id = '105';
//	private $hashkey = 'SkKCUlfRiQxtajoRpPACePhloARbzirFAabg4QG3kfpVrXvd5Hj3hh2cdyotCer8y128hiWHjGs7zu3zeNe18xxsg7cFCmAgXqxz4v5XUKUKX3MREXpX8z8bDJ2ifrf5';


	public function pay($order) {
		//halt($order);
		$card_number = str_replace(" ", "", $order['card_number']);
		$exp_year = $order['exp_year'];
		$exp_month = $order['exp_month'];
		$cvv = $order['cvv'];
		$name = $order['name'];
		$country = $order['country'];
		$province = $order['province'];
		$city = $order['city'];
		$address = $order['address'];
		$email = $order['email'];
		$telephone = $order['telephone'];
		$post = $order['post'];


		$amount = floatval($order['amount']);
		$order_sn = $order['order_sn'];

		$language = $this->change_language();

		// 验证过期时间和CVV
		$exp_date = $exp_year."-".$exp_month;
		if(!preg_match('/^\d{4}-\d{2}$/',$exp_date) && !preg_match('/^\d{3,4}$/',$cvv)){
			//$this -> error(L('pattern_error'),'/',3);
		}
		// 验证信用卡号
		$reg = '/^\d{15,19}$/';
		if(!preg_match($reg,$card_number)){
			//$this -> error(L('pattern_error'),'/#home',3);
		}

		$hashKey = trim($this->hashkey); // 商户证书
		$merchant_id = trim($this->mch_id) * 818 + 5201314; // 商户号
		$merch_order_date = trim(date('YmdHis', time())); // 订单交易时间
		$merch_order_ori_id = trim($order_sn); // 商户原始订单号
		$merch_order_id = trim($merch_order_date . "-" . $merch_order_ori_id); // 商户订单号
		$price_currency = trim("USD"); // 订单标价币种
		$price_amount = trim($amount);

		$strValue = $hashKey . ($merchant_id - 5201314) / 818 . $merch_order_id . $price_currency . $price_amount;
		$signature = md5($this->filter_code($strValue));
		unset($strValue);


		// 获取唯一的id
		$charid = strtoupper ( md5 ( uniqid ( rand (), true ) ) ); // 根据当前时间（微秒计）生成唯一id.
		$hyphen = chr ( 45 );
		$uuid = substr ( $charid, 0, 8 ) . $hyphen . substr ( $charid, 8, 4 ) . $hyphen . substr ( $charid, 12, 4 ) . $hyphen . substr ( $charid, 16, 4 ) . $hyphen . substr ( $charid, 20, 12 );

		//$url_sync = "http://jyo.henangaodu.com/payment/newpay_notify.php";
		$data=array(
			//基本信息
			'merchant_id' => urlencode($merchant_id), // 商户号
			'order_type' => urlencode(trim("4")),
			'gw_version' => urlencode(trim("php(Z6.0)")), // 接口版本
			'language' => urlencode($language), // 接口语言
			'merch_order_ori_id' => urlencode($merch_order_ori_id), // 商户原始订单号
			'merch_order_date' => urlencode($merch_order_date), // 订单交易时间
			'merch_order_id' => urlencode($merch_order_id), // 接口版本
			'price_currency' => urlencode($price_currency), // 订单标价币种
			'price_amount' => urlencode($price_amount), // 订单标价金额
			'ip' => urlencode(trim($this->getIP())), // 接口版本
			'url_sync' => urlencode(trim('http://jyo.henangaodu.com/payment/newpay_notify.php')), // 服务器返回地址（订单状态同步地址）
			'url_succ_back' => urlencode(trim('http://jyo.henangaodu.com/payment/newpay_notify.php')), // 浏览器返回地址（成功订单返回地址）
			'url_fail_back' => urlencode(trim('http://' . $_SERVER['HTTP_HOST'] . '/index/payment/newpay_fail')), // 交易地址（失败订单返回地址）
			'url_referrer_domain' => $_SERVER['HTTP_HOST'],
			'order_remark' => urlencode(trim("")), // 备注

			//账单信息
			'bill_address' => (trim($address)), // 接口版本
			'bill_country' => (trim($country)), // 接口版本
			'bill_province' => (trim($province)), // 接口版本
			'bill_city' => (trim($city)), // 接口版本
			'bill_email' => (trim($email)), // 接口版本
			'bill_phone' => urlencode(trim($telephone)), // 接口版本
			'bill_post' => urlencode(trim($post)), // 接口版本

			//送货信息
			'delivery_name' => (trim($name)), // 接口版本
			'delivery_address' => (trim($address)), // 接口版本
			'delivery_country' => (trim($country)), // 接口版本
			'delivery_province' => (trim($province)), // 接口版本
			'delivery_city' => (trim($city)), // 接口版本
			'delivery_email' => (trim($email)), // 接口版本
			'delivery_phone' => urlencode(trim($telephone)), // 接口版本
			'delivery_post' => urlencode(trim($post)), // 接口版本

			//购物信息
			'product_name' => 'Upgrade deposits',
			'product_sn' => 'UOR-' . rand('100', '999'),
			'quantity' => '1',
			'unit' => $price_amount,

			//订单签名
			'signature' => urlencode(trim($signature)), // 签名

			//风控参数
			'client_finger_cybs' => urlencode(trim($uuid)), // 接口版本

			//信用卡信息
			'card_exp_year' => urlencode(trim($exp_year)), // 有效期年
			'card_exp_month' => urlencode(trim($exp_month)), // 有效期月
			'hash_num' => urlencode(trim($card_number)), // 信用卡号
			'hash_sign' => urlencode(trim($cvv)), // CVV
		);
		//echo "<pre>";print_r($data);exit;
		return $this->getPayRes($data);
	}

	private function getPayRes($data){
		header("Content-type:text/html; charset=utf-8");
		$response = $this->vpost($this->server_url, http_build_query($data));
		// 对得到的数据进行数据处理，修改商户网站的订单状态
		if ($response != "") {
			$xml = new \DOMDocument ();
			$xml->loadXML ( $response );
			$merchant_id = $xml->getElementsByTagName ( 'merchant_id' )->item ( 0 )->nodeValue;
			$merch_order_id = $xml->getElementsByTagName ( 'merch_order_id' )->item ( 0 )->nodeValue; // 带有前缀的商户订单号
			$merch_order_ori_id = $xml->getElementsByTagName ( 'merch_order_ori_id' )->item ( 0 )->nodeValue;
			$order_id = $xml->getElementsByTagName ( 'order_id' )->item ( 0 )->nodeValue;
			$price_currency = $xml->getElementsByTagName ( 'price_currency' )->item ( 0 )->nodeValue;
			$price_amount = $xml->getElementsByTagName ( 'price_amount' )->item ( 0 )->nodeValue;
			$status = $xml->getElementsByTagName ( 'status' )->item ( 0 )->nodeValue; // 真实商户订单号
			$message = $xml->getElementsByTagName ( 'message' )->item ( 0 )->nodeValue;
			$signature = $xml->getElementsByTagName ( 'signature' )->item ( 0 )->nodeValue;
			$payment_url = $xml->getElementsByTagName('payment_url')->item(0)->nodeValue;
			$check_bill_name_status = $xml->getElementsByTagName('check_bill_name_status')->item(0)->nodeValue;
			$allow1 = $xml->getElementsByTagName ( 'allow1' )->item ( 0 )->nodeValue;
			$payment_url = base64_decode($payment_url);

			$hashkey = trim($this->hashkey); // 商户证书
		    $strVale = $hashkey . $merchant_id . $merch_order_id . $price_currency . $price_amount . $order_id . $status;
		    $getsignature = md5($strVale);
		    if ($getsignature != $signature) {
		        die ('Signature error!');
		    }

			$str = "<br>支付网关反馈信息如下：<br>商户号：" . $merchant_id . "<br>商户订单号：" . $merch_order_ori_id . "<br>商户订单号：" . $merch_order_id . "<br>交易币种：" . $price_currency . "<br>交易金额：" . $price_amount . "<br>签名：" . $signature . "<br>系统流水号：" . $order_id . "<br>商户原始订单号：" . $order_id . "<br>订单状态：". $status  . "<br>payment_url：" . $payment_url. "<br>check_bill_name_status：" . $check_bill_name_status . "<br>返回信息：" . $message . "<br>allow1：" . $allow1;
			file_put_contents("cropay_app_pay.log",var_export($str,true)."\n",FILE_APPEND);
		    //echo $str;exit;
			// 以下是根据商户原始订单号来修改商户的订单状态
			if ($status == 'Y' || $status == "y") {
				$res = array(
					'errno'=>'0',
					'orderNo'=>$merch_order_ori_id,
					'amount'=>$price_amount,
					'msg'=>$message
				);
				return $res;
			}else if($status == "J" || $status == 'j'){
				$res = array(
					'errno'=>'2',
					'orderNo'=>$merch_order_ori_id,
					'amount'=>$price_amount,
					'msg'=>$message,
					'payment_url'=>$payment_url
				);
				return $res;
			}else{
				$res = array(
					'errno'=>'1',
					'order_sn'=>$merch_order_ori_id,
					'amount'=>$price_amount,
					'msg'=>$message
				);
				return $res;
			}
		} else { // 支付网关反馈的参数为空时
			echo "支付网关返回的参数为空，请联系商家，请不要重复提交。";exit;
		}
	}


	
	/**
	* 功能：使用CURL方式抛送支付数据
	* @param $url 支付地址
	* @return $data 支付数据
	*/
	private function vpost($url, $data) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($curl, CURLOPT_REFERER, $_SERVER['HTTP_HOST']);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_TIMEOUT, 300);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		$tmpInfo = curl_exec($curl);
		if (curl_errno($curl)) {
			return curl_errno($curl).'----'.curl_error($curl);
			//return 'php_curl is disabled!';
		}
		curl_close($curl);
		return $tmpInfo;
	}



	// 获取用户真实IP
	private function getIP() {
		if (getenv("HTTP_X_FORWARDED_FOR")) {
	    //这个提到最前面，作为优先级,nginx代理会获取到用户真实ip,发在这个环境变量上，必须要nginx配置这个环境变量HTTP_X_FORWARDED_FOR
			$ip = getenv("HTTP_X_FORWARDED_FOR");
	    } else if (getenv("REMOTE_ADDR")) {
		//在nginx作为反向代理的架构中，使用REMOTE_ADDR拿到的将会是反向代理的的ip，即拿到是nginx服务器的ip地址。往往表现是一个内网ip。
			$ip = getenv("REMOTE_ADDR");
		} else if ($_SERVER['REMOTE_ADDR']) {
			$ip = $_SERVER['REMOTE_ADDR'];
		} else if (getenv("HTTP_CLIENT_IP")) {
		//HTTP_CLIENT_IP攻击者可以伪造一个这样的头部信息，导致获取的是攻击者随意设置的ip地址。
			$ip = getenv("HTTP_CLIENT_IP");
		} else {
			$ip = "unknown";
		}
		return $ip;
	}

	public function change_language(){
		$lang = $_COOKIE["think_var"];
		switch ($lang) {
			case 'zh':
				$new_lang = "zh-cn";
				break;
			case 'fanti':
				$new_lang = "zh-tw";
				break;
			case 'en':
				$new_lang = "en-us";
				break;
			case 'ri':
				$new_lang = "ja-jp";
				break;
			case 'han':
				$new_lang = "ko-kr";
				break;
			case 'de':
				$new_lang = "de-de";
				break;
			case 'es':
				$new_lang = "es-es";
				break;
			case 'fra':
				$new_lang = "fr-fr";
				break;
			case 'it':
				$new_lang = "it-it";
				break;
			case 'pt':
				$new_lang = "pt-pt";
				break;
			default:
				$new_lang = "en-us";
				break;
		}
		return $new_lang;
	}


	private function filter_code($str) {
		if ($str == null || $str == "") {
			return "";
		} else {
			$str = str_split ( $str );
			for($ii = 0; $ii < count ( $str ); $ii ++) {
				if (ord ( $str [$ii] ) < 32 || ord ( $str [$ii] ) > 127) {
					$str [$ii] = '';
				}
			}
		}
		$str = implode ( '', $str );
		return $str;
	}

}
?>