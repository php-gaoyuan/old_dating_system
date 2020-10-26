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


$merchant_id = '70204';
$md5key      = 'Ak(SKe]rB2Yj';


//https://partyings.com/payment/yingfu/notify.php
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

$metadata = json_decode($data["metadata"],true);
$ordernumber = $metadata["ordernumber"];
//先记录返回的错误信息
$sql = "UPDATE wy_balance SET `pay_msg`='{$result['message']}' WHERE ordernumber='{$ordernumber}'";
$dbo->exeUpdate($sql);

$str = $id.$status.$amount_value.$md5key.$merchant_id.$request_id;
if(sha256Encrypt($str) != $sign_verify){
    returnJs("sign error!");
}

if($status == 'paid'){
    //更新订单状态
    $result = array(
        'status' => 'success',
        'ordernumber' => $merch_order_ori_id,
        'amount' => $price_amount,
        'out_trade_no' => $order_id,
        'err_msg' => $message
    );
    $sql="SELECT * FROM wy_balance WHERE ordernumber = '{$ordernumber}'";
    $order=$dbo->getRow($sql,"arr");
    if($order['type'] == 1){
        $payRes = payRecharge($result,$dbo,$paymentlp);
    }elseif($order['type'] == 2){
        $payRes = payUpgrade($result,$dbo,$paymentlp);
    }
    exit('[success]');//支付失败
}else{
    exit('[fail]');//支付失败
}
/**
 * HASH加密
 * @param $str
 */
function sha256Encrypt($str)
{
    return hash('sha256',$str);
}
