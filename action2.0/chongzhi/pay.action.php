<?php
//引入公共模块
require("api/base_support.php");
$er_langpackage=new rechargelp;

$dbo = new dbex;
//读写分离定义函数
dbtarget('w',$dbServs);

//ajax校验email和验证码
if(get_argg('ajax')==1){
	$user_name=get_argg("user_name");
	if($user_name){
		$sql="select user_group from wy_users where user_name='$user_name'";
		$user_info=$dbo->getRow($sql);
		if($user_info){
			if($user_info['user_group']=='base')
			{
				echo 0;
			}
			else
			{
				echo $user_info['user_group'];
			}
		}
	}
	exit;
}

$touser=get_argp("touser");
$user_id = get_sess_userid();
$user_name = get_sess_username();
$ordernumber='S-P'.time().mt_rand(100,999);
$zibi='';
if(get_argp("sxzibi"))
{
	$zibi=get_argp("sxzibi");
}
else
{
	$zibi=get_argp("zibi");
}

$dbo = new dbex;
//读写分离定义函数
dbtarget('w',$dbServs);
//echo $zibi;exit;
if($touser=='1')
{
	$touser=Api_Proxy("user_self_by_uid","user_group",$user_id);
	$sql="insert into wy_balance set type='1',uid='$user_id',uname='$user_name',touid='$user_id',touname='$user_name',message='给自己充值".$zibi."金币',state='0',addtime='".date('Y-m-d H:i:s')."',funds='$zibi',ordernumber='$ordernumber'";
	}
else if($touser=='2')
{
	if(get_argp("friends"))
	{
		$sql="select * from wy_users where user_name = '".get_argp("friends")."'";
		$touser=$dbo->getRow($sql);

		$sql="insert into wy_balance set type='1',uid='$user_id',uname='$user_name',touid='".$touser['user_id']."',touname='".$touser['user_name']."',message='给".$touser['user_name']."充值".$zibi."金币',state='0',addtime='".date('Y-m-d H:i:s')."',funds='$zibi',ordernumber='$ordernumber',tofpay=1";
	}
	else
	{
		echo "<script>alert('".$er_langpackage->er_userrecharge."');location.href='/modules.php?app=user_pay';</script>";
		exit();
	}
}

$sumoney=0;
switch ($touser['user_group'])
{
	/*case 1:
	  $sumoney=$zibi*95/100;
	  break;*/
	case 2:
	  //$sumoney=$zibi*95/100;
	   $sumoney=$zibi;
	  break;
	case 3:
	  //$sumoney=$zibi*9/10;
	   $sumoney=$zibi;
	  break;
	default:
	  $sumoney=$zibi;
}

$sql.=",money='$sumoney'";
//echo $sql;exit;
if($dbo->exeUpdate($sql))
{
	$order=array('out_trade_no'=>$ordernumber,'price'=>$sumoney);
	if(get_argp("zhifu")=='1')
	{
		require("payment/paypal.php");
		$pay=new Paypal;
		$pay->dsql=$dbo;
		$pay->return_url='http://www.pauzzz.com/do.php?act=paynotify';
		$button=$pay->GetCode($order,'annimeet@outlook.com');
		echo $button;
		echo "<script>location.href='/modules.php?app=user_pay';</script>";
	}else if(get_argp("zhifu")=='4'){
		
		require_once("payment/alipay/alipay.config.php");
		require_once("payment/alipay/lib/alipay_submit.class.php");
		
		/**************************请求参数**************************/

				//支付类型
				$payment_type = "1";
				//必填，不能修改
				//服务器异步通知页面路径
				$notify_url = "http://www.pauzzz.com";
				//需http://格式的完整路径，不能加?id=123这类自定义参数

				//页面跳转同步通知页面路径
				$return_url = "http://www.pauzzz.com/alipay_return.php";
				//需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

				//卖家支付宝帐户
				$seller_email = 'annimeet@outlook.com';
				//必填

				//商户订单号
				$out_trade_no = $ordernumber;
				//商户网站订单系统中唯一订单号，必填
				//支付宝充值费率转换
				$sumoney_alipay=$sumoney*6.23;
				//订单名称
				$subject = 'lovelove充值（$'.$sumoney.'）';
				//必填

				//付款金额
				$total_fee = $sumoney_alipay;
				//必填

				//订单描述

				$body = $_POST['WIDbody'];
				//商品展示地址
				$show_url = 'http://www.pauzzz.com';
				//需以http://开头的完整路径，例如：http://www.xxx.com/myorder.html

				//防钓鱼时间戳
				$anti_phishing_key = '';
				//若要使用请调用类文件submit中的query_timestamp函数

				//客户端的IP地址
				$exter_invoke_ip = '';
				//非局域网的外网IP地址，如：221.0.0.1


		/************************************************************/

		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service" => "create_direct_pay_by_user",
				"partner" => trim($alipay_config['partner']),
				"payment_type"	=> $payment_type,
				"notify_url"	=> $notify_url,
				"return_url"	=> $return_url,
				"seller_email"	=> $seller_email,
				"out_trade_no"	=> $out_trade_no,
				"subject"	=> $subject,
				"total_fee"	=> $total_fee,
				"body"	=> $body,
				"show_url"	=> $show_url,
				"anti_phishing_key"	=> $anti_phishing_key,
				"exter_invoke_ip"	=> $exter_invoke_ip,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);

		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		echo $html_text;
	}
	else if(get_argp("zhifu")=='2')
	{
		require_once ("action/chongzhi/classes/PayRequestHandler.class.php");

		//print_r($_SESSION);exit();
		/* 商户号 */
		$bargainor_id = "1216216401";

		/* 密钥 */
		$key = "657486f7ca712c34b831e31cadcd62ee";

		/* 返回处理地址 */
		$return_url = "http://www.pauzzz.com/do.php?act=tenpay_url";

		//date_default_timezone_set(PRC);
		$strDate = date("Ymd");
		$strTime = date("His");

		//4位随机数
		$randNum = rand(1000, 9999);

		//10位序列号,可以自行调整。
		$strReq = $strTime . $randNum;

		/* 商家订单号,长度若超过32位，取前32位。财付通只记录商家订单号，不保证唯一。 */
		$sp_billno = $ordernumber;

		/* 财付通交易单号，规则为：10位商户号+8位时间（YYYYmmdd)+10位流水号 */
		$transaction_id = $bargainor_id . $strDate . $strReq;

		/* 商品价格（包含运费），以分为单位 */
		$total_fee = $sumoney * 613;
		//echo $total_fee,'<br/>';
		//echo $sp_billno;exit;
		/* 商品名称 */
		$desc = "gold";

		/* 创建支付请求对象 */
		$reqHandler = new PayRequestHandler();
		//print_r($reqHandler);exit;
		$reqHandler->init();
		$reqHandler->setKey($key);

		//----------------------------------------
		//设置支付参数
		//----------------------------------------
		$reqHandler->setParameter("bargainor_id", $bargainor_id);			//商户号
		$reqHandler->setParameter("sp_billno", $sp_billno);					//商户订单号
		$reqHandler->setParameter("transaction_id", $transaction_id);		//财付通交易单号
		$reqHandler->setParameter("total_fee", $total_fee);					//商品总金额,以分为单位
		$reqHandler->setParameter("return_url", $return_url);				//返回处理地址
		$reqHandler->setParameter("desc", $desc);	//商品名称

		//用户ip,测试环境时不要加这个ip参数，正式环境再加此参数
		$reqHandler->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']);

		//请求的URL
		$reqUrl = $reqHandler->getRequestURL();

		//debug信息
		$debugInfo = $reqHandler->getDebugInfo();

		//echo "<br/>" . $reqUrl . "<br/>";exit;
		//echo "<br/>" . $debugInfo . "<br/>";
		//echo "<a href='{$reqUrl}' target='_blank'>财付通支付</a>";
		//重定向到财付通支付
	//	print_r($reqHandler->getAllParameters());exit;
		$reqHandler->doSend();
	}if(get_argp("zhifu")=='3'){
        
        //人民币网关账号，该账号为11位人民币网关商户编号+01,该参数必填。1002270652101
        $merchantAcctId = "1002270652101";
        //编码方式，1代表 UTF-8; 2 代表 GBK; 3代表 GB2312 默认为1,该参数必填。
        $inputCharset = "1";
        //接收支付结果的页面地址，该参数一般置为空即可。
        $pageUrl = "";
        //服务器接收支付结果的后台地址，该参数务必填写，不能为空。
        $bgUrl = "http://www.pauzzz.com/do.php?act=krecieve";
        //网关版本，固定值：v2.0,该参数必填。
        $version =  "v2.0";
        //语言种类，1代表中文显示，2代表英文显示。默认为1,该参数必填。
        $language =  "1";
        //签名类型,该值为4，代表PKI加密方式,该参数必填。
        $signType =  "4";
        //支付人姓名,可以为空。
        $payerName= ""; 
        //支付人联系类型，1 代表电子邮件方式；2 代表手机联系方式。可以为空。
        $payerContactType =  "1";
        //支付人联系方式，与payerContactType设置对应，payerContactType为1，则填写邮箱地址；payerContactType为2，则填写手机号码。可以为空。
        $payerContact =  "";
        //商户订单号，以下采用时间来定义订单号，商户可以根据自己订单号的定义规则来定义该值，不能为空。
        $orderId = $ordernumber;
        //订单金额，金额以“分”为单位，商户测试以1分测试即可，切勿以大金额测试。该参数必填。
        $orderAmount = $sumoney *613;
        //订单提交时间，格式：yyyyMMddHHmmss，如：20071117020101，不能为空。
        $orderTime = date("YmdHis");
        //商品名称，可以为空。
        $productName= "金币"; 
        //商品数量，可以为空。
        $productNum = "1";
        //商品代码，可以为空。
        $productId = "";
        //商品描述，可以为空。
		//echo $sumoney;exit;
        $productDesc = "";
        //扩展字段1，商户可以传递自己需要的参数，支付完快钱会原值返回，可以为空。
        $ext1 = "";
        //扩展自段2，商户可以传递自己需要的参数，支付完快钱会原值返回，可以为空。
        $ext2 = "";
        //支付方式，一般为00，代表所有的支付方式。如果是银行直连商户，该值为10，必填。
        $payType = "00";
        //银行代码，如果payType为00，该值可以为空；如果payType为10，该值必须填写，具体请参考银行列表。
        $bankId = "";
        //同一订单禁止重复提交标志，实物购物车填1，虚拟产品用0。1代表只能提交一次，0代表在支付不成功情况下可以再提交。可为空。
        $redoFlag = "";
        //快钱合作伙伴的帐户号，即商户编号，可为空。
        $pid = "";
        // signMsg 签名字符串 不可空，生成加密签名串

        function kq_ck_null($kq_va,$kq_na){if($kq_va == ""){$kq_va="";}else{return $kq_va=$kq_na.'='.$kq_va.'&';}}


        $kq_all_para=kq_ck_null($inputCharset,'inputCharset');
        $kq_all_para.=kq_ck_null($pageUrl,"pageUrl");
        $kq_all_para.=kq_ck_null($bgUrl,'bgUrl');
        $kq_all_para.=kq_ck_null($version,'version');
        $kq_all_para.=kq_ck_null($language,'language');
        $kq_all_para.=kq_ck_null($signType,'signType');
        $kq_all_para.=kq_ck_null($merchantAcctId,'merchantAcctId');
        $kq_all_para.=kq_ck_null($payerName,'payerName');
        $kq_all_para.=kq_ck_null($payerContactType,'payerContactType');
        $kq_all_para.=kq_ck_null($payerContact,'payerContact');
        $kq_all_para.=kq_ck_null($orderId,'orderId');
        $kq_all_para.=kq_ck_null($orderAmount,'orderAmount');
        $kq_all_para.=kq_ck_null($orderTime,'orderTime');
        $kq_all_para.=kq_ck_null($productName,'productName');
        $kq_all_para.=kq_ck_null($productNum,'productNum');
        $kq_all_para.=kq_ck_null($productId,'productId');
        $kq_all_para.=kq_ck_null($productDesc,'productDesc');
        $kq_all_para.=kq_ck_null($ext1,'ext1');
        $kq_all_para.=kq_ck_null($ext2,'ext2');
        $kq_all_para.=kq_ck_null($payType,'payType');
        $kq_all_para.=kq_ck_null($bankId,'bankId');
        $kq_all_para.=kq_ck_null($redoFlag,'redoFlag');
        $kq_all_para.=kq_ck_null($pid,'pid');
        

        $kq_all_para=substr($kq_all_para,0,strlen($kq_all_para)-1);

		//echo 123;
       // echo $inputCharset;
	   
        /////////////  RSA 签名计算 ///////// 开始 //
        $fp = fopen("action/chongzhi/kuaipay/99bill-rsa-lh.pem", "r");
		 
        $priv_key = fread($fp, 123456);
        fclose($fp);
		//echo '<input type="text" name="inputCharset" value="'.$inputCharset.'" />';
        $pkeyid = openssl_get_privatekey($priv_key);
		
        // compute signature
        openssl_sign($kq_all_para, $signMsg, $pkeyid,OPENSSL_ALGO_SHA1);

        // free the key from memory
        openssl_free_key($pkeyid);

         $signMsg = base64_encode($signMsg);
		
        /////////////  RSA 签名计算 ///////// 结束 //
?>
<?PHP echo $inputCharset; ?>
		<div align="center" style="font-weight: bold;display:block;">
		
			<form name="kqPay" action="https://www.99bill.com/gateway/recvMerchantInfoAction.htm" method="post">
				<input type="text" name="inputCharset" value="<?PHP echo $inputCharset; ?>" />
				<input type="hidden" name="pageUrl" value="<?PHP echo $pageUrl; ?>" />
				<input type="hidden" name="bgUrl" value="<?PHP echo $bgUrl; ?>" />
				<input type="hidden" name="version" value="<?PHP echo $version; ?>" />
				<input type="hidden" name="language" value="<?PHP echo $language; ?>" />
				<input type="hidden" name="signType" value="<?PHP echo $signType; ?>" />
				<input type="hidden" name="signMsg" value="<?PHP echo $signMsg; ?>" />
				<input type="hidden" name="merchantAcctId" value="<?PHP echo $merchantAcctId; ?>" />
				<input type="hidden" name="payerName" value="<?PHP echo $payerName; ?>" />
				<input type="hidden" name="payerContactType" value="<?PHP echo $payerContactType; ?>" />
				<input type="hidden" name="payerContact" value="<?PHP echo $payerContact; ?>" />
				<input type="hidden" name="orderId" value="<?PHP echo $orderId; ?>" />
				<input type="hidden" name="orderAmount" value="<?PHP echo $orderAmount; ?>" />
				<input type="hidden" name="orderTime" value="<?PHP echo $orderTime; ?>" />
				<input type="hidden" name="productName" value="<?PHP echo $productName; ?>" />
				<input type="hidden" name="productNum" value="<?PHP echo $productNum; ?>" />
				<input type="hidden" name="productId" value="<?PHP echo $productId; ?>" />
				<input type="hidden" name="productDesc" value="<?PHP echo $productDesc; ?>" />
				<input type="hidden" name="ext1" value="<?PHP echo $ext1; ?>" />
				<input type="hidden" name="ext2" value="<?PHP echo $ext2; ?>" />
				<input type="hidden" name="payType" value="<?PHP echo $payType; ?>" />
				<input type="hidden" name="bankId" value="<?PHP echo $bankId; ?>" />
				<input type="hidden" name="redoFlag" value="<?PHP echo $redoFlag; ?>" />
				<input type="hidden" name="pid" value="<?PHP echo $pid; ?>" />
				<input type="submit" name="submit2" value="提交到快钱">
			</form>
			<script LANGUAGE="javascript">
				window.onload=function(){
					
					document.kqPay.submit();
				}
			</script>
		</div>

<?php       
    }exit();
}
else
{
	echo "<script>alert('".$er_langpackage->er_rechargewill."');location.href='/modules.php?app=user_pay';</script>";
	exit();
}
?>