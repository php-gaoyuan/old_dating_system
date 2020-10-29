<?php

//---------------------------------------------------------
//财付通即时到帐支付应答（处理回调）示例，商户按照此文档进行开发即可
//---------------------------------------------------------
//exit(123);
//引入公共模块
require("api/base_support.php");
$er_langpackage=new rechargelp;
$dbo = new dbex;
//读写分离定义函数
dbtarget('w',$dbServs);
//print_r($dbo);exit();
require_once ("classes/PayResponseHandler.class.php");

/* 密钥 */
$key = "657486f7ca712c34b831e31cadcd62ee";
$user_id = get_sess_userid();
//echo $user_id;exit('Login');
/* 创建支付应答对象 */
$resHandler = new PayResponseHandler();

$resHandler->setKey($key);


//判断签名
if($resHandler->isTenpaySign()) {
	
	//交易单号
	$transaction_id = $resHandler->getParameter("transaction_id");
	//商品订单号
	$ordernumber = $resHandler->getParameter("sp_billno");
	
	//金额,以分为单位
	$total_fee = $resHandler->getParameter("total_fee");
	//echo $total_fee;
	//支付结果
	$pay_result = $resHandler->getParameter("pay_result");
	//echo $pay_result;
	if( "0" == $pay_result ) {
		
		//------------------------------
		//处理业务开始
		//------------------------------
		
		//注意交易单不要重复处理
		//注意判断返回金额
					$sql="SELECT * FROM wy_balance WHERE ordernumber = '{$ordernumber}'";
					//$row = $this->dsql->getRow($sql);
					$row=$dbo->getRow($sql);
					//print_r($row);exit();
					if($row['state'] != '2' || $row['state'] != 2)
					{
						$sql = "UPDATE wy_balance SET `state`='2' WHERE ordernumber = '{$ordernumber}'";
						if($dbo->exeUpdate($sql))
						{
						
						
							$touid=$row[touid];
							$sql = "UPDATE wy_users SET golds=golds+{$row['funds']} WHERE user_id='$touid'";
							//echo $sql;
							
						
							if(!$dbo->exeUpdate($sql)){
								echo '添加金币失败';
								exit;
							}
	
						} else {
							exit('sql语句执行失败！');
						}
					}
					
					
					

		//------------------------------
		//处理业务完毕
		//------------------------------	
		//http://zealdate.com/tenpay/return_url.php?attach=&bargainor_id=1216216401&cmdno=1&date=20130606&fee_type=1&pay_info=OK&pay_result=0&pay_time=1370496174&sign=04B2DC37BBEC7F210D53E83F4C58974B&sp_billno=1322325359&total_fee=1&transaction_id=1216216401201306061322325359&ver=1
		//调用doShow, 打印meta值跟js代码,告诉财付通处理成功,并在用户浏览器显示$show页面.
		$show = "http://www.pauzzz.com/do.php?act=tenpay_show";
		$resHandler->doShow($show);
	
	} else {
		//当做不成功处理
		echo "<br/>" . "支付失败" . "<br/>";
	}
	
} else {
	echo "<br/>" . "认证签名失败" . "<br/>";
}

//echo $resHandler->getDebugInfo();

?>