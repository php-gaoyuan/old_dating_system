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
require_once("payment/alipay/alipay.config.php");
require_once("payment/alipay/lib/alipay_submit.class.php");



$user_id = get_sess_userid();
//echo $user_id;exit('Login');
//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();


//判断签名
if(verify_result) {
	
	//交易单号
	$ordernumber = $_GET['out_trade_no'];
	
	//支付宝交易号
	$trade_no = $_GET['trade_no'];
	
	//金额,以分为单位
	$total_fee = $_GET['total_fee'];
	//echo $total_fee;
	//交易状态
	$trade_status = $_GET['trade_status'];
	//echo $pay_result;
	if( $_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS' ) {
		
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

							if(!$dbo->exeUpdate($sql)){
								echo '添加金币失败';
								exit;
							}
	
						} else {
							exit('golds error');
						}
					}
					
					
					

		//------------------------------
		//处理业务完毕
		//------------------------------	
		header("localtion:/main.php?app=user_paylog");
	
	} else {
		//当做不成功处理
		echo "<br/>" . "支付失败" . "<br/>";
	}
	
} else {
	echo "<br/>" . "认证签名失败" . "<br/>";
}



?>