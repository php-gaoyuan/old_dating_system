<?php
namespace app\index\controller;
use app\index\controller\Base;
class Fhtpay extends Base {
	private $merNo = '385888';//商户号
	private $terNo = '88816';//终端号
	private $CharacterSet = 'UTF8';//编码方式
	private $transType = 'sales';//交易类型
	private $transModel = 'M';//模式(固定值-M)
	private $hash = '037da39c69734c27b3c77893c40605f0';//哈希数字签名


	public function fhtpay() {
		//dump(i('get.'));exit;
		$order=[
			"card_number"=>input("card_number"),
			"exp_year"=>input("exp_year"),
			"exp_month"=>input("exp_month"),
			"cvv"=>input("cvv"),
			"order_sn"=>input("order_sn"),
			"user_id"=>input("user_id"),
			"email"=>input("email"),
			"amount"=>input("amount","0","floatval"),
		];
		$exp_date = $order["exp_year"]."-".$order["exp_month"];
		// $card_number = $order["card_number"];
		// $exp_year = $order["exp_year"];
		// $exp_month = $order["exp_month"];
		// $cvv = $order["cvv"];
		// $amount = floatval($order["amount"]);
		// $order_sn = $order["order_sn"];
		// $user_id = $order["user_id"];
		


		$language = $this->change_language($_COOKIE["think_var"]);
		//查询出邮箱


		// 验证过期时间和CVV
		if(!preg_match('/^\d{4}-\d{2}$/',$exp_date) && !preg_match('/^\d{3,4}$/',$cvv)){
			$this->error("有效期或者CVV错误");
		}
		// 验证信用卡号
		// $reg = '/^\d{15,19}$/';
		// if(!preg_match($reg,$order["card_number"])){
		// 	$this->error("卡号错误");
		// }
		$data = array(
			'apiType' => 4,//1普通接口、2 app、3快捷支付、4虚拟
			'amount' => $order["amount"],//消费金额
			'currencyCode' => 'USD',//消费币种-国际统一币种代码（三位）
			'orderNo' => $order["order_sn"],//网店订单号
			'merremark' => '',//订单备注参数,非必须
			'returnURL' => 'http://'.$_SERVER["HTTP_HOST"],//网店系统接收支付结果地址
			'merMgrURL' => 'http://'.$_SERVER["HTTP_HOST"],//网店的网址
			'webInfo' => "userAgent:".$_SERVER["HTTP_USER_AGENT"],//消费者浏览器信息
			'language' => $language,//支付页面默认显示的语言
			'payIP' => request()->ip(),//支付时持卡人网络的真实IP地址
			'grCountry' => 'US',//收货国家（国家代码-两位）
			'grState' => 'California',//收货州,非必须
			'grCity' => 'California',//收货城市
			'grAddress' => 'Moor Building 35274 State ST Fremont. U.S.A',//收货地址
			'grZipCode' => '434554',//收货邮编
			'grEmail' => $order["email"],//收货邮箱
			'grphoneNumber' => '181289182833',//收货人电话
			'grPerName' => 'FristName.LastName',//收货人姓名
			'goodsString' => '{"goodsInfo":[{"goodsName":"钢笔","quantity":"2","goodsPrice":"'.$order["amount"].'"}]}',//货物信息
			'cardNO' => $order["card_number"],//消费的信用卡卡号
			'cvv' => $order["cvv"],//信用卡背面的cvv
			'expYear' => $order["exp_year"],//信用卡有效期年份（4位）
			'expMonth' => $order["exp_month"],//信用卡有效期月份（2位）
			'cardCountry' => '',//账单签收国家（国家代码-两位）,非必须
			'cardState' => '',//账单签收州，非必须
			'cardCity' => '',//账单签收城市，非必须
			'cardAddress' => '',//账单签收人地址，非必须
			'cardZipCode' => '',//账单邮编，非必须
			'cardFullName' => '',//FristName.LastName (中间用点连接),非必须
			'ardFullPhone' => '',//持卡人电话，非必须
			'cardFullPhone' => '',//持卡人电话，非必须
		);
//dump($data);exit;
		$dataStr = $this->getPostDataStr($data);
		$url='https://payment.fhtpay.com/FHTPayment/api/payment';
		$res = $this->vpost($url,$dataStr);
		$obj = json_decode($res);
		dump($obj);exit;
		$code = $obj->respCode;
		file_put_contents("fhtpay.txt", "pc\n".var_export($obj,1)."\n\n",FILE_APPEND);
		$codeArr = array('1002','1003','1004','1005','1006','1016','2005');
		// 支付成功
		if($code == '00'){
			
		}else{
			echo "<script></script>";
		}
	}
	// 获取用户真实IP
	function getIP() {
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

	public function getPostDataStr($data) {
		$datapre = array('apiType' => $data['apiType'],'merremark' => $data['merremark'],'returnURL' => $data['returnURL'],'webInfo' => $data['webInfo'],
		'language' => $data['language'],'cardCountry' => $data['cardCountry'],'cardCity' => $data['cardCity'],
		'cardAddress' => $data['cardAddress'],'cardZipCode' => $data['cardZipCode'],'grCountry' => $data['grCountry'],'grState' => $data['grState'],
		'grCity' => $data['grCity'],'grAddress' => $data['grAddress'],'grZipCode' => $data['grZipCode'],'grEmail' => $data['grEmail'],
		'grphoneNumber' => $data['grphoneNumber'],'grPerName' => $data['grPerName'],'goodsString' => $data['goodsString'],'cardNO' => $data['cardNO'],
		'expYear' => $data['expYear'],'expMonth' => $data['expMonth'],'cvv' => $data['cvv'],'cardFullName' => $data['cardFullName'],
		'cardFullPhone' => $data['cardFullPhone'],'merMgrURL'=>$data['merMgrURL'],'cardState'=>$data['cardState'],'grState'=>$data['grState']);

		$arrHashCode=array('EncryptionMode' => 'SHA256','CharacterSet' => $this->CharacterSet,'merNo' => $this->merNo,'terNo' => $this->terNo,
		'orderNo' => $data['orderNo'],'currencyCode' => $data['currencyCode'],'amount' => $data['amount'],'payIP' => $data['payIP'],'transType' => $this->transType,
		'transModel' => $this->transModel);

		$strHashCode = $this->array2String($arrHashCode).$this->hash; // $hash是系统平台分配一串验签码

		$arrHashCode['hashcode'] = hash("sha256",$strHashCode);

		$strHashInfo = $this->array2String($arrHashCode);

		$strBaseInfo = $this->array2String($datapre);

		$post_data = $strBaseInfo.$strHashInfo; // 抛送的最终数据

		return $post_data;
	}
	/**
	* 功能：将数组转换成字符串
	* @param $arr 将要被转换的数组
	* @return string str 转换后的字符串
	*/
	public function array2String($arr = null){
		if(is_null($arr) or !is_array($arr))
		return false;
		$str = '';
		$arr_length = count($arr)-1;
		foreach( $arr as $key => $value ){
			$str.=$key.'='.$value.'&';
		}
		return urldecode($str); // 必须使用urldecode()方法处理明文字符串
	}
	/**
	* 功能：使用CURL方式抛送支付数据
	* @param $url 支付地址
	* @return $data 支付数据
	*/
	public function vpost($url, $data) {
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

	public function hpost($url, $data){
		$options = array(
		'http' => array('method' => "POST",'header' => "Accept-language: en\r\n" . "referer:$website \r\n",
		'content-type' => "multipart/form-data",'content' => $data,'timeout' => 15 * 60));
		$context = stream_context_create($options);
		// var_dump($options);exit;
		$result = file_get_contents($url, false, $context);
		return $result;
	}

	/*<option value="de">德国</option>
<option value="en_us">English</option>
<option value="fr">法语</option>
<option value="it">意大利</option>
<option value="jp">日本</option>
<option value="kr">韩国</option>
<option value="ne">尼日尔</option>
<option value="no">洛伊</option>
<option value="pt">葡萄牙语</option>
<option value="ru">俄语</option>
<option value="sp">西班牙</option>
<option value="zh_tw">繁體中文</option>
*/
	public function change_language(){
		$lang = $_COOKIE["think_var"];
		switch ($lang) {
			case 'zh-cn':
				$new_lang = "zh_cn";
				break;
			case 'zh-tw':
				$new_lang = "zh_tw";
				break;
			case 'en-us':
				$new_lang = "en_us";
				break;
			case 'ja':
				$new_lang = "jp";
				break;
			case 'ko-kr':
				$new_lang = "kr";
				break;
			case 'de':
				$new_lang = "de";
				break;
			case 'es':
				$new_lang = "sp";
				break;
			case 'fra':
				$new_lang = "fr";
				break;
			case 'it':
				$new_lang = "it";
				break;
			case 'nl':
				$new_lang = "ne";
				break;
			case 'pt':
				$new_lang = "pt";
				break;
			case 'ru':
				$new_lang = "ru";
				break;
			default:
				$new_lang = "en_us";
				break;
		}
		return $new_lang;
	}

}
?>