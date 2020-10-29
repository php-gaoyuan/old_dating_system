<?php
//---------------------------------------------------------
//ipay_links即时到帐支付应答（处理回调）示例，商户按照此文档进行开发即可
//---------------------------------------------------------

//引入公共模块
require("api/base_support.php");
require("foundation/asession.php");
require("configuration.php");
require("includes.php");
$er_langpackage=new rechargelp;
$dbo = new dbex;
//读写分离定义函数
dbtarget('w',$dbServs);
/*array (
  'merchantBillName' => 'mijhola',
  'orderId' => 'S-P1482753230575',
  'resultCode' => '0000',
  'resultMsg' => 'The transaction has completed:交易成功',
  'orderAmount' => '3000',
  'currencyCode' => 'CNY',
  'settlementCurrencyCode' => '',
  'acquiringTime' => '20161226195350',
  'completeTime' => '20161226195354',
  'dealId' => '1021612261953321230',
  'partnerId' => '10000007615',
  'language' => '',
  'remark' => '',
  'charset' => '1',
  'signType' => '2',
  'signMsg' => '993716e285ccaf35c094ed700ddfe43c',
)*/

//------------------------------
//处理业务开始
//------------------------------

//注意交易单不要重复处理
//注意判断返回金额
$res_data = $_REQUEST;
$ordernumber = $res_data['orderId'];
if(is_array($res_data) && $res_data['resultCode'] == 0000 && $res_data['partnerId'] == 10000007615){
	echo "200";
	/*$sql="SELECT * FROM wy_balance WHERE ordernumber = '{$ordernumber}'";
	$row=$dbo->getRow($sql);

	if($row['state']  == 2){
		echo "<script>alert('该订单已经支付过了!');window.location.href='/main.php?app=user_paylog'</script>";exit;
	}
	if($res_data['orderAmount']/100 != $row['funds']){
		echo "<script>alert('支付金额出错!');window.location.href='/main.php?app=user_paylog'</script>";exit;
	}

	if($row['state'] != '2'){
		$sql = "UPDATE wy_balance SET `state`='2' WHERE ordernumber = '{$ordernumber}'";

		if($dbo->exeUpdate($sql)){
			$touid=$row['touid'];
			$sql = "UPDATE wy_users SET golds=golds+{$row['funds']} WHERE user_id='$touid'";
			if(!$dbo->exeUpdate($sql)){
				echo "<script>alert('支付成功，添加金币失败!请联系工作人员！');window.location.href='/main.php?app=user_paylog'</script>";exit;
				exit;
			}else{
				echo "<script>alert('支付成功，金币已经到账！');window.location.href='/main.php?app=user_paylog'</script>";exit;
			}

		}
	}*/
}		
//------------------------------
//处理业务完毕
//------------------------------	
header("localtion:/main.php?app=user_paylog");	
//file_put_contents("aaa.txt", var_export($_POST,true));


?>