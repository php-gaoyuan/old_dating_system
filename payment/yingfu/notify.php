<?php
/**
 * 回调请求方式为post表单请求
 */
header("content-type:text/html;charset=utf-8");
require("../../configuration.php");
require("../../includes.php");

//读写分离定义函数
$dbo = new dbex;
dbtarget('w', $dbServs);


$merchant_id = '70204';
$md5key      = 'Ak(SKe]rB2Yj';

$result = file_get_contents('php://input','r');
$data = json_decode($result,true);
file_put_contents("yingfu_pc_notify.log", var_export($data, 1) . "\n\n", FILE_APPEND);


$id         = $data['id']; 			//流水号
$order_id   = $data['order_id'];	//订单号
$status     = $data['status'];		//支付状态
$currency   = $data['currency'];	//币种
$amount_value= $data['amount_value'];//金额，单位为 分
$metadata   = $data['metadata'];
$fail_code  = $data['fail_code'];
$fail_message= $data['fail_message'];
$request_id = $data['request_id'];
$sign_verify= $data['sign_verify']; //加密

$str = $id.$status.$amount_value.$md5key.$merchant_id.$request_id;
if(sha256Encrypt($str) != $sign_verify){
    returnJs("sign error!");
}

//https://partyings.com/payment/yingfu/notify.php
if($status == 'paid'){
    //更新订单状态
    $metadata = json_decode($data["metadata"],true);
    $ordernumber = $metadata["ordernumber"];
    $sql = "SELECT * FROM wy_balance WHERE ordernumber = '{$ordernumber}'";
    $row = $dbo->getRow($sql,"arr");
    if(empty($row)){
        returnJs("订单不存在!");
    }
    if ($row['state'] == 2) {
        returnJs("该订单已经支付过了!");
    }else {
        $sql = "UPDATE wy_balance SET `state`='2',`out_trade_no`='{$data['order_id']}' WHERE ordernumber = '{$ordernumber}'";
        if ($dbo->exeUpdate($sql)) {
            $touid = $row['touid'];
            $sql = "UPDATE wy_users SET golds=golds+{$row['money']} WHERE user_id='$touid'";
            if (!$dbo->exeUpdate($sql)) {
                returnJs("支付成功，添加金币失败!请联系工作人员!");
            } else {
                returnJs("支付成功，金币已经到账!");
            }
        }else{
            returnJs('[fail]');//支付失败
        }
    }
}else{
    returnJs($data['message']);//支付失败
}
/**
 * HASH加密
 * @param $str
 */
function sha256Encrypt($str)
{
    return hash('sha256',$str);
}


function returnJs($msg,$url=""){
    $url = !empty($url)?$url:'/main.php';
    echo "<script>alert('Payment Result:{$msg}');window.location.href='{$url}'</script>";
    exit();
}
