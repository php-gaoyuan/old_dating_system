<?php
/**
 * 回调请求方式为post表单请求
 */
header("content-type:text/html;charset=utf-8");
require("../../configuration.php");
require("../../includes.php");
require("../common.php");

require("../../{$langPackageBasePath}/paymentlp.php");
$paymentlp = new paymentlp();

//读写分离定义函数
$dbo = new dbex;
dbtarget('w', $dbServs);


$merchant_id = '5825';
$md5key      = 'PmB!hHiYOc=u';


//https://partyings.com/payment/yingfu/notify.php
$result = file_get_contents('php://input','r');
$data = json_decode($result,true);
file_put_contents("yingfu_pc_notify.log", date("Y-m-d H:i:s").PHP_EOL.var_export($data, 1) .PHP_EOL, FILE_APPEND);

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

$metadata = json_decode($data["metadata"],true);
$ordernumber = $metadata["ordernumber"];
//先记录返回的错误信息
$err_msg = htmlspecialchars($result['message']);
$sql = "UPDATE wy_balance SET `pay_msg`='{$err_msg}' WHERE ordernumber='{$ordernumber}'";
$dbo->exeUpdate($sql);

$str = $id.$status.$amount_value.$md5key.$merchant_id.$request_id;
if(sha256Encrypt($str) != $sign_verify){
    returnJs("sign error!");
}

if($status == 'paid'){
    $metadata = json_decode($metadata,true);
    //更新订单状态
    $result = array(
        'status' => 'success',
        'ordernumber' => $metadata['ordernumber'],
        'amount' => $amount_value/100,
        'out_trade_no' => $order_id,
        'err_msg' => $err_msg
    );
    $sql="SELECT * FROM wy_balance WHERE ordernumber = '{$ordernumber}'";
    $order=$dbo->getRow($sql,"arr");
    if($order['type'] == 1){
        $payRes = payRecharge($result,$dbo,$paymentlp);
    }elseif($order['type'] == 2){
        $payRes = payUpgrade($result,$dbo,$paymentlp);
    }
}
exit('[success]');
/**
 * HASH加密
 * @param $str
 */
function sha256Encrypt($str)
{
    return hash('sha256',$str);
}
